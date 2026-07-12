<?php

namespace App\Services\ProgramImport;

use App\Data\ProgramImport\ProgramData;
use App\Data\ProgramImport\ProgramImageData;
use RuntimeException;

/**
 * Parser for the project's tours-data.md "## ITEM" block format, including
 * the structured `images` / `image_match` blocks added by the image-matching
 * phase. The file is NOT valid YAML as a whole; this parser understands
 * exactly the shapes the file uses:
 *
 *   - key: scalar
 *   - key: |            (multiline block: overview, map_frame)
 *   - key:              (list: "    - value" lines follow)
 *   - images: null      (unmatched records)
 *   - images:           (nested cover/gallery maps)
 *   - image_match:      (nested map with evidence list)
 */
class ToursDataParser
{
    private const LIST_FIELDS = ['highlights', 'included', 'excluded', 'itinerary', 'languages'];

    /** @return list<ProgramData> */
    public function parse(string $path): array
    {
        if (! is_file($path)) {
            throw new RuntimeException("Source file not found: {$path}");
        }

        $content = file_get_contents($path);
        $blocks = preg_split('/^##\s+ITEM\s*$/m', $content);
        $records = [];
        $index = 0;

        foreach ($blocks as $block) {
            $block = trim($block, "\r\n");
            if (trim($block) === '' || str_starts_with(trim($block), '#')) {
                continue; // file header
            }
            $records[] = $this->parseBlock($block, $index++);
        }

        return $records;
    }

    /**
     * Validate structural expectations for the current dataset.
     *
     * @param  list<ProgramData>  $records
     * @return list<string> problems (empty when valid)
     */
    public function validate(array $records, ?string $publicBasePath = null, bool $verifyHashes = true): array
    {
        $problems = [];
        $counts = ['tour' => 0, 'activity' => 0, 'trekking' => 0];
        $matched = 0;

        foreach ($records as $r) {
            if (! isset($counts[$r->section])) {
                $problems[] = "record {$r->index}: unknown section '{$r->section}'";

                continue;
            }
            $counts[$r->section]++;

            if ($r->title === '') {
                $problems[] = "record {$r->index}: missing title";
            }

            if ($r->hasImages()) {
                $matched++;
                foreach (['cover' => $r->cover, 'gallery' => $r->gallery] as $role => $img) {
                    if (! str_starts_with($img->path, 'assets/images/programs/')) {
                        $problems[] = "record {$r->index} ({$r->title}) {$role}: unexpected path prefix";
                    }
                    if (! str_ends_with(strtolower($img->filename), '.webp')) {
                        $problems[] = "record {$r->index} ({$r->title}) {$role}: not a .webp file";
                    }
                    if ($publicBasePath !== null) {
                        $abs = rtrim($publicBasePath, '/\\').DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $img->path);
                        if (! is_file($abs)) {
                            $problems[] = "record {$r->index} ({$r->title}) {$role}: file missing on disk: {$img->path}";
                        } elseif ($verifyHashes && hash_file('sha256', $abs) !== $img->sha256) {
                            $problems[] = "record {$r->index} ({$r->title}) {$role}: SHA-256 mismatch for {$img->path}";
                        }
                    }
                }
            } elseif ($r->cover !== null || $r->gallery !== null) {
                $problems[] = "record {$r->index} ({$r->title}): incomplete images block (needs both cover and gallery)";
            }
        }

        return $problems;
    }

    private function parseBlock(string $block, int $index): ProgramData
    {
        $lines = preg_split('/\r\n|\r|\n/', $block);
        $fields = [];
        $key = null;
        $mode = null; // 'block' | 'list' | 'nested'
        $buf = [];

        $flush = function () use (&$fields, &$key, &$mode, &$buf) {
            if ($key === null) {
                return;
            }
            $fields[$key] = match ($mode) {
                'block' => rtrim(implode("\n", $buf)),
                'list' => $buf,
                'nested' => $this->parseNested($buf),
                default => $buf,
            };
            $key = $mode = null;
            $buf = [];
        };

        foreach ($lines as $line) {
            if (preg_match('/^- ([a-z_]+):\s?(.*)$/', $line, $m)) {
                $flush();
                $name = $m[1];
                $value = trim($m[2]);

                if ($value === '|') {
                    [$key, $mode, $buf] = [$name, 'block', []];
                } elseif ($value === '' && in_array($name, ['images', 'image_match'], true)) {
                    [$key, $mode, $buf] = [$name, 'nested', []];
                } elseif ($value === '') {
                    [$key, $mode, $buf] = [$name, 'list', []];
                } else {
                    $fields[$name] = $value;
                }

                continue;
            }

            if ($mode === 'block') {
                $buf[] = preg_replace('/^ {0,4}/', '', $line);

                continue;
            }

            if ($mode === 'nested') {
                $buf[] = $line;

                continue;
            }

            if ($mode === 'list' && preg_match('/^\s+-\s+(.*)$/', $line, $m)) {
                $val = trim($m[1]);
                if ($val !== '') {
                    $buf[] = $val;
                }
            }
        }
        $flush();

        return $this->toProgramData($fields, $index);
    }

    /**
     * Parse the indented lines of an `images:` or `image_match:` block into a
     * nested array. Handles maps, quoted scalars, numbers, booleans, null and
     * "- " list items (gallery entries, evidence strings).
     *
     * @param  list<string>  $lines
     */
    private function parseNested(array $lines): array
    {
        $root = [];
        // stack of [indent, &container]
        $stack = [[0, &$root]];
        $lastKeyAtIndent = [];

        foreach ($lines as $line) {
            if (trim($line) === '') {
                continue;
            }
            $indent = strlen($line) - strlen(ltrim($line));
            $trim = trim($line);

            // pop stack to current indent
            while (count($stack) > 1 && $indent < $stack[count($stack) - 1][0]) {
                array_pop($stack);
            }
            $container = &$stack[count($stack) - 1][1];

            if (str_starts_with($trim, '- ')) {
                // list item: either scalar ("- \"evidence\"") or start of a map ("- path: ...")
                $rest = substr($trim, 2);
                if (preg_match('/^([a-z_0-9]+):\s?(.*)$/', $rest, $m)) {
                    $item = [];
                    $item[$m[1]] = $this->scalar(trim($m[2]));
                    $container[] = &$item;
                    // subsequent "key: value" lines at indent+2 belong to this item
                    $stack[] = [$indent + 2, &$item];
                    unset($item);
                } else {
                    $container[] = $this->scalar($rest);
                }

                continue;
            }

            if (preg_match('/^([a-z_0-9]+):\s?(.*)$/', $trim, $m)) {
                $k = $m[1];
                $v = trim($m[2]);
                if ($v === '') {
                    // nested map or list follows
                    $container[$k] = [];
                    $stack[] = [$indent + 2, &$container[$k]];
                } else {
                    $container[$k] = $this->scalar($v);
                }
            }
        }

        return $root;
    }

    private function scalar(string $v): mixed
    {
        if ($v === 'null') {
            return null;
        }
        if ($v === 'true') {
            return true;
        }
        if ($v === 'false') {
            return false;
        }
        if (preg_match('/^-?\d+$/', $v)) {
            return (int) $v;
        }
        if (preg_match('/^-?\d*\.\d+$/', $v)) {
            return (float) $v;
        }
        if (strlen($v) >= 2 && $v[0] === '"' && str_ends_with($v, '"')) {
            return str_replace('\\"', '"', substr($v, 1, -1));
        }

        return $v;
    }

    private function toProgramData(array $f, int $index): ProgramData
    {
        // Empty scalars parse as empty lists; coerce non-list fields back.
        foreach ($f as $k => $v) {
            if (is_array($v) && $v === [] && ! in_array($k, [...self::LIST_FIELDS, 'images', 'image_match'], true)) {
                $f[$k] = '';
            }
        }
        foreach (self::LIST_FIELDS as $k) {
            if (! isset($f[$k]) || $f[$k] === '') {
                $f[$k] = [];
            } elseif (is_string($f[$k])) {
                $f[$k] = array_values(array_filter(array_map('trim', explode(',', $f[$k]))));
            }
        }

        $bool = fn ($v) => in_array(strtolower((string) $v), ['true', '1', 'yes'], true);

        $images = $f['images'] ?? null;
        if ($images === 'null' || $images === '' || $images === []) {
            $images = null;
        }
        $cover = null;
        $gallery = null;
        if (is_array($images)) {
            if (isset($images['cover']) && is_array($images['cover']) && $images['cover'] !== []) {
                $cover = ProgramImageData::fromArray($images['cover']);
            }
            $galleryItems = $images['gallery'] ?? [];
            if (is_array($galleryItems) && isset($galleryItems[0]) && is_array($galleryItems[0])) {
                $gallery = ProgramImageData::fromArray($galleryItems[0]);
            }
        }

        $match = is_array($f['image_match'] ?? null) ? $f['image_match'] : [];

        return new ProgramData(
            index: $index,
            section: (string) ($f['section'] ?? ''),
            type: ($f['type'] ?? '') !== '' ? $f['type'] : null,
            title: (string) ($f['title'] ?? ''),
            category: (string) ($f['category'] ?? ''),
            location: (string) ($f['location'] ?? ''),
            overview: (string) ($f['overview'] ?? ''),
            highlights: $f['highlights'],
            duration: (string) ($f['duration'] ?? ''),
            groupSize: (string) ($f['group_size'] ?? ''),
            ageRange: (string) ($f['age_range'] ?? ''),
            basePrice: (string) ($f['base_price'] ?? ''),
            languages: $f['languages'],
            included: $f['included'],
            excluded: $f['excluded'],
            itinerary: $f['itinerary'],
            bestseller: $bool($f['bestseller'] ?? ''),
            freeCancellation: $bool($f['free_cancellation'] ?? ''),
            mapFrame: ($f['map_frame'] ?? '') !== '' ? $f['map_frame'] : null,
            cover: $cover,
            gallery: $gallery,
            matchStatus: (string) ($match['status'] ?? 'unmatched-record'),
            matchConfidence: (float) ($match['confidence'] ?? 0),
            matchEvidence: array_values(array_filter((array) ($match['evidence'] ?? []), 'is_string')),
            matchReviewNotes: is_string($match['review_notes'] ?? null) ? $match['review_notes'] : null,
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Base seeder: parses tours-data.md (in the project root) into an array of
 * items, and provides helpers the Tour / Activity / Trekking seeders reuse.
 *
 * The MD format is the "## ITEM" block layout produced during content
 * extraction. Fields map 1:1 to the tours / activities / trekking tables.
 */
abstract class TourDataSeeder extends Seeder
{
    /** Section this concrete seeder handles: tour | activity | trekking */
    abstract protected function section(): string;

    /** Eloquent model class for this section's table (used for slug uniqueness). */
    abstract protected function modelClass(): string;

    /**
     * Parse the markdown file and return only the items for this section.
     */
    protected function items(): array
    {
        $path = base_path('tours-data.md');

        if (! is_file($path)) {
            $this->command?->warn("tours-data.md not found at {$path} — skipping.");
            return [];
        }

        $model  = $this->modelClass();
        $blocks = preg_split('/^##\s+ITEM\s*$/m', file_get_contents($path));
        $items  = [];

        foreach ($blocks as $block) {
            $block = trim($block);
            if ($block === '') {
                continue;
            }

            $item = $this->parseBlock($block);

            if (($item['section'] ?? null) === $this->section() && ! empty($item['title'])) {
                // Skip items already present (makes the seeder safely re-runnable).
                if ($model::where('title', $item['title'])->exists()) {
                    continue;
                }
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Parse a single "## ITEM" block into an associative array.
     *
     * Scalars: `- key: value`
     * Multiline (overview / map_frame): `- key: |` then indented lines.
     * Lists (highlights / included / excluded / itinerary / languages):
     *   `- key:` then `    - value` lines.
     */
    protected function parseBlock(string $block): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $block);
        $item  = [];
        $key   = null;      // current field being filled
        $mode  = null;      // 'block' | 'list'
        $buf   = [];

        $flush = function () use (&$item, &$key, &$mode, &$buf) {
            if ($key === null) {
                return;
            }
            if ($mode === 'block') {
                $item[$key] = rtrim(implode("\n", $buf));
            } elseif ($mode === 'list') {
                $item[$key] = $buf;
            }
            $key = $mode = null;
            $buf = [];
        };

        foreach ($lines as $line) {
            // New top-level field: "- key: ..." (exactly two leading spaces or none)
            if (preg_match('/^- ([a-z_]+):\s?(.*)$/', $line, $m)) {
                $flush();
                $name  = $m[1];
                $value = trim($m[2]);

                if ($value === '|') {
                    $key = $name;
                    $mode = 'block';
                    $buf = [];
                } elseif ($value === '') {
                    // Could be a list (indented "- " lines follow) or an empty scalar.
                    $key = $name;
                    $mode = 'list';
                    $buf = [];
                } else {
                    $item[$name] = $value;
                }
                continue;
            }

            // Indented continuation lines.
            if ($mode === 'block') {
                // Strip the 4-space indent used for block scalars.
                $buf[] = preg_replace('/^ {0,4}/', '', $line);
                continue;
            }

            if ($mode === 'list' && preg_match('/^\s+-\s+(.*)$/', $line, $m)) {
                $val = trim($m[1]);
                if ($val !== '') {
                    $buf[] = $val;
                }
                continue;
            }
        }

        $flush();

        return $this->normalize($item);
    }

    /**
     * Coerce parsed strings into the shapes the DB columns expect.
     */
    protected function normalize(array $item): array
    {
        // A field with an empty value parses as an empty list ([]). For scalar
        // fields (group_size, age_range, base_price, etc.) that empty list must
        // become an empty string so downstream checks and casts behave.
        $listFields = ['highlights', 'included', 'excluded', 'itinerary', 'languages'];
        foreach ($item as $key => $value) {
            if (is_array($value) && $value === [] && ! in_array($key, $listFields, true)) {
                $item[$key] = '';
            }
        }

        // Ensure list fields are always arrays.
        foreach ($listFields as $field) {
            if (! isset($item[$field]) || $item[$field] === '') {
                $item[$field] = [];
            } elseif (is_string($item[$field])) {
                // A comma-separated scalar slipped in — split it.
                $item[$field] = array_values(array_filter(array_map('trim', explode(',', $item[$field]))));
            }
        }

        // Booleans.
        foreach (['bestseller', 'free_cancellation'] as $field) {
            $item[$field] = isset($item[$field])
                && in_array(strtolower((string) $item[$field]), ['true', '1', 'yes'], true);
        }

        return $item;
    }

    /**
     * Build the shared column payload common to all three tables.
     * $categoryId / $locationId are resolved by the concrete seeder.
     */
    protected function basePayload(array $item, int $categoryId, ?int $locationId): array
    {
        return [
            'title'                  => $item['title'],
            'slug'                   => $this->uniqueSlug($item['title']),
            'overview'               => $item['overview'] ?? '',
            // highlights is stored as text (not array-cast on the models) — encode manually.
            'highlights'             => json_encode($item['highlights']),
            'duration'               => $item['duration'] ?? '',
            'group_size'             => ($item['group_size'] ?? '') !== '' ? $item['group_size'] : null,
            'age_range'              => ($item['age_range'] ?? '') !== '' ? $item['age_range'] : '',
            'base_price'             => ($item['base_price'] ?? '') !== '' ? (float) $item['base_price'] : 0,
            'bestseller_flag'        => $item['bestseller'],
            'free_cancellation_flag' => $item['free_cancellation'],
            'map_frame'              => ($item['map_frame'] ?? '') !== '' ? $item['map_frame'] : null,
            // These four ARE array-cast on the models — pass raw arrays, Eloquent encodes them.
            'included'               => $item['included'],
            'excluded'               => $item['excluded'],
            'itinerary'              => $item['itinerary'],
            'languages'              => $item['languages'],
            'category_id'            => $categoryId,
            'location_id'            => $locationId,
            'created_at'             => now(),
            'updated_at'             => now(),
        ];
    }

    /** Generate a slug unique across this run AND existing rows in the table. */
    protected function uniqueSlug(string $title): string
    {
        static $used = [];

        $model = $this->modelClass();
        $base  = Str::slug($title);
        $slug  = $base;
        $i     = 1;

        while (in_array($slug, $used, true) || $model::where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }

        $used[] = $slug;

        return $slug;
    }
}

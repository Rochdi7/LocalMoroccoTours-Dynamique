<?php

namespace App\Services\ProgramImport;

use App\Data\ProgramImport\ProgramImageData;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

/**
 * Attaches program images to Spatie Media Library collections with strict
 * duplicate-prevention and preservation of any pre-existing media.
 *
 * Every media item this importer creates carries custom properties:
 *   managed_by = programs-import
 *   seed_key   = programs-import:{section}:{slug}:{collection}:{sha256}
 * which later runs (and the rollback command) use for identification.
 */
class ProgramMediaImporter
{
    public const MANAGED_BY = 'programs-import';

    public function __construct(
        private readonly string $publicBasePath,
    ) {}

    public function seedKey(string $section, string $slug, string $collection, string $sha256): string
    {
        return self::MANAGED_BY.":{$section}:{$slug}:{$collection}:{$sha256}";
    }

    /**
     * Validate a source image file without touching the database.
     *
     * @return list<string> problems (empty when valid)
     */
    public function validateSource(ProgramImageData $image): array
    {
        $problems = [];
        $abs = $this->absolutePath($image->path);

        $publicReal = realpath($this->publicBasePath);
        $fileReal = realpath($abs);

        if ($fileReal === false) {
            return ["file not found: {$image->path}"];
        }
        if ($publicReal === false || ! str_starts_with($fileReal, $publicReal.DIRECTORY_SEPARATOR)) {
            return ["path escapes public directory: {$image->path}"];
        }
        if (! is_readable($fileReal)) {
            $problems[] = "file not readable: {$image->path}";
        }
        $head = (string) file_get_contents($fileReal, false, null, 0, 12);
        if (! (str_starts_with($head, 'RIFF') && substr($head, 8, 4) === 'WEBP')) {
            $problems[] = "not a WebP file: {$image->path}";
        }
        if (hash_file('sha256', $fileReal) !== $image->sha256) {
            $problems[] = "SHA-256 mismatch: {$image->path}";
        }

        return $problems;
    }

    /**
     * Decide what would happen for this image without writing anything.
     *
     * @param  Model&\Spatie\MediaLibrary\HasMedia  $model
     * @return array{action: string, reason: string}
     */
    public function plan(
        Model $model,
        string $collection,
        ProgramImageData $image,
        string $seedKey,
        bool $onlyMissingMedia = false,
        bool $replaceSeedMedia = false,
    ): array {
        $existing = $model->getMedia($collection);

        foreach ($existing as $media) {
            if ($media->getCustomProperty('seed_key') === $seedKey) {
                return ['action' => 'skip-identical-seed', 'reason' => 'identical seed media already attached'];
            }
        }
        foreach ($existing as $media) {
            if ($media->getCustomProperty('source_sha256') === $image->sha256) {
                return ['action' => 'skip-same-checksum', 'reason' => 'media with same checksum already in collection'];
            }
        }

        if ($existing->isEmpty()) {
            return ['action' => 'attach', 'reason' => 'collection empty'];
        }

        // Collection holds different media.
        if ($onlyMissingMedia) {
            return ['action' => 'skip-existing', 'reason' => 'collection not empty (--only-missing-media)'];
        }

        $seedManaged = $existing->filter(
            fn ($m) => $m->getCustomProperty('managed_by') === self::MANAGED_BY
        );
        $manual = $existing->reject(
            fn ($m) => $m->getCustomProperty('managed_by') === self::MANAGED_BY
        );

        if ($manual->isNotEmpty()) {
            return ['action' => 'skip-manual', 'reason' => 'manually uploaded media present - preserved'];
        }
        if ($seedManaged->isNotEmpty()) {
            return $replaceSeedMedia
                ? ['action' => 'replace-seed', 'reason' => 'different seed media will be replaced (--replace-seed-media)']
                : ['action' => 'conflict-seed', 'reason' => 'different seed-managed media present; use --replace-seed-media to replace'];
        }

        return ['action' => 'skip-existing', 'reason' => 'existing media preserved'];
    }

    /**
     * Attach the image (apply mode only). Returns the created media ID.
     *
     * @param  Model&\Spatie\MediaLibrary\HasMedia  $model
     * @return array{media_id: int, replaced_media_ids: list<int>}
     */
    public function attach(
        Model $model,
        string $collection,
        ProgramImageData $image,
        string $seedKey,
        float $matchConfidence,
        bool $replaceSeed = false,
    ): array {
        $problems = $this->validateSource($image);
        if ($problems !== []) {
            throw new RuntimeException('Source validation failed: '.implode('; ', $problems));
        }

        $replacedIds = [];
        if ($replaceSeed) {
            foreach ($model->getMedia($collection) as $media) {
                if ($media->getCustomProperty('managed_by') === self::MANAGED_BY) {
                    $replacedIds[] = $media->id;
                    $media->delete();
                }
            }
        }

        $media = $model
            ->addMedia($this->absolutePath($image->path))
            ->preservingOriginal() // never move/delete the source under public/assets
            ->usingName($image->title !== '' ? $image->title : pathinfo($image->filename, PATHINFO_FILENAME))
            ->usingFileName($image->filename)
            ->withCustomProperties([
                'alt' => $image->alt,
                'title' => $image->title,
                'caption' => $image->caption,
                'description' => $image->description,
                'source_path' => $image->path,
                'source_sha256' => $image->sha256,
                'seed_key' => $seedKey,
                'managed_by' => self::MANAGED_BY,
                'replacement_recommended' => $image->replacementRecommended,
                'source_warning' => $image->sourceWarning,
                'image_match_confidence' => $matchConfidence,
            ])
            ->toMediaCollection($collection, 'public');

        return ['media_id' => $media->id, 'replaced_media_ids' => $replacedIds];
    }

    private function absolutePath(string $relativePath): string
    {
        return rtrim($this->publicBasePath, '/\\')
            .DIRECTORY_SEPARATOR
            .str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    }
}

<?php

namespace App\Services\ProgramImport;

use App\Data\ProgramImport\ProgramData;
use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\Location;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\Trekking;
use App\Models\TrekkingCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * Imports parsed tours-data.md records into the tours / activities / trekking
 * tables and attaches cover + gallery media for confidently matched records.
 *
 * Safe by default:
 *  - dry-run performs zero writes,
 *  - existing non-empty values are never overwritten unless --update-content,
 *  - base_price, booked_count, rating, reviews are NEVER written on update,
 *  - existing media is preserved (see ProgramMediaImporter policies).
 */
class ProgramImporter
{
    /** Minimum image_match confidence required to attach media. */
    public const MIN_MEDIA_CONFIDENCE = 0.80;

    private const SECTION_MODEL = [
        'tour' => Tour::class,
        'activity' => Activity::class,
        'trekking' => Trekking::class,
    ];

    private const SECTION_CATEGORY = [
        'tour' => TourCategory::class,
        'activity' => ActivityCategory::class,
        'trekking' => TrekkingCategory::class,
    ];

    public function __construct(
        private readonly ProgramMediaImporter $mediaImporter,
        private readonly ProgramImportReporter $reporter,
    ) {}

    /**
     * @param  list<ProgramData>  $records
     * @param  array{dry_run: bool, sections: list<string>, slug: ?string, only_new: bool,
     *                only_missing_media: bool, replace_seed_media: bool, update_content: bool,
     *                limit: ?int}  $options
     */
    public function run(array $records, array $options): void
    {
        $processed = 0;

        foreach ($records as $record) {
            if ($options['sections'] !== [] && ! in_array($record->section, $options['sections'], true)) {
                continue;
            }
            $slug = Str::slug($record->title);
            if ($options['slug'] !== null && $slug !== $options['slug']) {
                continue;
            }
            if ($options['limit'] !== null && $processed >= $options['limit']) {
                break;
            }
            $processed++;

            try {
                $this->processRecord($record, $slug, $options);
            } catch (Throwable $e) {
                $this->reporter->record($record, $slug, 'failed', [
                    'errors' => ['unexpected: '.$e->getMessage()],
                ]);
            }
        }
    }

    private function processRecord(ProgramData $record, string $slug, array $options): void
    {
        $dryRun = $options['dry_run'];
        $modelClass = self::SECTION_MODEL[$record->section] ?? null;
        if ($modelClass === null) {
            $this->reporter->record($record, $slug, 'failed', ['errors' => ["unknown section '{$record->section}'"]]);

            return;
        }

        /** @var Model|null $existing */
        $existing = $modelClass::where('slug', $slug)->first();
        $detail = ['destination_model' => class_basename($modelClass)];

        // Slug miss: a normalized-title match is a conflict needing review, not an auto-merge.
        if ($existing === null) {
            $titleMatch = $modelClass::query()
                ->get(['id', 'title', 'slug'])
                ->first(fn ($m) => $this->normalizeTitle($m->title) === $this->normalizeTitle($record->title));
            if ($titleMatch !== null) {
                $this->reporter->record($record, $slug, 'conflict', $detail + [
                    'warnings' => ["no slug match but normalized title equals existing record (slug '{$titleMatch->slug}') - review manually, not auto-merged"],
                ]);

                return;
            }
        }

        if ($existing !== null) {
            if ($options['only_new']) {
                $this->reporter->record($record, $slug, 'skipped', $detail + [
                    'record_id' => $existing->id,
                    'notes' => 'exists (--only-new)',
                ]);
                $this->handleMedia($record, $slug, $existing, $options, $detail);

                return;
            }
            $this->updateExisting($record, $slug, $existing, $options, $detail);
        } else {
            $existing = $this->createNew($record, $slug, $options, $detail);
            if ($existing === null && $dryRun) {
                // dry-run create: no model to attach media to; report the plan only
                $this->reportMediaPlanForNewRecord($record, $slug);

                return;
            }
            if ($existing === null) {
                return; // creation failed; already reported
            }
        }

        $this->handleMedia($record, $slug, $existing, $options, $detail);
    }

    private function updateExisting(ProgramData $record, string $slug, Model $model, array $options, array $detail): void
    {
        $fillable = $this->buildFillOnlyMissing($record, $model, $options['update_content']);

        $mergedItinerary = $this->mergeItineraryDescriptions($record, $model->getAttribute('itinerary'));
        if ($mergedItinerary === false) {
            $detail['warnings'] = ['itinerary_details day count does not match existing itinerary - descriptions not merged'];
        } elseif ($mergedItinerary !== null) {
            $fillable['itinerary'] = $mergedItinerary;
        }

        if ($fillable === []) {
            $this->reporter->record($record, $slug, 'skipped', $detail + [
                'record_id' => $model->id,
                'notes' => 'existing record; nothing to fill',
            ]);

            return;
        }

        if ($options['dry_run']) {
            $this->reporter->record($record, $slug, 'would-update', $detail + [
                'record_id' => $model->id,
                'notes' => 'fields to fill: '.implode(', ', array_keys($fillable)),
            ]);

            return;
        }

        DB::transaction(function () use ($model, $fillable) {
            $model->fill($fillable)->save();
        });

        $this->reporter->record($record, $slug, 'updated', $detail + [
            'record_id' => $model->id,
            'notes' => 'filled: '.implode(', ', array_keys($fillable)),
        ]);
    }

    /**
     * Only fill columns whose current DB value is empty. Never touches
     * base_price, booked_count, rating, reviews_count or media.
     * With $updateContent, content fields may be replaced by non-empty source
     * values (but never blanked by empty source values).
     */
    private function buildFillOnlyMissing(ProgramData $record, Model $model, bool $updateContent): array
    {
        $source = $this->sourceContentFields($record, $model);
        $fill = [];

        foreach ($source as $column => $value) {
            $isEmptySource = $value === null || $value === '' || $value === [];
            if ($isEmptySource) {
                continue; // never write empty over anything
            }
            $current = $model->getAttribute($column);
            $isEmptyCurrent = $current === null || $current === '' || $current === []
                || (is_string($current) && in_array(trim($current), ['[]', '""'], true));

            if ($isEmptyCurrent || ($updateContent && $current != $value)) {
                $fill[$column] = $value;
            }
        }

        return $fill;
    }

    /** Source values shaped for the given model, following existing seeder conventions. */
    private function sourceContentFields(ProgramData $record, Model $model): array
    {
        // NOTE: itinerary is deliberately absent - it is handled exclusively by
        // mergeItineraryDescriptions() so day titles are never overwritten and
        // descriptions are only ever ADDED.
        $fields = [
            'overview' => $record->overview,
            'duration' => $record->duration,
            'group_size' => $record->groupSize !== '' ? $record->groupSize : null,
            'map_frame' => $record->mapFrame,
            'included' => $record->included,
            'excluded' => $record->excluded,
            'languages' => $record->languages,
        ];

        // highlights: Tour stores JSON text (no cast); Activity/Trekking cast to array.
        $fields['highlights'] = $model->hasCast('highlights', 'array')
            ? $record->highlights
            : json_encode($record->highlights);
        if ($record->highlights === []) {
            $fields['highlights'] = null; // treated as empty source, never written
        }

        if ($model instanceof Tour) {
            $fields['type'] = in_array($record->type, ['day_trip', 'multi_day'], true) ? $record->type : null;
        }

        return $fields;
    }

    /**
     * Additive itinerary enrichment. Existing day TITLES are never changed and
     * existing non-empty descriptions are never replaced; descriptions from
     * tours-data.md itinerary_details are only ADDED where missing.
     *
     * @param  mixed  $current  the model's current itinerary attribute
     * @return array|null|false merged array when something was added, null when
     *                          nothing to do, false when day counts conflict
     */
    private function mergeItineraryDescriptions(ProgramData $record, mixed $current): array|null|false
    {
        $current = is_array($current) ? $current : [];
        if ($current === []) {
            // empty DB itinerary: fill from source (with descriptions when aligned)
            if ($record->itinerary === []) {
                return null;
            }

            return $this->buildItineraryPayload($record);
        }
        if ($record->itineraryDetails === []) {
            return null;
        }
        if (count($record->itineraryDetails) !== count($current)) {
            return false;
        }

        $changed = false;
        $merged = [];
        foreach (array_values($current) as $i => $entry) {
            $title = is_array($entry) ? (string) ($entry['title'] ?? '') : (string) $entry;
            $content = is_array($entry) ? ($entry['content'] ?? null) : null;
            if (($content === null || $content === '') && $record->itineraryDetails[$i]['description'] !== '') {
                $content = $record->itineraryDetails[$i]['description'];
                $changed = true;
            }
            $merged[] = $content !== null && $content !== ''
                ? ['title' => $title, 'content' => $content]
                : $title;
        }

        return $changed ? $merged : null;
    }

    /** Itinerary column payload for new/empty records: titles + descriptions when aligned. */
    private function buildItineraryPayload(ProgramData $record): array
    {
        if ($record->itineraryDetails !== []
            && count($record->itineraryDetails) === count($record->itinerary)) {
            return array_map(
                fn ($title, $d) => ['title' => $title, 'content' => $d['description']],
                $record->itinerary,
                $record->itineraryDetails,
            );
        }

        return $record->itinerary;
    }

    private function createNew(ProgramData $record, string $slug, array $options, array $detail): ?Model
    {
        $modelClass = self::SECTION_MODEL[$record->section];
        $categoryClass = self::SECTION_CATEGORY[$record->section];

        $categoryExists = $categoryClass::where('name', $record->category)->exists();
        $locationName = $record->location !== '' ? $record->location
            : ($record->section === 'tour' ? 'Morocco' : null);
        $locationExists = $locationName === null || Location::where('name', $locationName)->exists();

        if ($options['dry_run']) {
            $this->reporter->record($record, $slug, 'would-create', $detail + [
                'category_action' => $categoryExists ? 'existing' : "would-create: {$record->category}",
                'location_action' => $locationName === null ? 'none'
                    : ($locationExists ? 'existing' : "would-create: {$locationName}"),
            ]);

            return null;
        }

        return DB::transaction(function () use ($record, $slug, $modelClass, $categoryClass, $locationName, $categoryExists, $locationExists, $detail) {
            $category = $categoryClass::firstOrCreate(
                ['name' => $record->category],
                ['slug' => Str::slug($record->category)]
            );
            $location = null;
            if ($locationName !== null) {
                $location = Location::firstOrCreate(
                    ['name' => $locationName],
                    ['slug' => Str::slug($locationName)]
                );
            }

            $payload = [
                'title' => $record->title,
                'slug' => $slug,
                'overview' => $record->overview,
                'duration' => $record->duration,
                'group_size' => $record->groupSize !== '' ? $record->groupSize : null,
                'age_range' => $record->ageRange, // NOT NULL column; blank source stays ''
                'base_price' => $record->basePrice !== '' ? (float) $record->basePrice : 0,
                'bestseller_flag' => $record->bestseller,
                'free_cancellation_flag' => $record->freeCancellation,
                'map_frame' => $record->mapFrame,
                'included' => $record->included,
                'excluded' => $record->excluded,
                'itinerary' => $this->buildItineraryPayload($record),
                'languages' => $record->languages,
                'category_id' => $category->id,
                'location_id' => $location?->id,
            ];

            $model = new $modelClass;
            $payload['highlights'] = $model->hasCast('highlights', 'array')
                ? $record->highlights
                : json_encode($record->highlights);

            if ($model instanceof Tour) {
                $payload['type'] = in_array($record->type, ['day_trip', 'multi_day'], true)
                    ? $record->type : 'multi_day';
            }
            if ($model instanceof Trekking) {
                $payload['difficulty_level'] = 'Moderate'; // source has no difficulty; schema requires one
            }

            $model->fill($payload)->save();

            $this->reporter->record($record, $slug, 'created', $detail + [
                'record_id' => $model->id,
                'category_action' => $categoryExists ? 'existing' : "created: {$record->category}",
                'location_action' => $locationName === null ? 'none'
                    : ($locationExists ? 'existing' : "created: {$locationName}"),
            ]);
            $this->reporter->trackCreatedRecord($model);
            if (! $categoryExists) {
                $this->reporter->trackCreatedSupport($category);
            }
            if ($locationName !== null && ! $locationExists && $location !== null) {
                $this->reporter->trackCreatedSupport($location);
            }

            return $model;
        });
    }

    private function handleMedia(ProgramData $record, string $slug, Model $model, array $options, array $detail): void
    {
        if (! $record->hasImages()) {
            $this->reporter->media($record, $slug, 'cover', 'no-source-media', 'record has no matched images');
            $this->reporter->media($record, $slug, 'gallery', 'no-source-media', 'record has no matched images');

            return;
        }
        if ($record->matchConfidence < self::MIN_MEDIA_CONFIDENCE) {
            $this->reporter->media($record, $slug, 'cover', 'media-skipped', "match confidence {$record->matchConfidence} below ".self::MIN_MEDIA_CONFIDENCE);
            $this->reporter->media($record, $slug, 'gallery', 'media-skipped', 'match confidence too low');

            return;
        }

        $images = ['cover' => $record->cover];
        if ($record->gallery !== null) {
            $images['gallery'] = $record->gallery;
        } else {
            $this->reporter->media($record, $slug, 'gallery', 'no-source-media', 'record has cover only, no gallery image');
        }

        foreach ($images as $collection => $image) {
            $problems = $this->mediaImporter->validateSource($image);
            if ($problems !== []) {
                $this->reporter->media($record, $slug, $collection, 'failed', implode('; ', $problems));

                continue;
            }

            $seedKey = $this->mediaImporter->seedKey($record->section, $slug, $collection, $image->sha256);
            $plan = $this->mediaImporter->plan(
                $model, $collection, $image, $seedKey,
                $options['only_missing_media'], $options['replace_seed_media']
            );

            if (in_array($plan['action'], ['attach', 'replace-seed'], true)) {
                if ($options['dry_run']) {
                    $this->reporter->media($record, $slug, $collection, 'would-attach', $plan['reason']);

                    continue;
                }
                try {
                    $result = $this->mediaImporter->attach(
                        $model, $collection, $image, $seedKey,
                        $record->matchConfidence, $plan['action'] === 'replace-seed'
                    );
                    $this->reporter->media($record, $slug, $collection, 'media-attached', $plan['reason'], $result['media_id']);
                    $this->reporter->trackAttachedMedia($result['media_id'], $result['replaced_media_ids']);
                } catch (Throwable $e) {
                    // Keep the record; report the partial failure. Nothing else is rolled back.
                    $this->reporter->media($record, $slug, $collection, 'failed', $e->getMessage());
                }
            } elseif (str_starts_with($plan['action'], 'conflict')) {
                $this->reporter->media($record, $slug, $collection, 'media-conflict', $plan['reason']);
            } else {
                $this->reporter->media($record, $slug, $collection, 'media-skipped', $plan['reason']);
            }
        }
    }

    private function reportMediaPlanForNewRecord(ProgramData $record, string $slug): void
    {
        if (! $record->hasImages()) {
            $this->reporter->media($record, $slug, 'cover', 'no-source-media', 'record has no matched images');
            $this->reporter->media($record, $slug, 'gallery', 'no-source-media', 'record has no matched images');

            return;
        }
        $images = ['cover' => $record->cover];
        if ($record->gallery !== null) {
            $images['gallery'] = $record->gallery;
        }
        foreach ($images as $collection => $image) {
            $problems = $this->mediaImporter->validateSource($image);
            $problems === []
                ? $this->reporter->media($record, $slug, $collection, 'would-attach', 'after record creation')
                : $this->reporter->media($record, $slug, $collection, 'failed', implode('; ', $problems));
        }
    }

    private function normalizeTitle(string $title): string
    {
        $t = Str::ascii(mb_strtolower($title));

        return trim(preg_replace('/[^a-z0-9]+/', ' ', $t));
    }
}

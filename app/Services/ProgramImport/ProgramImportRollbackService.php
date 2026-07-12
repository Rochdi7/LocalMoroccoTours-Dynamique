<?php

namespace App\Services\ProgramImport;

use Illuminate\Support\Facades\File;
use RuntimeException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Rolls back records and media created by one specific import run, using the
 * run's JSON report as the manifest. Never touches anything the run did not
 * create; refuses to delete records that were modified afterwards or that
 * have gained reviews, and support rows (categories/locations) still in use.
 */
class ProgramImportRollbackService
{
    /**
     * @return array{actions: list<array{type: string, target: string, status: string, reason: string}>}
     */
    public function rollback(string $runId, bool $apply): array
    {
        $path = storage_path("app/program-import/reports/run-{$runId}.json");
        if (! is_file($path)) {
            throw new RuntimeException("No report found for run '{$runId}' at {$path}");
        }
        $manifest = json_decode(File::get($path), true);
        $rollback = $manifest['rollback'] ?? null;
        if (! is_array($rollback)) {
            throw new RuntimeException('Report contains no rollback manifest.');
        }

        $actions = [];

        // 1. Media attached by the run (delete first: they may reference records below).
        foreach ($rollback['attached_media_ids'] ?? [] as $mediaId) {
            $media = Media::find($mediaId);
            if ($media === null) {
                $actions[] = $this->action('media', "media#{$mediaId}", 'skipped', 'already gone');

                continue;
            }
            if ($media->getCustomProperty('managed_by') !== ProgramMediaImporter::MANAGED_BY) {
                $actions[] = $this->action('media', "media#{$mediaId}", 'refused', 'not managed by programs-import');

                continue;
            }
            if ($apply) {
                $media->delete();
            }
            $actions[] = $this->action('media', "media#{$mediaId} ({$media->file_name})", $apply ? 'deleted' : 'would-delete', 'attached by this run');
        }

        // 2. Records created by the run.
        foreach ($rollback['created_records'] ?? [] as $entry) {
            $actions[] = $this->rollbackModel($entry, $apply, checkPristine: true);
        }

        // 3. Categories / locations created by the run — only when unused.
        foreach ($rollback['created_support'] ?? [] as $entry) {
            $actions[] = $this->rollbackSupport($entry, $apply);
        }

        return ['actions' => $actions];
    }

    private function rollbackModel(array $entry, bool $apply, bool $checkPristine): array
    {
        $class = $entry['model'];
        $id = $entry['id'];
        $label = class_basename($class)."#{$id}";

        if (! class_exists($class)) {
            return $this->action('record', $label, 'refused', 'unknown model class');
        }
        $model = $class::find($id);
        if ($model === null) {
            return $this->action('record', $label, 'skipped', 'already gone');
        }
        if ($checkPristine) {
            if (method_exists($model, 'reviews') && $model->reviews()->count() > 0) {
                return $this->action('record', $label, 'refused', 'record has reviews');
            }
            if ($model->updated_at?->gt($model->created_at)) {
                return $this->action('record', $label, 'refused', 'record was modified after import');
            }
        }
        if ($apply) {
            // Remove only media this importer attached; refuse if manual media exists.
            if (method_exists($model, 'getMedia')) {
                $manual = $model->media()->get()->reject(
                    fn ($m) => $m->getCustomProperty('managed_by') === ProgramMediaImporter::MANAGED_BY
                );
                if ($manual->isNotEmpty()) {
                    return $this->action('record', $label, 'refused', 'manually uploaded media attached');
                }
            }
            $model->delete();
        }

        return $this->action('record', $label, $apply ? 'deleted' : 'would-delete', 'created by this run, unmodified');
    }

    private function rollbackSupport(array $entry, bool $apply): array
    {
        $class = $entry['model'];
        $id = $entry['id'];
        $label = class_basename($class)."#{$id}";

        if (! class_exists($class)) {
            return $this->action('support', $label, 'refused', 'unknown model class');
        }
        $model = $class::find($id);
        if ($model === null) {
            return $this->action('support', $label, 'skipped', 'already gone');
        }

        $inUse = match (class_basename($class)) {
            'TourCategory' => \App\Models\Tour::where('category_id', $id)->exists(),
            'ActivityCategory' => \App\Models\Activity::where('category_id', $id)->exists(),
            'TrekkingCategory' => \App\Models\Trekking::where('category_id', $id)->exists(),
            'Location' => \App\Models\Tour::where('location_id', $id)->exists()
                || \App\Models\Activity::where('location_id', $id)->exists()
                || \App\Models\Trekking::where('location_id', $id)->exists(),
            default => true,
        };
        if ($inUse) {
            return $this->action('support', $label, 'refused', 'still referenced by other records');
        }
        if ($apply) {
            $model->delete();
        }

        return $this->action('support', $label, $apply ? 'deleted' : 'would-delete', 'created by this run, unused');
    }

    private function action(string $type, string $target, string $status, string $reason): array
    {
        return compact('type', 'target', 'status', 'reason');
    }
}

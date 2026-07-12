<?php

namespace App\Services\ProgramImport;

use App\Data\ProgramImport\ProgramData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Collects per-record and per-media results of an import run and writes the
 * timestamped JSON + CSV reports under storage/app/program-import/reports/.
 * The JSON report doubles as the rollback manifest.
 */
class ProgramImportReporter
{
    public readonly string $runId;

    /** @var array<string, array<string, mixed>> keyed by "section:slug" */
    private array $rows = [];

    /** @var list<array{model: string, id: int}> */
    private array $createdRecords = [];

    /** @var list<array{model: string, id: int}> */
    private array $createdSupport = [];

    /** @var list<int> */
    private array $attachedMediaIds = [];

    /** @var list<int> */
    private array $replacedMediaIds = [];

    private array $options = [];

    public function __construct(?string $runId = null)
    {
        $this->runId = $runId ?? now()->format('Ymd-His').'-'.Str::lower(Str::random(6));
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function record(ProgramData $record, string $slug, string $action, array $detail = []): void
    {
        $row = &$this->row($record, $slug);
        $row['record_action'] = $action;
        foreach ($detail as $k => $v) {
            if ($k === 'warnings' || $k === 'errors') {
                $row[$k] = array_merge($row[$k], (array) $v);
            } else {
                $row[$k] = $v;
            }
        }
    }

    public function media(ProgramData $record, string $slug, string $collection, string $status, string $reason, ?int $mediaId = null): void
    {
        $row = &$this->row($record, $slug);
        $row["{$collection}_action"] = $status;
        $row["{$collection}_reason"] = $reason;
        if ($mediaId !== null) {
            $row["{$collection}_media_id"] = $mediaId;
        }
        if ($record->cover?->sourceWarning || $record->gallery?->sourceWarning) {
            $row['source_media_warnings'] = trim(
                ($record->cover?->sourceWarning ? 'cover: '.$record->cover->sourceWarning.' ' : '')
                .($record->gallery?->sourceWarning ? 'gallery: '.$record->gallery->sourceWarning : '')
            );
        }
    }

    public function trackCreatedRecord(Model $model): void
    {
        $this->createdRecords[] = ['model' => $model::class, 'id' => $model->id];
    }

    public function trackCreatedSupport(Model $model): void
    {
        $this->createdSupport[] = ['model' => $model::class, 'id' => $model->id];
    }

    /** @param list<int> $replaced */
    public function trackAttachedMedia(int $mediaId, array $replaced = []): void
    {
        $this->attachedMediaIds[] = $mediaId;
        $this->replacedMediaIds = array_merge($this->replacedMediaIds, $replaced);
    }

    /** @return array<string, int> */
    public function summary(): array
    {
        $counts = [];
        foreach ($this->rows as $row) {
            $counts[$row['record_action'] ?? 'unprocessed'] = ($counts[$row['record_action'] ?? 'unprocessed'] ?? 0) + 1;
            foreach (['cover_action', 'gallery_action'] as $k) {
                if (isset($row[$k])) {
                    $counts[$k.':'.$row[$k]] = ($counts[$k.':'.$row[$k]] ?? 0) + 1;
                }
            }
        }
        ksort($counts);

        return $counts;
    }

    /** @return array<string, array<string, mixed>> */
    public function rows(): array
    {
        return $this->rows;
    }

    /** @return array{json: string, csv: string} written file paths */
    public function write(): array
    {
        $dir = storage_path('app/program-import/reports');
        File::ensureDirectoryExists($dir);

        $jsonPath = "{$dir}/run-{$this->runId}.json";
        $csvPath = "{$dir}/run-{$this->runId}.csv";

        File::put($jsonPath, json_encode([
            'run_id' => $this->runId,
            'generated_at' => now()->toIso8601String(),
            'options' => $this->options,
            'summary' => $this->summary(),
            'rows' => array_values($this->rows),
            'rollback' => [
                'created_records' => $this->createdRecords,
                'created_support' => $this->createdSupport,
                'attached_media_ids' => $this->attachedMediaIds,
                'replaced_media_ids' => $this->replacedMediaIds,
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $columns = ['section', 'source_title', 'source_slug', 'destination_model', 'record_id',
            'record_action', 'category_action', 'location_action', 'source_media_status',
            'cover_action', 'cover_reason', 'cover_media_id',
            'gallery_action', 'gallery_reason', 'gallery_media_id',
            'source_media_warnings', 'warnings', 'errors', 'notes'];
        $fh = fopen($csvPath, 'w');
        fputcsv($fh, $columns);
        foreach ($this->rows as $row) {
            fputcsv($fh, array_map(function ($col) use ($row) {
                $v = $row[$col] ?? '';

                return is_array($v) ? implode(' | ', $v) : (string) $v;
            }, $columns));
        }
        fclose($fh);

        return ['json' => $jsonPath, 'csv' => $csvPath];
    }

    private function &row(ProgramData $record, string $slug): array
    {
        $key = "{$record->section}:{$slug}";
        if (! isset($this->rows[$key])) {
            $this->rows[$key] = [
                'section' => $record->section,
                'source_title' => $record->title,
                'source_slug' => $slug,
                'source_media_status' => $record->hasImages()
                    ? "matched ({$record->matchStatus}, {$record->matchConfidence})"
                    : 'no-source-media',
                'warnings' => [],
                'errors' => [],
            ];
        }

        return $this->rows[$key];
    }
}

<?php

namespace App\Console\Commands;

use App\Services\ProgramImport\ProgramImporter;
use App\Services\ProgramImport\ProgramImportReporter;
use App\Services\ProgramImport\ProgramMediaImporter;
use App\Services\ProgramImport\ToursDataParser;
use Illuminate\Console\Command;

class ImportProgramsCommand extends Command
{
    protected $signature = 'programs:import
        {--source=tours-data.md : Path to the data file (relative to base_path or absolute)}
        {--dry-run : Preview only (default behaviour when --apply is absent)}
        {--apply : Actually write records and attach media}
        {--section=* : Limit to sections: tour, activity, trekking}
        {--slug= : Process only the record with this slug}
        {--only-new : Only create records that do not exist yet}
        {--only-missing-media : Attach media only where the collection is empty}
        {--replace-seed-media : Replace media previously attached by this importer (never manual uploads)}
        {--update-content : Allow non-empty source values to replace existing content fields}
        {--limit= : Process at most N records}
        {--report= : Custom run id for the report files}';

    protected $description = 'Import tours/activities/trekking from tours-data.md and attach cover/gallery media (dry-run by default)';

    public function handle(): int
    {
        $apply = (bool) $this->option('apply');
        if ($apply && $this->option('dry-run')) {
            $this->error('Use either --apply or --dry-run, not both.');

            return self::FAILURE;
        }
        $dryRun = ! $apply;

        $source = $this->option('source');
        $sourcePath = str_contains($source, ':') || str_starts_with($source, '/')
            ? $source : base_path($source);

        $parser = new ToursDataParser;
        $records = $parser->parse($sourcePath);

        $withMedia = count(array_filter($records, fn ($r) => $r->hasImages()));
        $this->info(sprintf(
            'Parsed %d records (%d tours, %d activities, %d trekking) — %d with media, %d without.',
            count($records),
            count(array_filter($records, fn ($r) => $r->section === 'tour')),
            count(array_filter($records, fn ($r) => $r->section === 'activity')),
            count(array_filter($records, fn ($r) => $r->section === 'trekking')),
            $withMedia,
            count($records) - $withMedia,
        ));

        $problems = $parser->validate($records, public_path());
        if ($problems !== []) {
            $this->error('Source validation failed:');
            foreach ($problems as $p) {
                $this->line("  - {$p}");
            }

            return self::FAILURE;
        }
        $this->info('Source validation passed (structure, image paths, SHA-256 hashes).');

        $options = [
            'dry_run' => $dryRun,
            'sections' => (array) $this->option('section'),
            'slug' => $this->option('slug') ?: null,
            'only_new' => (bool) $this->option('only-new'),
            'only_missing_media' => (bool) $this->option('only-missing-media'),
            'replace_seed_media' => (bool) $this->option('replace-seed-media'),
            'update_content' => (bool) $this->option('update-content'),
            'limit' => $this->option('limit') !== null ? (int) $this->option('limit') : null,
        ];

        if ($dryRun) {
            $this->warn('DRY RUN — no database writes, no media attachments. Use --apply to execute.');
        } elseif (! $this->option('no-interaction') && ! $this->confirm('APPLY mode will write to the database and attach media. Continue?')) {
            return self::FAILURE;
        }

        $reporter = new ProgramImportReporter($this->option('report') ?: null);
        $reporter->setOptions($options + ['source' => $sourcePath, 'mode' => $dryRun ? 'dry-run' : 'apply']);
        $importer = new ProgramImporter(new ProgramMediaImporter(public_path()), $reporter);
        $importer->run($records, $options);

        $summary = $reporter->summary();
        $this->newLine();
        $this->info(($dryRun ? 'Dry-run' : 'Apply').' summary:');
        foreach ($summary as $k => $v) {
            $this->line(sprintf('  %-40s %d', $k, $v));
        }

        $conflicts = ($summary['conflict'] ?? 0)
            + ($summary['cover_action:media-conflict'] ?? 0)
            + ($summary['gallery_action:media-conflict'] ?? 0);
        $failures = ($summary['failed'] ?? 0)
            + ($summary['cover_action:failed'] ?? 0)
            + ($summary['gallery_action:failed'] ?? 0);

        $paths = $reporter->write();
        $this->newLine();
        $this->info("Run id: {$reporter->runId}");
        $this->info("Report (JSON): {$paths['json']}");
        $this->info("Report (CSV):  {$paths['csv']}");
        if ($conflicts > 0) {
            $this->warn("{$conflicts} conflict(s) need manual review — see report.");
        }
        if ($failures > 0) {
            $this->error("{$failures} failure(s) — see report.");

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}

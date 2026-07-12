<?php

namespace App\Console\Commands;

use App\Services\ProgramImport\ProgramImportRollbackService;
use Illuminate\Console\Command;

class RollbackProgramImportCommand extends Command
{
    protected $signature = 'programs:import-rollback
        {run-id : The run id shown by programs:import (report filename suffix)}
        {--dry-run : Preview only (default behaviour when --apply is absent)}
        {--apply : Actually delete run-created records and media}';

    protected $description = 'Roll back records and media created by a specific programs:import run';

    public function handle(ProgramImportRollbackService $service): int
    {
        $apply = (bool) $this->option('apply');
        if ($apply && $this->option('dry-run')) {
            $this->error('Use either --apply or --dry-run, not both.');

            return self::FAILURE;
        }

        if ($apply && ! $this->option('no-interaction')
            && ! $this->confirm('This deletes records/media created by the selected run. Continue?')) {
            return self::FAILURE;
        }

        $result = $service->rollback($this->argument('run-id'), $apply);

        $this->table(
            ['Type', 'Target', 'Status', 'Reason'],
            array_map(fn ($a) => [$a['type'], $a['target'], $a['status'], $a['reason']], $result['actions'])
        );
        if (! $apply) {
            $this->warn('DRY RUN — nothing was deleted. Use --apply to execute.');
        }

        return self::SUCCESS;
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Thin wrapper: imports only the `activity` section (12 records) from
 * tours-data.md via the programs:import pipeline. No data is embedded here —
 * tours-data.md is the single source of truth.
 *
 * All 12 activities currently have no matched images; the importer records
 * them as no-source-media and never invents fallback media.
 */
class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('programs:import', [
            '--apply' => true,
            '--section' => ['activity'],
            '--no-interaction' => true,
            '--report' => 'seeder-activity-'.now()->format('Ymd-His-u'),
        ], $this->command?->getOutput());
    }
}

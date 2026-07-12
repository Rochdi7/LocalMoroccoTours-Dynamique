<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Thin wrapper: imports only the `trekking` section (3 records) from
 * tours-data.md via the programs:import pipeline. No data is embedded here —
 * tours-data.md is the single source of truth.
 *
 * Replaces the previous markdown-parsing TrekkingSeeder (which extended
 * TourDataSeeder): the importer pipeline adds media attachment, hash
 * verification, duplicate prevention and fill-only-missing updates.
 * Existing trekking-specific values (difficulty_level, max_altitude) are
 * preserved; for brand-new rows the importer defaults difficulty to Moderate.
 */
class TrekkingSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('programs:import', [
            '--apply' => true,
            '--section' => ['trekking'],
            '--no-interaction' => true,
            '--report' => 'seeder-trekking-'.now()->format('Ymd-His-u'),
        ], $this->command?->getOutput());
    }
}

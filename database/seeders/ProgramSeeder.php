<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Thin wrapper around the programs:import pipeline.
 *
 * Single source of truth: tours-data.md
 *   tours-data.md -> ToursDataParser -> ProgramImporter -> ProgramMediaImporter
 *                 -> Tour / Activity / Trekking + Spatie Media Library
 *
 * No program data is embedded here. Safe to re-run: the importer upserts by
 * slug, preserves existing non-empty values, protects prices/bookings/reviews,
 * never duplicates media and always preserves manual uploads.
 */
class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('programs:import', [
            '--apply' => true,
            '--no-interaction' => true,
            '--report' => 'seeder-'.now()->format('Ymd-His-u'),
        ], $this->command?->getOutput());
    }
}

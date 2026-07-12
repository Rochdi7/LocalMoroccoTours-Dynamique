<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Thin wrapper: imports only the `tour` section (62 records) from
 * tours-data.md via the programs:import pipeline. No data is embedded here —
 * tours-data.md is the single source of truth.
 *
 * Idempotent: upserts by slug, preserves existing non-empty values, protects
 * prices/bookings/reviews, never duplicates media, preserves manual uploads.
 */
class TourSeeder extends Seeder
{
    public function run(): void
    {
        Artisan::call('programs:import', [
            '--apply' => true,
            '--section' => ['tour'],
            '--no-interaction' => true,
            '--report' => 'seeder-tour-'.now()->format('Ymd-His-u'),
        ], $this->command?->getOutput());
    }
}

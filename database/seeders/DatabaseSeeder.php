<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Roles/permissions, then all programs (tours, activities, trekking) via the
     * ProgramSeeder -> programs:import pipeline (single source of truth:
     * tours-data.md, with cover/gallery media + SEO metadata), then rating
     * categories. The old per-type seeders (Tours/Activities/Trekking) embedded
     * no media and are no longer used.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesPermissionsSeeder::class,
            LocationSeeder::class,
            ProgramSeeder::class,
            RatingCategorySeeder::class,
        ]);
    }
}

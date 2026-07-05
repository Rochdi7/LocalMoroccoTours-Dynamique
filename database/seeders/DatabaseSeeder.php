<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Only the admin account is seeded. All demo content (tours, activities,
     * trekking, posts, comments, offers, locations, categories, tags, extra
     * users, rating categories) was intentionally removed — real content is
     * added through the admin dashboard.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesPermissionsSeeder::class,
        ]);
    }
}

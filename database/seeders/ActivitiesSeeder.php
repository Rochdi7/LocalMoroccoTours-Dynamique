<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\Location;
use Illuminate\Support\Str;

class ActivitiesSeeder extends TourDataSeeder
{
    protected function section(): string
    {
        return 'activity';
    }

    protected function modelClass(): string
    {
        return Activity::class;
    }

    public function run(): void
    {
        $items = $this->items();

        foreach ($items as $item) {
            $category = ActivityCategory::firstOrCreate(
                ['name' => $item['category']],
                ['slug' => Str::slug($item['category'])]
            );

            $location = null;
            if (! empty($item['location'])) {
                $location = Location::firstOrCreate(
                    ['name' => $item['location']],
                    ['slug' => Str::slug($item['location'])]
                );
            }

            Activity::create($this->basePayload($item, $category->id, $location?->id));
        }

        $this->command?->info('Seeded ' . count($items) . ' activities.');
    }
}

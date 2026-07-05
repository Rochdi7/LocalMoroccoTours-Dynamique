<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Support\Str;

class ToursSeeder extends TourDataSeeder
{
    protected function section(): string
    {
        return 'tour';
    }

    protected function modelClass(): string
    {
        return Tour::class;
    }

    public function run(): void
    {
        $items = $this->items();

        foreach ($items as $item) {
            $category = TourCategory::firstOrCreate(
                ['name' => $item['category']],
                ['slug' => Str::slug($item['category'])]
            );

            // tours.location_id is NOT NULL — fall back to a generic "Morocco".
            $locationName = ! empty($item['location']) ? $item['location'] : 'Morocco';
            $location = Location::firstOrCreate(
                ['name' => $locationName],
                ['slug' => Str::slug($locationName)]
            );

            $payload = $this->basePayload($item, $category->id, $location?->id);
            $payload['type'] = in_array($item['type'] ?? '', ['day_trip', 'multi_day'], true)
                ? $item['type']
                : 'multi_day';

            Tour::create($payload);
        }

        $this->command?->info('Seeded ' . count($items) . ' tours.');
    }
}

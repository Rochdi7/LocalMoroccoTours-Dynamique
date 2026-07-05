<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Trekking;
use App\Models\TrekkingCategory;
use Illuminate\Support\Str;

class TrekkingSeeder extends TourDataSeeder
{
    protected function section(): string
    {
        return 'trekking';
    }

    protected function modelClass(): string
    {
        return Trekking::class;
    }

    public function run(): void
    {
        $items = $this->items();

        foreach ($items as $item) {
            $category = TrekkingCategory::firstOrCreate(
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

            $payload = $this->basePayload($item, $category->id, $location?->id);

            $difficulty = $item['difficulty_level'] ?? 'Moderate';
            $payload['difficulty_level'] = in_array($difficulty, ['Easy', 'Moderate', 'Hard', 'Expert'], true)
                ? $difficulty
                : 'Moderate';
            $payload['max_altitude'] = ($item['max_altitude'] ?? '') !== ''
                ? (int) $item['max_altitude']
                : null;

            Trekking::create($payload);
        }

        $this->command?->info('Seeded ' . count($items) . ' trekking trips.');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RatingCategory;

class RatingCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['label' => 'Location', 'icon' => 'icon-location', 'description' => 'Proximity to attractions.'],
            ['label' => 'Amenities', 'icon' => 'icon-wifi', 'description' => 'Facilities and services.'],
            ['label' => 'Food', 'icon' => 'icon-food', 'description' => 'Quality of food.'],
            ['label' => 'Room', 'icon' => 'icon-bed', 'description' => 'Room comfort and cleanliness.'],
            ['label' => 'Price', 'icon' => 'icon-price-tag', 'description' => 'Value for money.'],
            ['label' => 'Tour Operator', 'icon' => 'icon-tour-guide', 'description' => 'Quality of the guide or operator.'],
        ];

        foreach ($categories as $category) {
            RatingCategory::create($category);
        }
    }
}
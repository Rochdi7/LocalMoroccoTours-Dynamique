<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Location;
use App\Models\TourCategory;
use App\Models\ActivityCategory;
use App\Models\TrekkingCategory;
use App\Models\BlogCategory;
use App\Models\Tour;
use App\Models\Activity;
use App\Models\Trekking;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // It's good practice to disable foreign key checks while seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clean up the tables before seeding
        DB::table('tour_categories')->truncate();
        DB::table('locations')->truncate();
        DB::table('activity_categories')->truncate();
        DB::table('trekking_categories')->truncate();
        DB::table('blog_categories')->truncate();
        DB::table('tags')->truncate();
        DB::table('users')->truncate();
        DB::table('tours')->truncate();
        DB::table('activities')->truncate();
        DB::table('trekking')->truncate();
        DB::table('posts')->truncate();
        DB::table('post_comments')->truncate();
        DB::table('post_tag')->truncate();
        DB::table('special_offers')->truncate();
        DB::table('review_ratings')->truncate();
        DB::table('rating_categories')->truncate();
        DB::table('media')->truncate();

        // --- CATEGORIES & LOCATIONS ---

        $tourCategories = DB::table('tour_categories')->insert([
            ['name' => 'Cultural Tours', 'slug' => 'cultural-tours', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Desert Safaris', 'slug' => 'desert-safaris', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'City Breaks', 'slug' => 'city-breaks', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'Localmoroccotour@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $locations = DB::table('locations')->insert([
            [
                'name' => 'Marrakech',
                'slug' => Str::slug('Marrakech'),
                'description' => 'The vibrant heart of Morocco.',
                'seo_alt' => 'Marrakech City',
                'seo_caption' => 'Sunset over Marrakech skyline',
                'seo_description' => 'Marrakech, the vibrant heart of Morocco, famous for its markets and culture.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Fes',
                'slug' => Str::slug('Fes'),
                'description' => 'The cultural and spiritual center of Morocco.',
                'seo_alt' => 'Fes Medina',
                'seo_caption' => 'Old medina streets of Fes',
                'seo_description' => 'Explore the spiritual and cultural heritage of Morocco in Fes.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Atlas Mountains',
                'slug' => Str::slug('Atlas Mountains'),
                'description' => 'Majestic mountain range near Marrakech.',
                'seo_alt' => 'Atlas Mountains Range',
                'seo_caption' => 'Snow-capped Atlas peaks',
                'seo_description' => 'Experience trekking adventures and nature in the Atlas Mountains.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $activityCategories = DB::table('activity_categories')->insert([
            ['name' => 'Hot Air Balloon', 'slug' => 'hot-air-balloon', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Cooking Class', 'slug' => 'cooking-class', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Quad Biking', 'slug' => 'quad-biking', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        $trekkingCategories = DB::table('trekking_categories')->insert([
            ['name' => 'Mountain Treks', 'slug' => 'mountain-treks', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Coastal Hikes', 'slug' => 'coastal-hikes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Desert Treks', 'slug' => 'desert-treks', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        $blogCategories = DB::table('blog_categories')->insert([
            ['name' => 'Travel Guides', 'slug' => 'travel-guides', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Cultural Insights', 'slug' => 'cultural-insights', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Food & Drink', 'slug' => 'food-drink', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        DB::table('tags')->insert([
            ['name' => 'Adventure', 'slug' => 'adventure', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'History', 'slug' => 'history', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Luxury', 'slug' => 'luxury', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // --- USERS ---
        DB::table('users')->insert([
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'John Doe', 'email' => 'john.doe@example.com', 'password' => Hash::make('password'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'password' => Hash::make('password'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // --- CORE CONTENT: TOURS, ACTIVITIES, TREKKING ---

        $tours = DB::table('tours')->insert([
            [
                'title' => 'Imperial Cities Discovery',
                'slug' => 'imperial-cities-discovery',
                'overview' => 'Explore the rich history of Morocco\'s four imperial cities: Marrakech, Fes, Meknes, and Rabat.',
                'highlights' => json_encode([
                    "Visit Hassan II Mosque",
                    "Explore the Fes medina",
                    "Discover Roman ruins at Volubilis"
                ]),
                'duration' => '8 Days',
                'group_size' => 12,
                'age_range' => '12-70',
                'base_price' => 1250.00,
                'bestseller_flag' => true,
                'free_cancellation_flag' => true,
                'booked_count' => 150,
                'map_frame' => '31.6295,-7.9811',
                'category_id' => 1,
                'location_id' => 1,
                'included' => json_encode([
                    'Hotel pickup and drop-off',
                    'English-speaking guide',
                    'Entrance fees to monuments',
                ]),
                'excluded' => json_encode([
                    'Personal expenses',
                    'Tips',
                ]),
                'itinerary' => json_encode([
                    ['title' => 'Day 1: Arrival in Marrakech', 'content' => 'Transfer to hotel and welcome dinner.'],
                    ['title' => 'Day 2: Marrakech City Tour', 'content' => 'Visit Koutoubia, Saadian Tombs, Bahia Palace.'],
                    ['title' => 'Day 3: Travel to Fes', 'content' => 'Scenic drive through Middle Atlas.'],
                    ['title' => 'Day 4: Fes Medina Tour', 'content' => 'Explore the oldest medina in Morocco.'],
                    ['title' => 'Day 5: Meknes & Volubilis', 'content' => 'Roman ruins and imperial architecture.'],
                    ['title' => 'Day 6: Rabat', 'content' => 'Visit Hassan Tower and Oudayas Kasbah.'],
                    ['title' => 'Day 7: Return to Marrakech', 'content' => 'Free afternoon for shopping.'],
                    ['title' => 'Day 8: Departure', 'content' => 'Transfer to airport.'],
                ]),
                'languages' => 'English, French',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Sahara Desert Luxury Camp',
                'slug' => 'sahara-desert-luxury-camp',
                'overview' => 'Experience the magic of the Sahara with a 3-day tour from Marrakech to Merzouga, staying in a luxury desert camp.',
                'highlights' => json_encode([
                    "Camel ride at sunset",
                    "Stargazing in the desert",
                    "Traditional Berber music"
                ]),
                'duration' => '3 Days',
                'group_size' => 8,
                'age_range' => '10-65',
                'base_price' => 450.00,
                'bestseller_flag' => true,
                'free_cancellation_flag' => false,
                'booked_count' => 210,
                'map_frame' => '31.0931,-4.0116',
                'category_id' => 2,
                'location_id' => 1,
                'included' => json_encode([
                    'Luxury desert camp accommodation',
                    'Camel trek through dunes',
                    'Traditional Moroccan dinner',
                ]),
                'excluded' => json_encode([
                    'Drinks not specified',
                    'Tips',
                ]),
                'itinerary' => json_encode([
                    ['title' => 'Day 1: Marrakech to Dades Gorge', 'content' => 'Scenic drive via Atlas Mountains.'],
                    ['title' => 'Day 2: Dades to Merzouga', 'content' => 'Camel ride at sunset and desert campfire.'],
                    ['title' => 'Day 3: Return to Marrakech', 'content' => 'Breakfast and transfer back.'],
                ]),
                'languages' => 'English, Spanish',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Fes Medina Guided Tour',
                'slug' => 'fes-medina-guided-tour',
                'overview' => 'A full-day guided tour exploring the labyrinthine streets of the ancient Fes medina, a UNESCO World Heritage site.',
                'highlights' => json_encode([
                    "Visit Bou Inania Madrasa",
                    "See the Chouara Tannery",
                    "Explore the souks"
                ]),
                'duration' => '1 Day',
                'group_size' => 6,
                'age_range' => 'All ages',
                'base_price' => 80.00,
                'bestseller_flag' => false,
                'free_cancellation_flag' => true,
                'booked_count' => 95,
                'map_frame' => '34.0637,-5.0033',
                'category_id' => 3,
                'location_id' => 2,
                'included' => json_encode([
                    'Official guide',
                    'Entrance to monuments',
                ]),
                'excluded' => json_encode([
                    'Lunch',
                    'Personal expenses',
                ]),
                'itinerary' => json_encode([
                    ['title' => 'Day 1: Fes Medina Tour', 'content' => 'Visit Madrasa, tanneries, and local markets.'],
                ]),
                'languages' => 'English, Arabic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $activities = DB::table('activities')->insert([
            [
                'title' => 'Sunrise Hot Air Balloon Over Marrakech',
                'slug' => Str::slug('Sunrise Hot Air Balloon Over Marrakech'),
                'overview' => 'Witness a breathtaking sunrise over the Atlas Mountains from a hot air balloon, followed by a traditional Berber breakfast.',
                'highlights' => json_encode(["Stunning aerial views", "Berber breakfast in a tent", "Flight certificate"]),
                'duration' => '4 Hours',
                'group_size' => 16,
                'age_range' => '5+',
                'base_price' => 205.00,
                'bestseller_flag' => true,
                'free_cancellation_flag' => true,
                'booked_count' => 300,
                'map_frame' => '31.6295,-7.9811',
                'category_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Tagine Cooking Class in a Riad',
                'slug' => Str::slug('Tagine Cooking Class in a Riad'),
                'overview' => 'Learn the secrets of Moroccan cuisine by preparing a traditional tagine in a beautiful Marrakech riad.',
                'highlights' => json_encode(["Market visit for ingredients", "Hands-on cooking lesson", "Enjoy the meal you prepared"]),
                'duration' => '3.5 Hours',
                'group_size' => 10,
                'age_range' => '8+',
                'base_price' => 65.00,
                'bestseller_flag' => false,
                'free_cancellation_flag' => true,
                'booked_count' => 120,
                'map_frame' => '31.6258,-7.9945',
                'category_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Agafay Desert Quad Biking Adventure',
                'slug' => Str::slug('Agafay Desert Quad Biking Adventure'),
                'overview' => 'Experience an adrenaline rush while quad biking through the rocky plains of the Agafay Desert, just outside Marrakech.',
                'highlights' => json_encode(["Thrilling off-road experience", "Tea break with a local family", "Views of the Atlas Mountains"]),
                'duration' => '2 Hours',
                'group_size' => 8,
                'age_range' => '16+',
                'base_price' => 75.00,
                'bestseller_flag' => true,
                'free_cancellation_flag' => false,
                'booked_count' => 180,
                'map_frame' => '31.4725,-8.1211',
                'category_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        $trekkings = DB::table('trekking')->insert([
            [
                'title' => 'Mount Toubkal Ascent (2 Days)',
                'slug' => Str::slug('Mount Toubkal Ascent (2 Days)'),
                'overview' => 'Challenge yourself with a 2-day trek to the summit of Mount Toubkal, the highest peak in North Africa.',
                'highlights' => json_encode(["Summiting Toubkal (4,167m)", "Overnight stay in a mountain refuge", "Panoramic Atlas views"]),
                'duration' => '2 Days',
                'group_size' => 10,
                'age_range' => '18-60',
                'base_price' => 180.00,
                'difficulty_level' => 'Hard',
                'max_altitude' => 4167,
                'bestseller_flag' => true,
                'free_cancellation_flag' => false,
                'booked_count' => 115,
                'map_frame' => '31.0596,-7.9155',
                'category_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Three Valleys Trek',
                'slug' => Str::slug('Three Valleys Trek'),
                'overview' => 'A moderate day trek through three distinct valleys in the Atlas Mountains, experiencing Berber culture.',
                'highlights' => json_encode(["Lush green valleys", "Berber villages", "Lunch with a local family"]),
                'duration' => '1 Day',
                'group_size' => 12,
                'age_range' => '10-70',
                'base_price' => 90.00,
                'difficulty_level' => 'Moderate',
                'max_altitude' => 2200,
                'bestseller_flag' => false,
                'free_cancellation_flag' => true,
                'booked_count' => 85,
                'map_frame' => '31.2000,-7.9833',
                'category_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Essaouira Coastal Hike',
                'slug' => Str::slug('Essaouira Coastal Hike'),
                'overview' => 'A beautiful coastal hike along the Atlantic, from Diabat to Sidi Kaouki, passing argan trees and secluded beaches.',
                'highlights' => json_encode(["Atlantic ocean views", "Sandy beaches", "Potential to see goats in argan trees"]),
                'duration' => '6 Hours',
                'group_size' => 8,
                'age_range' => '12+',
                'base_price' => 70.00,
                'difficulty_level' => 'Easy',
                'max_altitude' => 50,
                'bestseller_flag' => false,
                'free_cancellation_flag' => true,
                'booked_count' => 45,
                'map_frame' => '31.5085,-9.7595',
                'category_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        // --- BLOG CONTENT: POSTS, COMMENTS, TAGS ---

        $posts = DB::table('posts')->insert([
            [
                'title' => 'A First-Timer\'s Guide to Marrakech',
                'slug' => 'first-timers-guide-to-marrakech',
                'excerpt' => 'Navigating the Red City can be daunting. Here are our top tips for making the most of your first visit.',
                'content' => '<h1>Welcome to Marrakech!</h1><p>Marrakech is a city of sensory overload...</p>',
                'status' => 'published',
                'author_id' => 1,
                'category_id' => 1,
                'published_at' => Carbon::now()->subDays(10),
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10)
            ],
            [
                'title' => 'The Art of Moroccan Mint Tea',
                'slug' => 'art-of-moroccan-mint-tea',
                'excerpt' => 'More than just a drink, Moroccan mint tea is a symbol of hospitality and culture. Learn how it\'s made.',
                'content' => '<h1>The Ceremony of Tea</h1><p>In Morocco, tea is a way of life...</p>',
                'status' => 'published',
                'author_id' => 2,
                'category_id' => 2,
                'published_at' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5)
            ],
            [
                'title' => 'Tasting Tagine: A Culinary Journey',
                'slug' => 'tasting-tagine-culinary-journey',
                'excerpt' => 'From lamb with prunes to chicken with lemons, we explore the delicious world of the Moroccan tagine.',
                'content' => '<h1>What is a Tagine?</h1><p>The tagine is both the pot and the stew...</p>',
                'status' => 'draft',
                'author_id' => 1,
                'category_id' => 3,
                'published_at' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2)
            ],
        ]);

        DB::table('post_comments')->insert([
            [
                'post_id' => 1,
                'user_id' => 2,
                'parent_id' => null,
                'guest_name' => null,
                'guest_email' => null,
                'comment_title' => 'Great tips!',
                'comment_body' => 'This was so helpful for my trip last month. Thanks!',
                'is_approved' => true,
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'post_id' => 1,
                'user_id' => 1,
                'parent_id' => 1,
                'guest_name' => null,
                'guest_email' => null,
                'comment_title' => 'Re: Great tips!',
                'comment_body' => 'So glad to hear that, John!',
                'is_approved' => true,
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'post_id' => 2,
                'user_id' => null,
                'parent_id' => null,
                'guest_name' => 'A Guest',
                'guest_email' => 'guest@example.com',
                'comment_title' => 'Fascinating!',
                'comment_body' => 'I never knew there was so much tradition behind the tea.',
                'is_approved' => false,
                'created_at' => Carbon::now()->subDays(3),
            ],
        ]);

        // Junction table for post_tag
        DB::table('post_tag')->insert([
            ['post_id' => 1, 'tag_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['post_id' => 1, 'tag_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['post_id' => 2, 'tag_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // --- MISC ---
        DB::table('special_offers')->insert([
            [
                'title' => 'Early Bird Discount',
                'subtitle' => 'Book 90 days in advance and save 15%!',
                'text' => 'Plan your adventure ahead of time and get rewarded.',
                'link' => '/tours',
                'order' => 1,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Sahara Summer Special',
                'subtitle' => '20% off all desert safaris in July & August.',
                'text' => 'Experience the magic of the desert for less this summer.',
                'link' => '/tours/desert-safaris',
                'order' => 2,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Last Minute Deal',
                'subtitle' => '10% off selected city breaks this weekend.',
                'text' => 'Spontaneous trip? We have you covered.',
                'link' => '/tours/city-breaks',
                'order' => 3,
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        // Insert predefined rating categories
        DB::table('rating_categories')->insert([
            [
                'label' => 'Location',
                'icon' => 'icon-location',
                'description' => 'Proximity to attractions and key sites.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'label' => 'Amenities',
                'icon' => 'icon-wifi',
                'description' => 'Facilities, services, and comfort provided.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'label' => 'Food',
                'icon' => 'icon-food',
                'description' => 'Quality and variety of food and dining experience.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'label' => 'Room',
                'icon' => 'icon-bed',
                'description' => 'Cleanliness, size, and comfort of rooms.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'label' => 'Price',
                'icon' => 'icon-price-tag',
                'description' => 'Value for money.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'label' => 'Tour Operator',
                'icon' => 'icon-tour-guide',
                'description' => 'Professionalism and helpfulness of tour staff.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Add media to models using Spatie Media Library
        // Note: Actual file paths must exist on the server
        $imagePaths = [
            'destinations' => base_path('public/assets/images/seeder/destinations.jpg'),
            'tours' => base_path('public/assets/images/seeder/tours.jpg'),
            'activities' => base_path('public/assets/images/seeder/activities.jpg'),
            'trekking' => base_path('public/assets/images/seeder/trekking.jpg'),
            'blog' => base_path('public/assets/images/seeder/blog.jpg'),
        ];

       

        // Associate images with locations
        Location::all()->each(function ($location, $index) use ($imagePaths) {
            if (file_exists($imagePaths['destinations'])) {
                $location->addMedia($imagePaths['destinations'])
                    ->toMediaCollection('location_images');
            }
        });

        // Associate images with tours
        Tour::all()->each(function ($tour, $index) use ($imagePaths) {
            if (file_exists($imagePaths['tours'])) {
                $tour->addMedia($imagePaths['tours'])
                    ->toMediaCollection('tour_images');
            }
        });

        // Associate images with activities
        Activity::all()->each(function ($activity, $index) use ($imagePaths) {
            if (file_exists($imagePaths['activities'])) {
                $activity->addMedia($imagePaths['activities'])
                    ->toMediaCollection('activity_images');
            }
        });

        // Associate images with trekkings
        Trekking::all()->each(function ($trekking, $index) use ($imagePaths) {
            if (file_exists($imagePaths['trekking'])) {
                $trekking->addMedia($imagePaths['trekking'])
                    ->toMediaCollection('trekking_images');
            }
        });

        // Associate images with posts
        Post::all()->each(function ($post, $index) use ($imagePaths) {
            if (file_exists($imagePaths['blog'])) {
                $post->addMedia($imagePaths['blog'])
                    ->toMediaCollection('post_images');
            }
        });

        // Re-enable FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
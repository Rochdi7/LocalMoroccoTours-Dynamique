<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds the destination locations used by tours/activities/trekking.
 *
 * Names match EXACTLY the "location" values in tours-data.md ("City, Morocco"),
 * so the programs:import pipeline links to these records via
 * Location::firstOrCreate(['name' => ...]) instead of duplicating them.
 *
 * Each location gets a cover image (public/assets/images/locations/<slug>.avif)
 * with alt / caption / description custom properties, plus row-level SEO fields
 * (seo_alt, seo_caption, seo_description).
 *
 * Idempotent: updateOrCreate by name; the image is only attached when the
 * "locations" media collection is empty (it is a singleFile collection), so
 * re-running never duplicates media or clobbers a manual upload.
 */
class LocationSeeder extends Seeder
{
    /**
     * @var array<int, array<string, string>>
     */
    private array $locations = [
        [
            'name' => 'Marrakech, Morocco',
            'image' => 'marrakech-morocco.avif',
            'description' => 'Marrakech, the vibrant Red City, is Morocco\'s tourism heart — home to the buzzing Jemaa el-Fnaa square, the labyrinthine souks of the medina, the Koutoubia Mosque, and lush gardens like Majorelle. It is the launchpad for desert excursions, Atlas Mountain day trips, and authentic cultural tours.',
            'seo_alt' => 'Jemaa el-Fnaa square and Koutoubia Mosque in Marrakech, Morocco',
            'seo_caption' => 'Marrakech — the Red City and gateway to the Sahara and High Atlas',
            'seo_description' => 'Discover Marrakech, Morocco: guided medina tours, Jemaa el-Fnaa, souks, gardens, and desert excursions with Authentic Morocco Adventures.',
        ],
        [
            'name' => 'Casablanca, Morocco',
            'image' => 'casablanca-morocco.avif',
            'description' => 'Casablanca is Morocco\'s largest city and economic capital, blending Art Deco heritage with modern seafront living. The colossal Hassan II Mosque rises over the Atlantic, while the Corniche, Old Medina, and Habous quarter offer a taste of coastal Moroccan life.',
            'seo_alt' => 'Hassan II Mosque on the Atlantic coast in Casablanca, Morocco',
            'seo_caption' => 'Casablanca — Atlantic coast, Hassan II Mosque, and Art Deco heritage',
            'seo_description' => 'Explore Casablanca, Morocco: Hassan II Mosque, the Corniche, and Art Deco tours along the Atlantic with Authentic Morocco Adventures.',
        ],
        [
            'name' => 'Fes, Morocco',
            'image' => 'fes-morocco.avif',
            'description' => 'Fes is Morocco\'s spiritual and cultural capital, home to Fes el-Bali — the world\'s largest car-free urban medina and a UNESCO World Heritage site. Wander ancient tanneries, the Al-Qarawiyyin university, and endless artisan workshops in a living medieval city.',
            'seo_alt' => 'Historic tanneries and medina rooftops of Fes el-Bali, Morocco',
            'seo_caption' => 'Fes — Morocco\'s cultural capital and UNESCO medina',
            'seo_description' => 'Visit Fes, Morocco: guided tours of the UNESCO medina, tanneries, and Al-Qarawiyyin with Authentic Morocco Adventures.',
        ],
        [
            'name' => 'Tangier, Morocco',
            'image' => 'tangier-morocco.avif',
            'description' => 'Tangier sits where the Mediterranean meets the Atlantic at the Strait of Gibraltar — a storied gateway between Africa and Europe. Its whitewashed Kasbah, hillside medina, and coastal cafés have long drawn artists, writers, and travelers.',
            'seo_alt' => 'Whitewashed Kasbah overlooking the sea in Tangier, Morocco',
            'seo_caption' => 'Tangier — gateway between two seas at the Strait of Gibraltar',
            'seo_description' => 'Discover Tangier, Morocco: Kasbah walks, the medina, and Strait of Gibraltar views with Authentic Morocco Adventures.',
        ],
        [
            'name' => 'Ouarzazate, Morocco',
            'image' => 'ouarzazate-morocco.avif',
            'description' => 'Known as the "Gateway to the Sahara" and the "Hollywood of Morocco," Ouarzazate is home to the UNESCO-listed Ait Ben Haddou kasbah and world-famous film studios. It is the desert launch point for the Draa Valley, Todra Gorge, and Sahara dunes.',
            'seo_alt' => 'Ait Ben Haddou kasbah near Ouarzazate, Morocco',
            'seo_caption' => 'Ouarzazate — gateway to the Sahara and Ait Ben Haddou',
            'seo_description' => 'Explore Ouarzazate, Morocco: Ait Ben Haddou, film studios, and Sahara desert gateways with Authentic Morocco Adventures.',
        ],
        [
            'name' => 'Chefchaouen, Morocco',
            'image' => 'chefchaouen-morocco.avif',
            'description' => 'Chefchaouen, the famous "Blue Pearl," is a mountain town in the Rif whose medina is washed in every shade of blue. Its cobbled lanes, mountain backdrop, and relaxed pace make it one of Morocco\'s most photogenic destinations.',
            'seo_alt' => 'Blue-painted streets of the medina in Chefchaouen, Morocco',
            'seo_caption' => 'Chefchaouen — the Blue Pearl of the Rif Mountains',
            'seo_description' => 'Visit Chefchaouen, Morocco: the blue medina and Rif Mountain walks with Authentic Morocco Adventures.',
        ],
        [
            'name' => 'Morocco',
            'image' => 'morocco.avif',
            'description' => 'From the Sahara dunes and High Atlas peaks to imperial cities and the Atlantic coast, Morocco offers an unforgettable blend of culture, adventure, and hospitality. This is the home base for our multi-city and multi-day journeys that span the whole country.',
            'seo_alt' => 'Scenic Moroccan landscape spanning desert, mountains, and medinas',
            'seo_caption' => 'Morocco — desert, mountains, imperial cities, and the Atlantic coast',
            'seo_description' => 'Explore Morocco with Authentic Morocco Adventures: multi-day desert tours, imperial cities, the High Atlas, and coastal escapes across the country.',
        ],
        [
            'name' => 'Agadir, Morocco',
            'image' => 'agadir-morocco.avif',
            'description' => 'Agadir is Morocco\'s premier Atlantic beach resort, with a wide golden bay, a modern marina, and year-round sunshine. Rebuilt after 1960, it pairs relaxed seaside leisure with easy access to the Souss-Massa nature reserve and Berber souks.',
            'seo_alt' => 'Golden beach and marina on the Atlantic coast in Agadir, Morocco',
            'seo_caption' => 'Agadir — Morocco\'s sunny Atlantic beach resort',
            'seo_description' => 'Discover Agadir, Morocco: Atlantic beaches, the marina, and Souss-Massa excursions with Authentic Morocco Adventures.',
        ],
    ];

    public function run(): void
    {
        $imageDir = public_path('assets/images/locations');

        foreach ($this->locations as $data) {
            $location = Location::updateOrCreate(
                ['name' => $data['name']],
                [
                    'slug' => Str::slug($data['name']),
                    'description' => $data['description'],
                    'seo_alt' => $data['seo_alt'],
                    'seo_caption' => $data['seo_caption'],
                    'seo_description' => $data['seo_description'],
                ]
            );

            $imagePath = $imageDir.DIRECTORY_SEPARATOR.$data['image'];

            // singleFile collection: only attach when empty so re-runs don't
            // duplicate media or overwrite a manual upload.
            if (! $location->hasMedia('locations') && is_file($imagePath)) {
                $location
                    ->addMedia($imagePath)
                    ->preservingOriginal() // never move/delete the source under public/assets
                    ->usingName($data['name'])
                    ->usingFileName($data['image'])
                    ->withCustomProperties([
                        'alt' => $data['seo_alt'],
                        'title' => $data['name'],
                        'caption' => $data['seo_caption'],
                        'description' => $data['seo_description'],
                    ])
                    ->toMediaCollection('locations', 'public');
            }
        }

        $this->command?->info('Seeded '.count($this->locations).' locations with images + SEO metadata.');
    }
}

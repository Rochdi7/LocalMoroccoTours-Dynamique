<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Location;
use App\Models\Post;
use App\Models\Tour;
use App\Models\Trekking;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate public/sitemap.xml from live tours, activities, treks, locations and blog posts';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap
            ->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create(route('front.tours.index'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create(route('front.activities.index'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create(route('front.trekking.index'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create(route('front.locations.index'))->setPriority(0.8))
            ->add(Url::create(route('blog.index'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create(route('front.about'))->setPriority(0.6))
            ->add(Url::create(route('front.contact'))->setPriority(0.6))
            ->add(Url::create(route('front.help-center'))->setPriority(0.4))
            ->add(Url::create(route('front.terms'))->setPriority(0.3))
            ->add(Url::create(route('front.privacy'))->setPriority(0.3));

        // Tours
        Tour::query()->select(['slug', 'updated_at'])->cursor()->each(function (Tour $tour) use ($sitemap) {
            $sitemap->add(
                Url::create(route('front.tours.show', $tour->slug))
                    ->setLastModificationDate($tour->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        // Activities
        Activity::query()->select(['slug', 'updated_at'])->cursor()->each(function (Activity $activity) use ($sitemap) {
            $sitemap->add(
                Url::create(route('front.activities.show', $activity->slug))
                    ->setLastModificationDate($activity->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        // Trekking
        Trekking::query()->select(['slug', 'updated_at'])->cursor()->each(function (Trekking $trek) use ($sitemap) {
            $sitemap->add(
                Url::create(route('front.trekking.show', $trek->slug))
                    ->setLastModificationDate($trek->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        // Locations
        Location::query()->select(['slug', 'updated_at'])->cursor()->each(function (Location $location) use ($sitemap) {
            $sitemap->add(
                Url::create(route('front.locations.show', $location->slug))
                    ->setLastModificationDate($location->updated_at)
                    ->setPriority(0.7)
            );
        });

        // Blog posts (published only)
        Post::query()->where('status', 'published')->select(['slug', 'updated_at'])->cursor()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create(route('blog.show', $post->slug))
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.6)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('sitemap.xml generated at '.public_path('sitemap.xml'));

        return self::SUCCESS;
    }
}

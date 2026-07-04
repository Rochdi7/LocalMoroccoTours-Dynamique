<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialOffer;
use App\Models\Location;
use App\Models\Tour;
use App\Models\Activity;
use App\Models\Trekking;
use App\Models\Post;
use App\Models\ReviewRating;
use App\Models\TourCategory;

class HomeController extends Controller
{
    public function index()
    {
        // -----------------------
        // SPECIAL OFFERS
        // -----------------------
        $specialOffers = SpecialOffer::where('is_active', true)
            ->orderBy('order', 'asc')
            ->take(3)
            ->get();

        // -----------------------
        // LOCATIONS (for search & trending)
        // -----------------------
        $locationsForSearch = Location::orderBy('name')->get();

        // Trending Locations (with tour counts)
        $locationsForSection = Location::withCount('tours')
            ->orderBy('name')
            ->take(5)
            ->get();

        // -----------------------
        // TOUR CATEGORIES
        // -----------------------
        $tourCategories = TourCategory::orderBy('name')->get();

        // -----------------------
        // TOURS
        // -----------------------
        $tours = Tour::with(['category', 'location', 'media'])
            ->withCount('reviews')
            ->take(8)
            ->get();

        $tours = $this->attachAverageRatings($tours, Tour::class);

        // -----------------------
        // ACTIVITIES
        // -----------------------
        $activities = Activity::with(['category', 'media'])
            ->withCount('reviews')
            ->take(8)
            ->get();

        $activities = $this->attachAverageRatings($activities, Activity::class);

        // -----------------------
        // TREKKING
        // -----------------------
        $trekking = Trekking::with(['category', 'media'])
            ->withCount('reviews')
            ->take(8)
            ->get();

        $trekking = $this->attachAverageRatings($trekking, Trekking::class);

        // -----------------------
        // BLOG POSTS
        // -----------------------
        $posts = Post::where('status', 'published')
            ->with(['author', 'category'])
            ->latest('published_at')
            ->take(3)
            ->get();

        // -----------------------
        // RETURN TO VIEW
        // -----------------------
        return view('front.index', [
            'specialOffers'       => $specialOffers,
            'tourCategories'      => $tourCategories,
            'tours'               => $tours,
            'activities'          => $activities,
            'trekking'            => $trekking,
            'posts'               => $posts,
            'locationsForSearch'  => $locationsForSearch,
            'locationsForSection' => $locationsForSection,
            'locations'           => $locationsForSection, // 👈 alias for Blade compatibility
        ]);
    }

    /**
     * Attach average ratings to a collection of models.
     */
    private function attachAverageRatings($items, $modelClass)
    {
        $ids = $items->pluck('id');

        if ($ids->isEmpty()) {
            return $items;
        }

        $ratings = ReviewRating::query()
            ->selectRaw('reviews.reviewable_id, AVG(review_ratings.score) as avg_rating')
            ->join('reviews', 'reviews.id', '=', 'review_ratings.review_id')
            ->where('reviews.reviewable_type', $modelClass)
            ->whereIn('reviews.reviewable_id', $ids)
            ->groupBy('reviews.reviewable_id')
            ->pluck('avg_rating', 'reviews.reviewable_id');

        foreach ($items as $item) {
            $item->avg_rating = round($ratings[$item->id] ?? 0, 1);
        }

        return $items;
    }

    /**
     * Page view handler for static pages.
     */
    public function pageView($page)
    {
        if (view()->exists('front.' . $page)) {
            return view('front.' . $page);
        }

        abort(404);
    }
}

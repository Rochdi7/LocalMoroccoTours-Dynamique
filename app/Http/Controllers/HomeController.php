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
        $specialOffers = SpecialOffer::where('is_active', true)
            ->orderBy('order', 'asc')
            ->take(3)
            ->get();

        $locationsForSearch = Location::orderBy('name')
            ->get();

        // For Trending Locations section
        $locationsForSection = Location::withCount('tours')
            ->orderBy('name')
            ->take(5)
            ->get();

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

        $posts = Post::where('status', 'published')
            ->with(['author', 'category'])
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('front.index', [
            'specialOffers'      => $specialOffers,
            'tourCategories'     => $tourCategories,
            'tours'              => $tours,
            'activities'         => $activities,
            'trekking'           => $trekking,
            'posts'              => $posts,
            'locationsForSearch' => $locationsForSearch,
            'locations'          => $locationsForSection, 
        ]);
    }

    /**
     * For a given collection of models, fetch their average ratings
     * and attach as a property `avg_rating`.
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

    public function pageView($page)
    {
        if (view()->exists('front.' . $page)) {
            return view('front.' . $page);
        }
        abort(404);
    }
}

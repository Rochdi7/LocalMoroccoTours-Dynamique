<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class FrontLocationController extends Controller
{
    /**
     * Show all locations, optionally filtered by search.
     */
    public function index(Request $request)
    {
        $query = Location::withCount('tours');

        if ($request->filled('location_slug')) {
            $query->where('slug', $request->location_slug);
        }

        $locations = $query->orderBy('name')->get();

        return view('front.locations.index', compact('locations'));
    }

    /**
     * Show a single location page.
     */
    public function show($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();

        $tours = \App\Models\Tour::where('location_id', $location->id)
            ->with(['media', 'location'])
            ->get();

        // Compute avg_rating & reviews_count
        $tourIds = $tours->pluck('id');

        $avgRatings = \App\Models\Review::query()
            ->selectRaw('reviewable_id, AVG(rating) as avg_rating')
            ->where('reviewable_type', \App\Models\Tour::class)
            ->whereIn('reviewable_id', $tourIds)
            ->groupBy('reviewable_id')
            ->pluck('avg_rating', 'reviewable_id');

        $reviewCounts = \App\Models\Review::query()
            ->selectRaw('reviewable_id, COUNT(*) as count_reviews')
            ->where('reviewable_type', \App\Models\Tour::class)
            ->whereIn('reviewable_id', $tourIds)
            ->groupBy('reviewable_id')
            ->pluck('count_reviews', 'reviewable_id');

        foreach ($tours as $tour) {
            $tour->avg_rating = $avgRatings[$tour->id] ?? 0;
            $tour->reviews_count = $reviewCounts[$tour->id] ?? 0;
        }

        return view('front.locations.show', compact('location', 'tours'));
    }
}

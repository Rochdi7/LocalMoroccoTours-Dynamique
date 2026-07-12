<?php

namespace App\Http\Controllers;

use App\Models\Trekking;
use App\Models\TrekkingCategory;
use App\Models\Location;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\ReviewRating;
use App\Models\RatingCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class FrontTrekkingController extends Controller
{

    public function index(Request $request)
    {
        $minPrice = Trekking::min('base_price') ?? 0;
        // Cap the filter slider at a sensible ceiling so outlier/mis-entered
        // prices don't blow the range out (e.g. $100,000).
        $maxPrice = min((int) (Trekking::max('base_price') ?? 0), 5000);

        $durations = [
            '0-3 hours',
            '3-5 hours',
            '5-7 hours',
            'Full day (7+ hours)',
            'Multi-day'
        ];

        $selectedCategories = $request->input('categories', []);
        $selectedDurations = $request->input('duration', []);
        $selectedPriceRange = $request->input('price', [$minPrice, $maxPrice]);
        $selectedSpecials = $request->input('specials', []);
        $selectedRatings = $request->input('ratings', []);
        $selectedLocations = $request->input('locations', []);
        $sortBy = $request->input('sort_by', 'featured');

        $trekkings = Trekking::with(['category', 'location', 'media'])
            ->when(!empty($selectedCategories), function ($query) use ($selectedCategories) {
                $query->whereIn('category_id', $selectedCategories);
            })
            ->when(!empty($selectedDurations), function ($query) use ($selectedDurations) {
                $query->whereIn('duration', $selectedDurations);
            })
            ->when(!empty($selectedSpecials), function ($query) use ($selectedSpecials) {
                if (in_array('free_cancellation', $selectedSpecials)) {
                    $query->where('free_cancellation_flag', 1);
                }
                if (in_array('bestseller', $selectedSpecials)) {
                    $query->where('bestseller_flag', 1);
                }
            })
            ->when(!empty($selectedLocations), function ($query) use ($selectedLocations) {
                $query->whereIn('location_id', $selectedLocations);
            })
            ->when($request->filled('price'), function ($query) use ($selectedPriceRange) {
                $query->whereBetween('base_price', $selectedPriceRange);
            });

        switch ($sortBy) {
            case 'price_low_high':
                $trekkings->orderBy('base_price', 'asc');
                break;
            case 'price_high_low':
                $trekkings->orderBy('base_price', 'desc');
                break;
            case 'booked_count':
                $trekkings->orderBy('booked_count', 'desc');
                break;
            case 'bestseller':
                $trekkings->orderBy('bestseller_flag', 'desc');
                break;
            case 'free_cancellation':
                $trekkings->orderBy('free_cancellation_flag', 'desc');
                break;
            default:
                $trekkings->orderBy('created_at', 'desc');
                break;
        }

        $trekkings = $trekkings->paginate(2);

        $trekIds = $trekkings->pluck('id');

        $trekRatings = \App\Models\ReviewRating::query()
            ->selectRaw('reviews.reviewable_id, AVG(review_ratings.score) as avg_rating')
            ->join('reviews', 'reviews.id', '=', 'review_ratings.review_id')
            ->where('reviews.reviewable_type', \App\Models\Trekking::class)
            ->whereIn('reviews.reviewable_id', $trekIds)
            ->groupBy('reviews.reviewable_id')
            ->pluck('avg_rating', 'reviews.reviewable_id');

        foreach ($trekkings as $trek) {
            $trek->avg_rating = $trekRatings[$trek->id] ?? 0;
        }

        // Filter by avg_rating
        if (!empty($selectedRatings)) {
            $filtered = $trekkings->filter(function ($trek) use ($selectedRatings) {
                return in_array(round($trek->avg_rating), $selectedRatings);
            })->values();

            // Convert back to paginator
            $trekkings = new LengthAwarePaginator(
                $filtered,
                $filtered->count(),
                $trekkings->perPage(),
                $trekkings->currentPage(),
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        $trekkingCategories = \App\Models\TrekkingCategory::all();
        $locations = \App\Models\Location::all();

        return view('front.trekking.trekking-list', compact(
            'trekkings',
            'trekkingCategories',
            'locations',
            'durations',
            'minPrice',
            'maxPrice'
        ));
    }


    public function show($slug)
    {
        // Get main trekking
        $trekking = Trekking::withCount(['reviews'])
            ->with(['location', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Compute avg_rating for the current trekking
        $categoryRating = ReviewRating::query()
            ->selectRaw('AVG(review_ratings.score) as avg_rating')
            ->join('reviews', 'reviews.id', '=', 'review_ratings.review_id')
            ->where('reviews.reviewable_type', Trekking::class)
            ->where('reviews.reviewable_id', $trekking->id)
            ->value('avg_rating');

        $overallRating = Review::query()
            ->where('reviewable_type', Trekking::class)
            ->where('reviewable_id', $trekking->id)
            ->avg('rating');

        $trekking->avg_rating = $categoryRating ?: $overallRating ?: 0;
        $trekking->reviews_count = $trekking->reviews_count ?? 0;

        // Load similar trekkings
        $similarTrekkings = Trekking::with(['location', 'category'])
            ->where('location_id', $trekking->location_id)
            ->where('id', '<>', $trekking->id)
            ->take(8)
            ->get();

        $similarTrekkingIds = $similarTrekkings->pluck('id');

        // Compute avg_rating for similar trekkings
        $categoryRatings = ReviewRating::query()
            ->selectRaw('reviews.reviewable_id, AVG(review_ratings.score) as avg_rating')
            ->join('reviews', 'reviews.id', '=', 'review_ratings.review_id')
            ->where('reviews.reviewable_type', Trekking::class)
            ->whereIn('reviews.reviewable_id', $similarTrekkingIds)
            ->groupBy('reviews.reviewable_id')
            ->pluck('avg_rating', 'reviews.reviewable_id');

        $overallRatings = Review::query()
            ->selectRaw('reviewable_id, AVG(rating) as avg_rating')
            ->where('reviewable_type', Trekking::class)
            ->whereIn('reviewable_id', $similarTrekkingIds)
            ->groupBy('reviewable_id')
            ->pluck('avg_rating', 'reviewable_id');

        $reviewCounts = Review::query()
            ->selectRaw('reviewable_id, COUNT(*) as count_reviews')
            ->where('reviewable_type', Trekking::class)
            ->whereIn('reviewable_id', $similarTrekkingIds)
            ->groupBy('reviewable_id')
            ->pluck('count_reviews', 'reviewable_id');

        foreach ($similarTrekkings as $similar) {
            $similar->avg_rating = $categoryRatings[$similar->id]
                ?? $overallRatings[$similar->id]
                ?? 0;

            $similar->reviews_count = $reviewCounts[$similar->id] ?? 0;
        }

        $similarTrekkingsCount = $similarTrekkings->count();

        // Calculate category-based scores for display in "Overall Ratings"
        $categories = RatingCategory::all();

        $overallRatings = $categories->map(function ($category) use ($trekking) {
            $scores = ReviewRating::whereHas('review', function ($q) use ($trekking) {
                $q->where('reviewable_type', Trekking::class)
                    ->where('reviewable_id', $trekking->id);
            })
                ->where('rating_category_id', $category->id)
                ->pluck('score');

            $avgScore = $scores->count() > 0
                ? round($scores->avg(), 1)
                : 0.0;

            return [
                'label' => $category->label,
                'icon' => $category->icon ?? 'icon-star',
                'score' => $avgScore,
                'text' => $this->getRatingText($avgScore),
            ];
        });

        $reviews = $trekking->reviews()->latest()->get()->map(function ($review) {
            // compute avg from review_ratings table
            $categoryAvg = ReviewRating::where('review_id', $review->id)
                ->avg('score');

            // fallback to review.rating if somehow missing
            $rating = $categoryAvg !== null
                ? round($categoryAvg, 1)
                : ($review->rating ?? 0.0);

            return (object)[
                'id' => $review->id,
                'name' => $review->name,
                'email' => $review->email,
                'title' => $review->title,
                'comment' => $review->comment,
                'images' => collect($review->images)->map(
                    fn($path) => asset('storage/' . $path)
                )->toArray(),
                'date' => $review->created_at->format('F Y'),
                'avatar' => asset('img/reviews/avatars/1.png'),
                'rating' => $rating,
                'helpful_count' => $review->helpful_count ?? 0,
                'not_helpful_count' => $review->not_helpful_count ?? 0,
            ];
        });

        return view('front.trekking.trekking-details', compact(
            'trekking',
            'similarTrekkings',
            'similarTrekkingsCount',
            'overallRatings',
            'reviews'
        ));
    }


    private function getRatingText($score)
    {
        if ($score >= 4.5) {
            return 'Excellent';
        } elseif ($score >= 4.0) {
            return 'Very Good';
        } elseif ($score >= 3.0) {
            return 'Good';
        } elseif ($score > 0) {
            return 'Average';
        }
        return '';
    }

    public function reserve(Request $request, $slug)
    {
        $trekking = Trekking::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'tour_content' => 'required|string',
        ]);

        // Reservation logic goes here

        return back()->with('success', [
            'message' => 'Your reservation was submitted!',
            'context' => 'reservation',
        ]);
    }

    public function leaveReview(Request $request, $slug)
    {
        $trekking = Trekking::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'string',
            'ratings' => 'required|array',
            'ratings.*' => 'numeric|min:1|max:5',
            'images.*' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($validated, $request, $trekking) {
            $review = new Review([
                'reviewable_type' => Trekking::class,
                'reviewable_id' => $trekking->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'title' => $validated['title'],
                'comment' => $validated['comment'],
            ]);

            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('reviews', 'public');
                    $imagePaths[] = $path;
                }
                $review->images = $imagePaths;
            }

            $review->rating = collect($validated['ratings'])->avg();
            $review->save();

            foreach ($validated['categories'] as $categoryLabel) {
                $category = RatingCategory::where('label', $categoryLabel)->first();

                if ($category && isset($validated['ratings'][$categoryLabel])) {
                    ReviewRating::create([
                        'review_id' => $review->id,
                        'rating_category_id' => $category->id,
                        'score' => $validated['ratings'][$categoryLabel],
                    ]);
                }
            }
        });

        return redirect()
            ->route('front.trekking.show', $trekking->slug)
            ->with('success', [
                'message' => 'Your review has been submitted!',
                'context' => 'review',
            ]);
    }
}

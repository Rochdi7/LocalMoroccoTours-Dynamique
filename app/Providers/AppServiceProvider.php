<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Tour;
use App\Models\Activity;
use App\Models\Trekking;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Admin theme is Bootstrap 5; use the matching paginator so the
        // default Tailwind classes (w-5/h-5, sm:hidden) don't render an
        // oversized SVG chevron and a duplicated mobile/desktop nav.
        Paginator::useBootstrapFive();

        // Feed the frontend header mega-menu (both _header + _header2).
        // Tours grouped by departure city -> the "Morocco Tours" and
        // "Day Trips" flyouts; plus the full activity/trek lists.
        View::composer(
            ['front.partials._header', 'front.partials._header2'],
            function ($view) {
                // Guard: tables may not exist during migrate/console runs.
                if (! Schema::hasTable('tours')) {
                    $view->with([
                        'navMultiDayByCity' => collect(),
                        'navDayTripsByCity' => collect(),
                        'navActivities' => collect(),
                        'navTrekkings' => collect(),
                    ]);

                    return;
                }

                // Reference-site city order: Marrakech first, then the rest.
                // Any city not listed falls to the end (alphabetically).
                $cityOrder = [
                    'Marrakech, Morocco',
                    'Fes, Morocco',
                    'Casablanca, Morocco',
                    'Tangier, Morocco',
                    'Ouarzazate, Morocco',
                    'Chefchaouen, Morocco',
                    'Agadir, Morocco',
                ];

                // Exact tour order (by slug) copied from the
                // authenticmoroccoadventures
                // reference site so each city group ranks identically. Tours
                // not listed fall to the end (by day count, then title).
                $slugOrder = array_flip([
                    // --- Multi-day, From Marrakech ---
                    '2-day-marrakech-desert-tour-to-essaouira',
                    '2-day-desert-tour-from-marrakech-to-agadir',
                    '2-day-desert-tour-from-marrakech-to-ouarzazate-ait-benhaddou',
                    '2-day-marrakech-desert-tour-to-casablanca-rabat',
                    '2-day-desert-tour-from-marrakech-to-agadir-essaouira',
                    // id 7 — renamed in production; keep old + new slug
                    'merzouga-desert-tour-from-marrakech-2-days',
                    '2-day-desert-tour-from-marrakech-to-merzouga',
                    '2-day-sahara-desert-tour-from-marrakech-to-zagora',
                    // id 10 — renamed in production; keep old + new slug
                    'marrakech-desert-tour-3-days-to-merzouga-dunes',
                    '3-day-desert-tour-from-marrakech-to-merzouga-dunes',
                    // id 11 — renamed in production; keep old + new slug
                    'marrakech-to-fes-desert-tour-3-days-via-sahara',
                    '3-day-desert-tour-from-marrakech-to-fes-via-sahara',
                    // id 9 — renamed in production; keep old + new slug
                    'sahara-desert-tour-from-marrakech-3-days-to-chigaga',
                    '3-day-sahara-desert-tour-from-marrakech-to-chigaga',
                    '4-day-desert-tour-from-marrakech-to-merzouga',
                    '4-day-desert-tour-from-marrakech-via-sahara-to-chefchaouen',
                    // id 14 — renamed in production; keep old + new slug
                    'luxury-sahara-desert-tour-from-marrakech-5-days',
                    '5-day-luxury-sahara-desert-tour-from-marrakech',
                    '8-days-marrakech-zagora-merzouga',
                    '8-day-marrakech-sahara-desert-tour-to-fes-chefchaouen',
                    '11-day-morocco-desert-tour-from-marrakech',
                    '4-days-atlas-zagora-desert-tour',
                    '5-days-toubkal-merzouga-tour',
                    // --- Multi-day, From Fes ---
                    '2-days-fes-to-sahara-desert-back',
                    '2-days-fes-to-chefchaouen',
                    '3-days-fes-to-merzouga-desert',
                    '3-day-fes-to-marrakech-desert-tour-via-sahara',
                    '4-day-fes-to-marrakech-desert-tour-via-merzouga',
                    '5-day-fes-to-marrakech-desert-tour-via-sahara',
                    // --- Multi-day, From Casablanca ---
                    '2-days-casablanca-to-marrakech',
                    '2-days-casablanca-to-chefchaouen',
                    '3-days-casablanca-marrakech-essaouira',
                    '3-days-casablanca-chefchaouen-fes',
                    '5-days-casablanca-sahara-desert',
                    '7-days-sahara-imperial-cities',
                    '9-days-private-tour-from-casablanca',
                    '11-days-grand-morocco-tour',
                    '14-days-grand-morocco-tour',
                    // --- Multi-day, From Tangier ---
                    '2-day-morocco-desert-tour-from-tangier-to-chefchaouen',
                    '3-day-morocco-desert-tour-from-tangier-to-chefchaouen-fes',
                    '4-day-morocco-desert-tour-from-tangier-to-fes-via-atlantic-coast',
                    '6-day-morocco-desert-tour-from-tangier-to-sahara-marrakech',
                    '9-day-morocco-desert-tour-from-tangier-to-merzouga',
                    '12-day-morocco-desert-tours-from-tangier',
                    // --- Multi-day, From Ouarzazate ---
                    '2-days-ouarzazate-to-merzouga',
                    '3-days-ouarzazate-to-merzouga-desert',
                    '3-days-ouarzazate-merzouga-fes',
                    // --- Multi-day, From Chefchaouen ---
                    '5-day-morocco-desert-tour-from-chefchaouen-to-sahara',
                    '6-day-morocco-desert-tour-from-chefchaouen-to-marrakech',
                    '7-day-morocco-desert-tour-from-chefchaouen-around-morocco',
                    // --- Multi-day, From Agadir ---
                    '2-days-agadir-to-zagora-desert',
                    '3-days-agadir-to-chigaga-desert',
                    '4-days-agadir-to-merzouga-desert',
                    // --- Day trips, Marrakech excursions ---
                    'marrakech-to-ait-benhaddou-day-trip',
                    'marrakech-to-ouzoud-waterfalls-day-trip',
                    'marrakech-to-essaouira-day-trip',
                    'marrakech-to-ourika-valley-day-trip',
                    'agafay-desert-tour-from-marrakech',
                    // --- Day trips, Fes excursions ---
                    'meknes-volubilis-day-trip-from-fes',
                    'fes-to-chefchaouen-day-trip',
                    'rabat-day-trip-from-fes',
                    'fes-to-atlas-mountains-day-trip',
                    'guided-medina-tour-in-fes',
                    // --- Day trips, Casablanca excursions ---
                    'casablanca-to-fes-day-trip',
                    'casablanca-to-marrakech-day-trip',
                    'casablanca-to-rabat-day-trip',
                ]);

                // Fallback for tours not in the explicit list: day count.
                $days = function ($tour) {
                    if (preg_match('/(\d+)/', (string) $tour->duration, $m)) {
                        return (int) $m[1];
                    }
                    if (preg_match('/(\d+)\s*[- ]?day/i', (string) $tour->title, $m)) {
                        return (int) $m[1];
                    }

                    return PHP_INT_MAX;
                };

                // Single sort key: explicit slug rank, then day count, then
                // title as a stable tie-break. (sortBy with an ARRAY of
                // closures is not supported in this Laravel version — it
                // treats them as attribute names — so we build one key.)
                $rank = fn ($tour) => sprintf(
                    '%06d-%06d-%s',
                    $slugOrder[$tour->slug] ?? 900000,
                    $days($tour) === PHP_INT_MAX ? 999999 : $days($tour),
                    $tour->title
                );

                $group = fn (string $type) => Tour::with('location')
                    ->where('type', $type)
                    ->get()
                    ->groupBy(fn ($t) => $t->location?->name ?? 'Morocco')
                    ->map(fn ($tours) => $tours
                        ->sortBy(fn ($t) => $rank($t))
                        ->values())
                    ->sortKeysUsing(function ($a, $b) use ($cityOrder) {
                        $ia = array_search($a, $cityOrder, true);
                        $ib = array_search($b, $cityOrder, true);
                        $ia = $ia === false ? PHP_INT_MAX : $ia;
                        $ib = $ib === false ? PHP_INT_MAX : $ib;

                        return $ia <=> $ib ?: strcmp($a, $b);
                    });

                $view->with([
                    'navMultiDayByCity' => $group('multi_day'),
                    'navDayTripsByCity' => $group('day_trip'),
                    'navActivities' => Activity::orderBy('title')->get(['title', 'slug']),
                    'navTrekkings' => Trekking::orderBy('title')->get(['title', 'slug']),
                ]);
            }
        );
    }
}

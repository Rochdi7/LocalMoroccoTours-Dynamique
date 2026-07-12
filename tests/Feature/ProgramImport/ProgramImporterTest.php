<?php

namespace Tests\Feature\ProgramImport;

use App\Models\Location;
use App\Models\Tour;
use App\Models\TourCategory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProgramImporterTest extends ProgramImportTestCase
{
    public function test_dry_run_writes_nothing(): void
    {
        $fixture = $this->buildFixture([$this->matchedTour()]);

        $reporter = $this->runImport($fixture, ['dry_run' => true]);

        $this->assertSame(0, Tour::count());
        $this->assertSame(0, TourCategory::count());
        $this->assertSame(0, Location::count());
        $this->assertSame(0, Media::count());
        $summary = $reporter->summary();
        $this->assertSame(1, $summary['would-create']);
        $this->assertSame(1, $summary['cover_action:would-attach']);
        $this->assertSame(1, $summary['gallery_action:would-attach']);
    }

    public function test_apply_creates_record_with_correct_mapping(): void
    {
        $fixture = $this->buildFixture([$this->matchedTour() + ['bestseller' => 'true', 'base_price' => '']]);

        $this->runImport($fixture);

        $tour = Tour::firstOrFail();
        $this->assertSame('test-tour-to-merzouga', $tour->slug);
        $this->assertSame('multi_day', $tour->type);
        $this->assertTrue($tour->bestseller_flag);
        $this->assertTrue($tour->free_cancellation_flag);
        $this->assertSame(0.0, (float) $tour->base_price); // blank source, NOT NULL column
        $this->assertSame(['Transport'], $tour->included);
        $this->assertSame(['English', 'French'], $tour->languages);
        $this->assertStringContainsString('Aït Benhaddou', $tour->itinerary[0]);
        $this->assertStringEndsWith('</iframe>', trim($tour->map_frame));
        // Tour.highlights is stored as JSON text (no array cast) per project convention.
        $this->assertSame(['One highlight'], json_decode($tour->highlights, true));
        $this->assertSame('Tours from Marrakech', $tour->category->name);
        $this->assertSame('Marrakech, Morocco', $tour->location->name);
    }

    public function test_rerun_does_not_duplicate(): void
    {
        $fixture = $this->buildFixture([$this->matchedTour()]);

        $this->runImport($fixture);
        $reporter = $this->runImport($fixture);

        $this->assertSame(1, Tour::count());
        $this->assertSame(1, TourCategory::count());
        $this->assertSame(2, Media::count()); // still just cover + gallery
        $this->assertSame(1, $reporter->summary()['skipped']);
    }

    public function test_preserves_existing_production_values(): void
    {
        $def = $this->matchedTour();
        $fixture = $this->buildFixture([$def]);
        $cat = TourCategory::create(['name' => 'X', 'slug' => 'x']);
        $loc = Location::create(['name' => 'Y', 'slug' => 'y']);
        Tour::create([
            'title' => $def['title'], 'slug' => 'test-tour-to-merzouga', 'type' => 'day_trip',
            'overview' => 'Manually written overview.', 'duration' => '9 days', 'age_range' => '18+',
            'base_price' => 199.5, 'booked_count' => 42, 'category_id' => $cat->id, 'location_id' => $loc->id,
            'included' => [], 'excluded' => [], 'itinerary' => [], 'languages' => [],
        ]);

        $this->runImport($fixture);

        $tour = Tour::firstOrFail();
        $this->assertSame('Manually written overview.', $tour->overview); // not overwritten
        $this->assertSame('9 days', $tour->duration);
        $this->assertSame('day_trip', $tour->type);
        $this->assertSame(199.5, (float) $tour->base_price); // price untouched
        $this->assertSame(42, $tour->booked_count);
        $this->assertSame($cat->id, $tour->category_id); // relations not rewired
        // empty JSON fields WERE filled from source
        $this->assertSame(['Transport'], $tour->included);
        $this->assertNotEmpty($tour->itinerary);
    }

    public function test_update_content_replaces_content_but_not_price_or_bookings(): void
    {
        $def = $this->matchedTour();
        $fixture = $this->buildFixture([$def]);
        $cat = TourCategory::create(['name' => 'X', 'slug' => 'x']);
        $loc = Location::create(['name' => 'Y', 'slug' => 'y']);
        Tour::create([
            'title' => $def['title'], 'slug' => 'test-tour-to-merzouga',
            'overview' => 'Old overview.', 'duration' => '9 days', 'age_range' => '18+',
            'base_price' => 199.5, 'booked_count' => 42, 'category_id' => $cat->id, 'location_id' => $loc->id,
            'included' => [], 'excluded' => [], 'itinerary' => [], 'languages' => [],
        ]);

        $this->runImport($fixture, ['update_content' => true]);

        $tour = Tour::firstOrFail();
        $this->assertSame('An overview.', trim($tour->overview)); // replaced
        $this->assertSame('2 days', $tour->duration);              // replaced
        $this->assertSame(199.5, (float) $tour->base_price);       // still protected
        $this->assertSame(42, $tour->booked_count);                // still protected
    }

    public function test_slug_miss_with_matching_title_is_conflict_not_merge(): void
    {
        $def = $this->matchedTour();
        $fixture = $this->buildFixture([$def]);
        $cat = TourCategory::create(['name' => 'X', 'slug' => 'x']);
        $loc = Location::create(['name' => 'Y', 'slug' => 'y']);
        Tour::create([
            'title' => 'Test  Tour to MERZOUGA', 'slug' => 'a-different-slug',
            'overview' => 'O', 'duration' => 'd', 'age_range' => '', 'base_price' => 0,
            'category_id' => $cat->id, 'location_id' => $loc->id,
            'included' => [], 'excluded' => [], 'itinerary' => [], 'languages' => [],
        ]);

        $reporter = $this->runImport($fixture);

        $this->assertSame(1, Tour::count()); // nothing created or merged
        $this->assertSame(1, $reporter->summary()['conflict']);
    }

    public function test_only_new_skips_existing_records(): void
    {
        $fixture = $this->buildFixture([$this->matchedTour()]);
        $this->runImport($fixture);
        Tour::query()->update(['overview' => '']); // would normally be refilled

        $this->runImport($fixture, ['only_new' => true]);

        $this->assertSame('', Tour::first()->overview); // record content untouched
    }

    public function test_sections_filter_and_trekking_defaults(): void
    {
        $trek = [
            'section' => 'trekking', 'title' => 'Test Trek', 'category' => 'Atlas Trekking',
            'location' => 'Marrakech, Morocco',
        ];
        $fixture = $this->buildFixture([$this->matchedTour(), $trek]);

        $this->runImport($fixture, ['sections' => ['trekking']]);

        $this->assertSame(0, Tour::count());
        $trekking = \App\Models\Trekking::firstOrFail();
        $this->assertSame('Moderate', $trekking->difficulty_level); // schema-required default
        $this->assertSame(['One highlight'], $trekking->highlights); // array cast on Trekking
    }
}

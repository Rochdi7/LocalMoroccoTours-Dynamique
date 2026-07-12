<?php

namespace Tests\Feature\ProgramImport;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Services\ProgramImport\ProgramImporter;
use App\Services\ProgramImport\ProgramImportReporter;
use App\Services\ProgramImport\ProgramImportRollbackService;
use App\Services\ProgramImport\ProgramMediaImporter;
use App\Services\ProgramImport\ToursDataParser;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProgramImportRollbackTest extends ProgramImportTestCase
{
    private function applyAndReport(string $fixture): ProgramImportReporter
    {
        $records = (new ToursDataParser)->parse($fixture);
        $reporter = new ProgramImportReporter('test-'.uniqid());
        (new ProgramImporter(new ProgramMediaImporter($this->publicBase), $reporter))
            ->run($records, [
                'dry_run' => false, 'sections' => [], 'slug' => null, 'only_new' => false,
                'only_missing_media' => false, 'replace_seed_media' => false,
                'update_content' => false, 'limit' => null,
            ]);
        $reporter->write();

        return $reporter;
    }

    public function test_rollback_removes_only_run_created_data(): void
    {
        // Pre-existing record + category that must survive.
        $preCat = TourCategory::create(['name' => 'Pre', 'slug' => 'pre']);
        $pre = Tour::create([
            'title' => 'Pre-existing', 'slug' => 'pre-existing', 'overview' => 'O',
            'duration' => 'd', 'age_range' => '', 'base_price' => 10,
            'category_id' => $preCat->id,
            'location_id' => \App\Models\Location::create(['name' => 'L', 'slug' => 'l'])->id,
        ]);

        $reporter = $this->applyAndReport($this->buildFixture([$this->matchedTour()]));

        $this->assertSame(2, Tour::count());
        $this->assertSame(2, Media::count());

        $service = new ProgramImportRollbackService;
        // dry-run deletes nothing
        $service->rollback($reporter->runId, apply: false);
        $this->assertSame(2, Tour::count());
        $this->assertSame(2, Media::count());

        $result = $service->rollback($reporter->runId, apply: true);

        $this->assertSame(1, Tour::count());
        $this->assertSame('pre-existing', Tour::first()->slug);
        $this->assertSame(0, Media::count());
        $this->assertNotNull(TourCategory::find($preCat->id));
        $this->assertNull(TourCategory::where('name', 'Tours from Marrakech')->first(), 'unused run-created category removed');
        $this->assertNotEmpty($result['actions']);
        $this->assertNotNull($pre->fresh());
    }

    public function test_rollback_refuses_modified_records(): void
    {
        $reporter = $this->applyAndReport($this->buildFixture([$this->matchedTour()]));
        $tour = Tour::firstOrFail();
        $tour->timestamps = true;
        $tour->forceFill(['overview' => 'Edited by admin', 'updated_at' => now()->addMinute()])->save();

        $result = (new ProgramImportRollbackService)->rollback($reporter->runId, apply: true);

        $this->assertNotNull($tour->fresh(), 'modified record must survive rollback');
        $refused = array_filter($result['actions'], fn ($a) => $a['type'] === 'record' && $a['status'] === 'refused');
        $this->assertNotEmpty($refused);
        // media managed by the run is still removed
        $this->assertSame(0, Media::count());
    }

    public function test_rollback_preserves_manual_media_and_category_in_use(): void
    {
        $reporter = $this->applyAndReport($this->buildFixture([$this->matchedTour()]));

        // Manual upload on the run-created record.
        $tour = Tour::firstOrFail();
        $manualFile = $this->makeWebp('assets/manual.webp', 55);
        $manual = $tour->addMedia($this->publicBase.'/'.$manualFile['path'])
            ->preservingOriginal()->toMediaCollection('gallery', 'public');

        // Category also used by another record created outside the run.
        $cat = TourCategory::where('name', 'Tours from Marrakech')->firstOrFail();
        Tour::create([
            'title' => 'Other', 'slug' => 'other', 'overview' => 'O', 'duration' => 'd',
            'age_range' => '', 'base_price' => 0, 'category_id' => $cat->id,
            'location_id' => \App\Models\Location::where('name', 'Marrakech, Morocco')->first()->id,
        ]);

        $result = (new ProgramImportRollbackService)->rollback($reporter->runId, apply: true);

        $this->assertNotNull($manual->fresh(), 'manual media preserved');
        $this->assertNotNull($tour->fresh(), 'record with manual media refused deletion');
        $this->assertNotNull($cat->fresh(), 'category still in use is preserved');
        $statuses = array_column($result['actions'], 'status');
        $this->assertContains('refused', $statuses);
    }
}

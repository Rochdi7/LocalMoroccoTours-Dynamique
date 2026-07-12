<?php

namespace Tests\Feature\ProgramSeeders;

use App\Models\Activity;
use App\Models\Trekking;
use Database\Seeders\ActivitySeeder;
use Database\Seeders\TrekkingSeeder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\Feature\ProgramImport\ProgramImportTestCase;

/**
 * The seeders are thin wrappers around programs:import — tours-data.md stays
 * the single source of truth. These tests run the real wrappers end-to-end on
 * sqlite :memory: with a sandboxed media disk (trekking/activity sections only,
 * to keep runtime reasonable; full 77/98 coverage lives in the importer suite
 * and the verified dry-run).
 */
class ProgramSeederWrapperTest extends ProgramImportTestCase
{
    public function test_trekking_seeder_wrapper_imports_records_and_media(): void
    {
        (new TrekkingSeeder)->run();

        $this->assertSame(3, Trekking::count());
        $this->assertSame(6, Media::count()); // 3 covers + 3 galleries

        foreach (Trekking::all() as $trek) {
            $cover = $trek->getFirstMedia('cover');
            $this->assertNotNull($cover, $trek->slug);
            $this->assertCount(1, $trek->getMedia('gallery'), $trek->slug);
            $this->assertNotSame('', (string) $cover->getCustomProperty('alt'));
            $this->assertNotSame('', (string) $cover->getCustomProperty('title'));
            $this->assertNotSame('', (string) $cover->getCustomProperty('caption'));
            $this->assertNotSame('', (string) $cover->getCustomProperty('description'));
            $this->assertSame('programs-import', $cover->getCustomProperty('managed_by'));
            $this->assertMatchesRegularExpression('/^[0-9a-f]{64}$/', (string) $cover->getCustomProperty('source_sha256'));
        }

        // Trekking rows created via the importer get the documented defaults.
        $this->assertSame('Moderate', Trekking::first()->difficulty_level);
    }

    public function test_trekking_seeder_wrapper_is_idempotent(): void
    {
        (new TrekkingSeeder)->run();
        (new TrekkingSeeder)->run();

        $this->assertSame(3, Trekking::count());
        $this->assertSame(6, Media::count());
    }

    public function test_activity_seeder_wrapper_imports_records_and_marrakech_activities_media(): void
    {
        (new ActivitySeeder)->run();

        $this->assertSame(12, Activity::count());
        $this->assertSame(24, Media::count(), 'each activity gets its cover + gallery from Marrakech Activities');
        $this->assertSame(0, Trekking::count(), 'section filter respected');

        foreach (Activity::all() as $activity) {
            $cover = $activity->getFirstMedia('cover');
            $this->assertNotNull($cover, $activity->slug);
            $this->assertCount(1, $activity->getMedia('gallery'), $activity->slug);
            $this->assertStringContainsString('Marrakech Activities', $cover->getCustomProperty('source_path'));
            $this->assertNotSame('', (string) $cover->getCustomProperty('alt'));
        }

        // spot-check one specific normalized-folder-name match
        $cooking = Activity::where('slug', 'marrakech-cooking-class')->firstOrFail();
        $this->assertStringContainsString('cooking-class', $cooking->getFirstMedia('cover')->file_name);

        // re-run: no duplicates
        (new ActivitySeeder)->run();
        $this->assertSame(24, Media::count());
    }
}

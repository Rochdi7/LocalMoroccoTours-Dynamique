<?php

namespace Tests\Feature\ProgramImport;

use App\Models\Tour;
use App\Models\Trekking;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProgramMediaImporterTest extends ProgramImportTestCase
{
    public function test_attaches_cover_and_gallery_with_custom_properties(): void
    {
        $fixture = $this->buildFixture([$this->matchedTour()]);

        $this->runImport($fixture);

        $tour = Tour::firstOrFail();
        $cover = $tour->getFirstMedia('cover');
        $gallery = $tour->getMedia('gallery');

        $this->assertNotNull($cover);
        $this->assertCount(1, $gallery);
        $this->assertSame('Sample cover alt', $cover->getCustomProperty('alt'));
        $this->assertSame('Sample cover Title', $cover->getCustomProperty('title'));
        $this->assertSame('A caption.', $cover->getCustomProperty('caption'));
        $this->assertSame('programs-import', $cover->getCustomProperty('managed_by'));
        $this->assertSame(0.95, $cover->getCustomProperty('image_match_confidence'));
        $this->assertStringStartsWith('programs-import:tour:test-tour-to-merzouga:cover:', $cover->getCustomProperty('seed_key'));
        // Source file preserved in place (preservingOriginal).
        $this->assertFileExists($this->publicBase.'/'.$cover->getCustomProperty('source_path'));
    }

    public function test_repeated_import_does_not_duplicate_media(): void
    {
        $fixture = $this->buildFixture([$this->matchedTour()]);

        $this->runImport($fixture);
        $this->runImport($fixture);
        $reporter = $this->runImport($fixture);

        $this->assertSame(2, Media::count());
        $this->assertSame(1, $reporter->summary()['cover_action:media-skipped'] ?? $reporter->summary()['cover_action:media-skipped']);
    }

    public function test_manual_cover_is_preserved(): void
    {
        $def = $this->matchedTour();
        $fixture = $this->buildFixture([$def]);
        $this->runImport($fixture, ['dry_run' => true]); // ensure files exist

        // create the record first, then attach a manual cover
        $this->runImport($fixture, ['sections' => ['tour'], 'only_new' => false, 'only_missing_media' => true]);
        $tour = Tour::firstOrFail();
        $manualFile = $this->makeWebp('assets/manual-upload.webp', 77);
        $manual = $tour->addMedia($this->publicBase.'/'.$manualFile['path'])
            ->preservingOriginal()->toMediaCollection('cover', 'public');
        $manualId = $manual->id;

        $reporter = $this->runImport($fixture, ['replace_seed_media' => true]);

        $tour->refresh();
        $this->assertSame($manualId, $tour->getFirstMedia('cover')->id, 'manual cover must survive even --replace-seed-media');
        $this->assertSame(1, $reporter->summary()['cover_action:media-skipped']);
    }

    public function test_replace_seed_media_replaces_only_importer_media(): void
    {
        $def = $this->matchedTour();
        $fixture = $this->buildFixture([$def]);
        $this->runImport($fixture);
        $oldCoverId = Tour::first()->getFirstMedia('cover')->id;

        // Change the cover image content (new sha) in the fixture.
        $slug = 'test-tour-to-merzouga';
        $newCover = $this->makeWebp("assets/images/programs/Cat/Prog1/{$slug}-dunes-cover.webp", 999);
        $def['images']['cover'] = $newCover;
        $fixture = $this->buildFixture([$def]);

        // Without the flag: conflict reported, media unchanged.
        $reporter = $this->runImport($fixture);
        $this->assertSame(1, $reporter->summary()['cover_action:media-conflict']);
        $this->assertSame($oldCoverId, Tour::first()->getFirstMedia('cover')->id);

        // With the flag: seed cover replaced.
        $this->runImport($fixture, ['replace_seed_media' => true]);
        $newCoverMedia = Tour::first()->getFirstMedia('cover');
        $this->assertNotSame($oldCoverId, $newCoverMedia->id);
        $this->assertSame($newCover['sha256'], $newCoverMedia->getCustomProperty('source_sha256'));
        $this->assertNull(Media::find($oldCoverId));
    }

    public function test_invalid_checksum_blocks_attachment(): void
    {
        $def = $this->matchedTour();
        $def['images']['cover']['sha256'] = str_repeat('a', 64);
        $fixture = $this->buildFixture([$def]);

        $reporter = $this->runImport($fixture);

        $tour = Tour::firstOrFail(); // record still imported
        $this->assertNull($tour->getFirstMedia('cover'));
        $this->assertCount(1, $tour->getMedia('gallery')); // healthy image unaffected
        $this->assertSame(1, $reporter->summary()['cover_action:failed']);
    }

    public function test_missing_file_blocks_attachment(): void
    {
        $def = $this->matchedTour();
        $fixture = $this->buildFixture([$def]);
        File::delete($this->publicBase.'/'.$def['images']['gallery']['path']);

        $reporter = $this->runImport($fixture);

        $this->assertSame(1, $reporter->summary()['gallery_action:failed']);
        $this->assertNotNull(Tour::first()->getFirstMedia('cover'));
    }

    public function test_unmatched_record_gets_no_media(): void
    {
        $fixture = $this->buildFixture([[
            'section' => 'activity', 'title' => 'Cooking Class', 'category' => 'Marrakech Activities',
            'location' => 'Marrakech, Morocco',
        ]]);

        $reporter = $this->runImport($fixture);

        $this->assertSame(0, Media::count());
        $this->assertSame(1, $reporter->summary()['cover_action:no-source-media']);
    }

    public function test_low_confidence_match_attaches_nothing(): void
    {
        $def = $this->matchedTour();
        $def['confidence'] = '0.62';
        $fixture = $this->buildFixture([$def]);

        $this->runImport($fixture);

        $this->assertSame(0, Media::count());
    }

    public function test_same_source_image_can_attach_to_two_models(): void
    {
        // Simulates the intentional Hassan II duplicate: same bytes, two programs.
        $tourDef = $this->matchedTour('Tour One');
        $trekDef = [
            'section' => 'trekking', 'title' => 'Trek One', 'category' => 'Atlas Trekking',
            'location' => 'Marrakech, Morocco',
            'images' => $tourDef['images'], // identical files and hashes
        ];
        $fixture = $this->buildFixture([$tourDef, $trekDef]);

        $this->runImport($fixture);

        $this->assertNotNull(Tour::first()->getFirstMedia('cover'));
        $this->assertNotNull(Trekking::first()->getFirstMedia('cover'));
        $this->assertSame(4, Media::count()); // separate media rows per model
    }
}

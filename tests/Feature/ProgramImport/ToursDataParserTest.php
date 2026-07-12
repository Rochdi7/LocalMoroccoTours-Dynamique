<?php

namespace Tests\Feature\ProgramImport;

use App\Services\ProgramImport\ToursDataParser;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Parses the REAL tours-data.md (read-only) plus synthetic fixtures.
 * No database access.
 */
class ToursDataParserTest extends TestCase
{
    private ToursDataParser $parser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new ToursDataParser;
    }

    public function test_parses_all_77_records_with_expected_sections(): void
    {
        $records = $this->parser->parse(base_path('tours-data.md'));

        $this->assertCount(77, $records);
        $this->assertCount(62, array_filter($records, fn ($r) => $r->section === 'tour'));
        $this->assertCount(12, array_filter($records, fn ($r) => $r->section === 'activity'));
        $this->assertCount(3, array_filter($records, fn ($r) => $r->section === 'trekking'));
    }

    public function test_matched_and_unmatched_counts(): void
    {
        $records = $this->parser->parse(base_path('tours-data.md'));

        $matched = array_filter($records, fn ($r) => $r->hasImages());
        $this->assertCount(49, $matched);
        $this->assertCount(28, array_filter($records, fn ($r) => ! $r->hasImages()));

        foreach ($matched as $r) {
            $this->assertNotNull($r->cover, $r->title);
            $this->assertNotNull($r->gallery, $r->title);
            $this->assertStringEndsWith('-cover.webp', $r->cover->filename, $r->title);
            $this->assertStringEndsWith('-gallery.webp', $r->gallery->filename, $r->title);
            $this->assertMatchesRegularExpression('/^[0-9a-f]{64}$/', $r->cover->sha256);
            $this->assertGreaterThanOrEqual(0.80, $r->matchConfidence, $r->title);
        }
    }

    public function test_preserves_iframe_and_unicode(): void
    {
        $records = $this->parser->parse(base_path('tours-data.md'));
        $first = $records[0];

        $this->assertStringStartsWith('<iframe src="https://www.google.com/maps/embed', $first->mapFrame);
        $this->assertStringEndsWith('</iframe>', $first->mapFrame);
        $this->assertContains('Atlas Mountains and Aït Benhaddou', $first->highlights);
        $this->assertSame('11-Day Morocco Desert Tour from Marrakech', $first->title);
        $this->assertCount(11, $first->itinerary);
        $this->assertStringContainsString('Day 1: Arrival in Marrakech', $first->itinerary[0]);
    }

    public function test_validate_passes_against_real_files(): void
    {
        $records = $this->parser->parse(base_path('tours-data.md'));

        // Full run incl. SHA-256 of all 98 files.
        $problems = $this->parser->validate($records, public_path());

        $this->assertSame([], $problems);
    }

    public function test_unmatched_records_have_null_images_and_zero_confidence(): void
    {
        $records = $this->parser->parse(base_path('tours-data.md'));
        $unmatched = array_values(array_filter($records, fn ($r) => ! $r->hasImages()));

        foreach ($unmatched as $r) {
            $this->assertNull($r->cover);
            $this->assertNull($r->gallery);
            $this->assertSame('unmatched-record', $r->matchStatus);
            $this->assertSame(0.0, $r->matchConfidence);
        }
    }

    public function test_detects_missing_file_and_invalid_hash(): void
    {
        $dir = storage_path('framework/testing/parser-'.uniqid());
        File::ensureDirectoryExists($dir.'/assets/images/programs/C/P');
        $img = $dir.'/assets/images/programs/C/P/x-cover.webp';
        $im = imagecreatetruecolor(8, 8);
        imagewebp($im, $img);
        imagedestroy($im);
        $sha = hash_file('sha256', $img);

        $md = "## ITEM\n\n- section: tour\n- title: T\n- category: C\n- location: L\n".
            "- overview: |\n    O\n- duration: 1 day\n- bestseller: false\n- free_cancellation: true\n".
            "- images:\n    cover:\n      path: \"assets/images/programs/C/P/x-cover.webp\"\n".
            "      filename: \"x-cover.webp\"\n      alt: \"a\"\n      title: \"t\"\n      sha256: \"{$sha}\"\n".
            "    gallery:\n      - path: \"assets/images/programs/C/P/missing-gallery.webp\"\n".
            "        filename: \"missing-gallery.webp\"\n        alt: \"b\"\n        sha256: \"".str_repeat('0', 64)."\"\n";
        File::put($dir.'/f.md', $md);

        $records = $this->parser->parse($dir.'/f.md');
        $problems = $this->parser->validate($records, $dir);
        $this->assertNotEmpty(array_filter($problems, fn ($p) => str_contains($p, 'file missing on disk')));

        // Now corrupt the cover hash.
        File::put($dir.'/f.md', str_replace($sha, str_repeat('a', 64), $md));
        $records = $this->parser->parse($dir.'/f.md');
        $problems = $this->parser->validate($records, $dir);
        $this->assertNotEmpty(array_filter($problems, fn ($p) => str_contains($p, 'SHA-256 mismatch')));

        File::deleteDirectory($dir);
    }

    public function test_rejects_unknown_section(): void
    {
        $dir = storage_path('framework/testing/parser-'.uniqid());
        File::ensureDirectoryExists($dir);
        File::put($dir.'/f.md', "## ITEM\n\n- section: banana\n- title: X\n- images: null\n");

        $records = $this->parser->parse($dir.'/f.md');
        $problems = $this->parser->validate($records);

        $this->assertNotEmpty(array_filter($problems, fn ($p) => str_contains($p, "unknown section 'banana'")));
        File::deleteDirectory($dir);
    }
}

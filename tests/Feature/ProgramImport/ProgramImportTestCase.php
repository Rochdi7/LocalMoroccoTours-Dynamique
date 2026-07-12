<?php

namespace Tests\Feature\ProgramImport;

use App\Services\ProgramImport\ProgramImporter;
use App\Services\ProgramImport\ProgramImportReporter;
use App\Services\ProgramImport\ProgramMediaImporter;
use App\Services\ProgramImport\ToursDataParser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Base for importer tests. Uses an in-memory SQLite database and a sandboxed
 * "public" filesystem so the developer MySQL database and the real
 * storage/app/public directory are never touched.
 */
abstract class ProgramImportTestCase extends TestCase
{
    protected string $sandbox;

    protected string $publicBase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
        $this->artisan('migrate')->run();

        $this->sandbox = storage_path('framework/testing/program-import-'.uniqid());
        $this->publicBase = $this->sandbox.'/public';
        File::ensureDirectoryExists($this->publicBase);
        File::ensureDirectoryExists($this->sandbox.'/disk');
        config(['filesystems.disks.public.root' => $this->sandbox.'/disk']);
    }

    protected function tearDown(): void
    {
        if (isset($this->sandbox) && File::isDirectory($this->sandbox)) {
            File::deleteDirectory($this->sandbox);
        }
        parent::tearDown();
    }

    /**
     * Write a tiny valid WebP into the sandboxed public tree.
     *
     * @return array{path: string, sha256: string, size: int}
     */
    protected function makeWebp(string $relativePath, int $seed = 1): array
    {
        $abs = $this->publicBase.'/'.$relativePath;
        File::ensureDirectoryExists(dirname($abs));
        $im = imagecreatetruecolor(16, 16);
        imagefill($im, 0, 0, imagecolorallocate($im, ($seed * 37) % 255, ($seed * 91) % 255, ($seed * 53) % 255));
        imagewebp($im, $abs, 80);
        imagedestroy($im);

        return [
            'path' => $relativePath,
            'sha256' => hash_file('sha256', $abs),
            'size' => filesize($abs),
        ];
    }

    /**
     * Render a minimal tours-data.md fixture from record definition arrays.
     */
    protected function buildFixture(array $records): string
    {
        $out = "# Fixture\n";
        foreach ($records as $r) {
            $out .= "\n## ITEM\n\n";
            $out .= "- section: {$r['section']}\n";
            if (isset($r['type'])) {
                $out .= "- type: {$r['type']}\n";
            }
            $out .= "- title: {$r['title']}\n";
            $out .= "- category: {$r['category']}\n";
            $out .= '- location: '.($r['location'] ?? '')."\n";
            $out .= "- overview: |\n    ".str_replace("\n", "\n    ", $r['overview'] ?? 'An overview.')."\n";
            $out .= "- highlights:\n";
            foreach ($r['highlights'] ?? ['One highlight'] as $h) {
                $out .= "    - {$h}\n";
            }
            $out .= '- duration: '.($r['duration'] ?? '2 days')."\n";
            $out .= "- group_size: \n- age_range: \n";
            $out .= '- base_price: '.($r['base_price'] ?? '')."\n";
            $out .= "- languages: English, French\n";
            $out .= "- included:\n    - Transport\n- excluded:\n    - Lunches\n";
            $out .= "- itinerary:\n    - Day 1: Go → See Aït Benhaddou\n    - Day 2: Return\n";
            $out .= '- bestseller: '.($r['bestseller'] ?? 'false')."\n";
            $out .= '- free_cancellation: '.($r['free_cancellation'] ?? 'true')."\n";
            $out .= "- map_frame: |\n    <iframe src=\"https://maps.example/embed?pb=1\" width=\"100%\"></iframe>\n";

            if (isset($r['images'])) {
                $c = $r['images']['cover'];
                $g = $r['images']['gallery'];
                $out .= "- images:\n";
                foreach (['cover' => $c, 'gallery' => $g] as $role => $img) {
                    $pad = $role === 'cover' ? '      ' : '        ';
                    $lead = $role === 'cover' ? "    cover:\n      " : "    gallery:\n      - ";
                    $out .= $lead.'path: "'.$img['path']."\"\n";
                    $out .= $pad.'filename: "'.basename($img['path'])."\"\n";
                    $out .= $pad.'alt: "'.($img['alt'] ?? "Sample {$role} alt")."\"\n";
                    $out .= $pad.'title: "Sample '.$role." Title\"\n";
                    $out .= $pad."caption: \"A caption.\"\n";
                    $out .= $pad."description: \"A description.\"\n";
                    $out .= $pad."width: 16\n{$pad}height: 16\n";
                    $out .= $pad.'size_bytes: '.$img['size']."\n";
                    $out .= $pad.'sha256: "'.$img['sha256']."\"\n";
                    $out .= $pad."source_warning: null\n{$pad}replacement_recommended: false\n";
                }
                $out .= "- image_match:\n";
                $out .= '    status: "'.($r['match_status'] ?? 'normalized-exact')."\"\n";
                $out .= '    confidence: '.($r['confidence'] ?? '0.95')."\n";
                $out .= "    image_category: \"Cat\"\n    image_program_folder: \"Prog\"\n";
                $out .= "    evidence:\n      - \"Duration matches\"\n";
                $out .= "    review_notes: null\n";
            } else {
                $out .= "- images: null\n";
                $out .= "- image_match:\n    status: \"unmatched-record\"\n    confidence: 0\n";
                $out .= "    image_category: null\n    image_program_folder: null\n";
                $out .= "    evidence: []\n    review_notes: \"No confidently matching image folder was found.\"\n";
            }
        }

        $path = $this->sandbox.'/fixture.md';
        File::put($path, $out);

        return $path;
    }

    /**
     * Parse a fixture and run the importer over it.
     */
    protected function runImport(string $fixturePath, array $options = []): ProgramImportReporter
    {
        $options += [
            'dry_run' => false,
            'sections' => [],
            'slug' => null,
            'only_new' => false,
            'only_missing_media' => false,
            'replace_seed_media' => false,
            'update_content' => false,
            'limit' => null,
        ];
        $records = (new ToursDataParser)->parse($fixturePath);
        $reporter = new ProgramImportReporter('test-'.uniqid());
        $importer = new ProgramImporter(new ProgramMediaImporter($this->publicBase), $reporter);
        $importer->run($records, $options);

        return $reporter;
    }

    /** A standard matched tour definition for fixtures. */
    protected function matchedTour(string $title = 'Test Tour to Merzouga', int $seed = 1): array
    {
        $slug = \Illuminate\Support\Str::slug($title);

        return [
            'section' => 'tour',
            'type' => 'multi_day',
            'title' => $title,
            'category' => 'Tours from Marrakech',
            'location' => 'Marrakech, Morocco',
            'images' => [
                'cover' => $this->makeWebp("assets/images/programs/Cat/Prog{$seed}/{$slug}-dunes-cover.webp", $seed),
                'gallery' => $this->makeWebp("assets/images/programs/Cat/Prog{$seed}/{$slug}-camp-gallery.webp", $seed + 100),
            ],
        ];
    }
}

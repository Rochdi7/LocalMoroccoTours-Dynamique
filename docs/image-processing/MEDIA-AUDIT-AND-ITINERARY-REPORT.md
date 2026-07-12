# Media Audit + Itinerary Descriptions — Phase Report

Date: 2026-07-12 · Branch: `feat/program-data-importer` · Architecture unchanged: thin seeders → `programs:import` → tours-data.md (single source of truth)

## 1. Full media audit (all 77 programs)

| Metric | Count |
|---|---|
| Total programs / tours / activities / trekking | 77 / 62 / 12 / 3 |
| Programs with valid cover + gallery media | **61** (46 tours + 12 activities + 3 trekking) |
| Media rows after apply | **122** (61 covers + 61 galleries), 0 duplicates, 0 hash failures, 0 missing conversions |
| Existing media preserved | 98/98 (all skipped as identical seed on re-run) |
| New media attached this phase | **24** (12 activity covers + 12 activity galleries) |
| Programs with no prepared source image | **16** (13 day trips, 2 combined tours, 1 Spain & Morocco tour) |
| Ambiguous matches requiring manual selection | 0 |

**Why 28 were "no-source-media" before:** the `Marrakech Activities` folder (12 programs × 2 WebP) was added to `public/assets/images/programs/` *after* the original matching phase — never overlooked logic, simply new files. All 24 images were visually inspected, matched 1:1 to the 12 activities (2 exact-title matches, rest normalized/high-confidence, none ambiguous), given program-specific alt/title/caption/description, and embedded into tours-data.md with SHA-256 checksums. Flags preserved internally: 16 low-resolution files, 1 watermarked quad-biking cover (`replacement_recommended: true`), 3 filename-vs-content notes (Menara→Majorelle, buggy→quad, sunset-lanterns→daytime terrace).

**The remaining 16:** no prepared image exists anywhere under `public/assets/images/programs/`. Candidate photos DO exist in the legacy project (`Desktop/Projects/localmoroccotours html/public_html/assets/images/lmt/` — e.g. `essaouira-day-trip-from-marrakech.webp`, `4-day-atlas-zagora-combined-tour-primary.webp`, `15-day-spain-morocco-private-tour-primary.webp`), but they are unprepared (no SEO renaming/optimization/visual review; several day trips have only one photo, which cannot satisfy the cover+gallery convention). They are listed per-program in `program-media-audit-full.csv` (columns include matched folder/file, reason, confidence, media counts, action) for a future preparation phase — nothing was attached blindly.

## 2. Itinerary day descriptions (the missing-description fix)

Root cause: the original tours-data.md extraction captured only day **titles**; the legacy pages have title + paragraph per day.

- Extracted **254 day descriptions** from 65 legacy pages (all 62 tours + 3 trekking; the 12 activities have no legacy itinerary pages).
- Matching evidence: per-day title alignment (Jaccard) **plus** program-title similarity, equal day-count required, unique page per program; 0 ambiguous (an early weaker scorer mis-paired one tour — caught by the alignment check and replaced before any write).
- Added additive `- itinerary_details:` blocks to tours-data.md (backup: `tours-data.backup-before-itinerary-details-20260712-125915.md`); day titles inside `- itinerary:` untouched.
- Brand safety: 107 occurrences of the old "Local Morocco Tours" name in the extracted text (and 9 pre-existing in the file) were replaced with "Authentic Morocco Adventures" per CLAUDE.md brand rules. **Note:** database overview fields seeded earlier still contain up to 9 old-brand mentions; fixing them requires an approved `--update-content` run.
- Importer merge (`ProgramImporter::mergeItineraryDescriptions`): descriptions are only **added** where missing; existing day titles preserved verbatim; existing non-empty descriptions never replaced; day-count mismatch → warning, no write.
- DB result: 65 programs now store `[{title, content}]` itinerary entries; 12 activities remain title-only strings.
- Frontend: `tours-details.blade.php` already rendered `title`/`content` day objects; the same array-aware pattern was added to `activities-details` and `trekking-details` (theme markup `roadmap__title`/`roadmap__content` reused; header partials untouched).

## 3. Verification

- Tests: **37/37 passing (1,527 assertions)** — includes new tests for activity image discovery via the wrapper seeder, duplicate prevention, additive description merge, title preservation, existing-description protection, day-count-mismatch rejection, no-brand-leak parsing.
- Idempotency: final dry-run = 77 skipped, 0 updates, 122 media-skipped, 0 conflicts, 0 failures.
- Content protection verified: prices still 0/untouched, booked counts 0, reviews 0, overviews byte-identical, categories/locations unchanged, all media custom properties intact.
- Apply run ids: `apply-activity-media`, `apply-itinerary-details` (reports + rollback manifests under `storage/app/program-import/reports/`).

## Commands (unchanged workflow)

```powershell
php artisan db:seed --class=ProgramSeeder     # or TourSeeder / ActivitySeeder / TrekkingSeeder
php artisan programs:import --dry-run
php artisan programs:import --apply [--section=tour|activity|trekking]
php artisan programs:import-rollback {run-id} [--apply]
```

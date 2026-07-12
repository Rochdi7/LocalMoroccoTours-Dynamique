# Database & Import Schema Audit — Program Importer

Date: 2026-07-12 · Laravel 11.36.1 · PHP 8.2.12 · spatie/laravel-medialibrary 11.13.0 · MySQL (local)

## Where programs are stored

| Section (source) | Model | Table | Category model | Notes |
|---|---|---|---|---|
| tour (62) | `App\Models\Tour` | `tours` | `TourCategory` (`tour_categories`) | has `type` enum('day_trip','multi_day') default 'multi_day' |
| activity (12) | `App\Models\Activity` | `activities` | `ActivityCategory` (`activity_categories`) | no `type` column |
| trekking (3) | `App\Models\Trekking` | `trekking` | `TrekkingCategory` (`trekking_categories`) | extra: `difficulty_level` enum('Easy','Moderate','Hard','Expert') NOT NULL, `max_altitude` nullable |

Trekking is a **separate model/table**, not a Tour type. Categories are **separate per type**. `locations` is **shared** by all three (FK `location_id`; NOT NULL on tours, nullable on activities/trekking).

## Column findings (all three program tables unless noted)

- `slug` — string, **unique index** on every table → reliable upsert key. Verified: all 77 source `Str::slug(title)` values match existing rows 1:1; no duplicate slugs.
- `overview` — text NOT NULL. `highlights` — **text nullable** (NOT JSON).
  - `Tour` has **no cast** for highlights: stored as a JSON-encoded string (existing convention from `TourDataSeeder::basePayload`), read via `getHighlightsArrayAttribute()`.
  - `Activity`/`Trekking` **cast highlights to array** — pass raw arrays.
- `included` / `excluded` / `itinerary` — **JSON nullable**, array-cast on all models.
- `languages` — **varchar(255)**, array-cast on all models (JSON string within varchar; existing rows use `["English","French","Spanish"]`).
- `base_price` — decimal(10,2) **NOT NULL** (source values are blank → existing convention stores 0; importer never updates it).
- `age_range` — string **NOT NULL** (source blank → stored as `''` per existing convention).
- `group_size` — string nullable. `duration` — string NOT NULL.
- `map_frame` — **longText nullable** → full iframe HTML fits.
- `bestseller_flag` / `free_cancellation_flag` — boolean, default false.
- `booked_count` int default 0, `rating` decimal default 5.0, `reviews_count` int default 0 — **never written by the importer**.
- FKs: `category_id` → per-type category table (cascade), `location_id` → locations (cascade). Timestamps yes; **no soft deletes** anywhere.

## Media

- Default Spatie `media` table (migration `2025_06_27_212349`); **no config/media-library.php** (package defaults), models pin `useDisk('public')`.
- Collections: Tour/Activity → `cover` (**singleFile**) + `gallery`; Trekking registers only `gallery`, **but** `Admin\TrekkingController` and the frontend (`index.blade.php` line 775) already use a `cover` collection on Trekking — attaching to the unregistered `cover` collection is the established project convention (works; just not singleFile — the importer enforces single-cover semantics itself).
- Conversions on all three: `thumb` (150×150), `slider` (1200×800), nonQueued (generated at attach time; GD with WebP support confirmed).
- Custom-property conventions already used by Blade views: **`alt`, `title`, `caption`, `description`** — the importer writes exactly these, plus internal keys (`source_path`, `source_sha256`, `seed_key`, `managed_by`, `replacement_recommended`, `source_warning`, `image_match_confidence`).
- `storage:link` exists. ⚠️ `storage/app/public/` contains orphaned numbered folders (1–38) from a previous media wipe (media table is empty). New media IDs may reuse those numbers; harmless (different filenames) but worth a cleanup someday.

## Current data state (see current-database-import-audit.csv)

- tours 62 / activities 12 / trekking 3 — **all 77 source records already exist by slug** (seeded earlier from the same file by `ToursSeeder`/`ActivitiesSeeder`/`TrekkingSeeder`).
- 0 media rows, 0 reviews, all `base_price` = 0, all `booked_count` = 0, no duplicate slugs, no orphaned media rows.
- Consequently the importer's real job on this database: **skip/fill records, attach 49 covers + 49 galleries**.

## Mismatches / cautions

1. `tests/phpunit.xml` points tests at the dev MySQL DB — the new importer tests therefore switch themselves to sqlite `:memory:` + a sandboxed public disk in `setUp()` (phpunit.xml untouched).
2. `Trekking` lacks a registered `cover` collection (see above) — deliberate reuse of the existing convention rather than a model change.
3. Source blanks (`base_price`, `age_range`, `group_size`) map to `0` / `''` / `null` respectively — matching the conventions already in `TourDataSeeder::basePayload()`.
4. `difficulty_level` is required by the schema but absent from tours-data.md; existing rows hold manually-set values (e.g. Hard/4167m) — the importer never touches them; for hypothetical new trekking rows it defaults to 'Moderate' like `TrekkingSeeder`.

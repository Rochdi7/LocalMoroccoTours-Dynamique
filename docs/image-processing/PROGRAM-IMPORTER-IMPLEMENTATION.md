# Program Importer — Implementation Guide

Date: 2026-07-12 · Branch: `feat/program-data-importer`

## Architecture

```
app/Console/Commands/
  ImportProgramsCommand.php        php artisan programs:import   (dry-run by default)
  RollbackProgramImportCommand.php php artisan programs:import-rollback {run-id}
app/Services/ProgramImport/
  ToursDataParser.php              parses tours-data.md incl. images/image_match blocks; validates structure, paths, SHA-256
  ProgramImporter.php              record upsert + media orchestration, per-record transactions
  ProgramMediaImporter.php         Spatie attachment with duplicate prevention & manual-media preservation
  ProgramImportReporter.php        collects results; writes JSON (= rollback manifest) + CSV reports
  ProgramImportRollbackService.php reverses one run using its JSON manifest
app/Data/ProgramImport/
  ProgramData.php, ProgramImageData.php   typed DTOs
tests/Feature/ProgramImport/       27 tests (parser / importer / media / rollback) on sqlite :memory: + sandboxed disk
```

No migrations were added: the rollback manifest lives in the run's JSON report under
`storage/app/program-import/reports/run-{run-id}.json`, so no schema change is needed.

## Commands

```powershell
# Safe preview (default; identical to --dry-run):
php artisan programs:import

# Apply for real (asks for confirmation; NOT executed yet — awaiting approval):
php artisan programs:import --apply

# Useful variants:
php artisan programs:import --section=tour --slug=2-days-fes-to-chefchaouen
php artisan programs:import --apply --only-missing-media   # media only where collections are empty
php artisan programs:import --apply --replace-seed-media   # replace importer-managed media only
php artisan programs:import --apply --update-content       # allow source to replace non-empty content fields

# Rollback one run (dry-run by default):
php artisan programs:import-rollback {run-id}
php artisan programs:import-rollback {run-id} --apply
```

## Overwrite policy (defaults)

- Records found by unique `slug` → **fill only empty columns**; never touch `base_price`,
  `booked_count`, `rating`, `reviews_count`, flags, relations, or media.
- Slug miss + normalized-title hit → reported as **conflict**, never auto-merged.
- Empty/blank source values are **never** written over non-empty DB values (even with `--update-content`).
- `--update-content` may replace content fields (overview, highlights, duration, itinerary, included,
  excluded, languages, map_frame, type) with non-empty source values; price/bookings/reviews stay protected.

## Media policy

- Attach only when `image_match.confidence >= 0.80` and the source file passes: inside `public/`,
  readable, WebP magic bytes, SHA-256 equals the value embedded in tours-data.md.
- `preservingOriginal()` — sources under `public/assets/images/programs/` are never moved; Spatie keeps
  its own managed copy on the `public` disk (default path generator), conversions `thumb` + `slider` run at attach.
- Custom properties: `alt`, `title`, `caption`, `description` (used by existing Blade views) +
  `source_path`, `source_sha256`, `seed_key`, `managed_by=programs-import`, `replacement_recommended`,
  `source_warning`, `image_match_confidence`.
- Duplicate prevention: seed key `programs-import:{section}:{slug}:{collection}:{sha256}` and
  per-collection checksum check → reruns skip. The intentional Hassan II duplicate attaches separately
  to its two programs (dedupe is per-model per-collection only).
- singleFile cover safety: attach only into an **empty** cover collection; identical seed → skip;
  different seed-managed cover → conflict unless `--replace-seed-media`; manual upload → always preserved
  (even with the replace flag). `clearMediaCollection` is never used.
- Unmatched records (28) → `no-source-media`; nothing attached; not an error.

## Dry-run vs apply

- Dry-run: zero DB writes, zero media, zero category/location creation; reports what would happen
  (verified by tests and by MySQL row counts before/after).
- Apply: per-record DB transaction; media attached after the record save; a media failure keeps the
  record, is reported, and never touches unrelated media.

## Rollback behaviour

Uses the run's JSON manifest. Deletes only: media attached by that run (verified `managed_by`),
records created by that run **if** unmodified since (updated_at == created_at), review-free, and free of
manual media; categories/locations created by that run only when no record references them.
Everything else is refused with a reason. Dry-run prints the full action table first.

## Known limitations

- Only the first gallery item per record is imported (the current dataset has exactly one).
- `difficulty_level` defaults to 'Moderate' for hypothetical new trekking records (not in source).
- Warning custom-properties (watermarks, low-res, promo collage, Ait Benhaddou/Tetouan cover notes)
  travel with the media; they are internal-only — Blade never renders them.
- The report JSON is the rollback manifest; deleting `storage/app/program-import/reports/` forfeits rollback.

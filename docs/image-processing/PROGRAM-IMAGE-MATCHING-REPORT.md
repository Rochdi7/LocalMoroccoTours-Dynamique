# Program Image Matching Report — Authentic Morocco Adventures

Date: 2026-07-11

## Data records
1. Total data records: **77**
2. Tour records: **62**
3. Activity records: **12**
4. Trekking records: **3**
5. Image program folders: **49** (8 categories, 2 WebP each)

## Match outcome
6. Exact matches: **0** (no title matched character-for-character; naming styles differ)
7. Normalized-exact matches: **36** (0.90–0.98 — same duration, origin, destination, category after normalization)
8. High-confidence matches: **13** (0.82–0.89 — all manually reviewed against overview and itinerary; route direction and return-vs-one-way verified)
9. Medium-confidence matches: **0**
10. Ambiguous records: **0**
11. Unmatched data records: **28** — the 13 day trips (Marrakech/Fes/Casablanca), 12 activities, 2 combined tours, and the 15-day Spain & Morocco tour have no image sets. All are marked `images: null` / `status: "unmatched-record"`.
12. Unmatched image folders: **0** — every one of the 49 folders was assigned to exactly one record.

## Records updated
13. Records updated with a cover + gallery block: **49**
14. Records left without images (explicitly marked): **28**

## Assigned-image warnings (preserved in `source_warning`, never in public alt/captions)
15. Watermarked images assigned: **3** (Chefchaouen night panorama — Paul Reiffer; Chefchaouen red-dress — Klook; camel-caravan with photographer credit) — all `replacement_recommended: true`
16. Low-resolution images assigned: **27 records carry at least one** sub-800px image (flagged, not upscaled)
17. Promotional images assigned: **1** (12-day Tangier AMA brand collage gallery image, `replacement_recommended: true`)
18. Duplicate-source images assigned: **2** (the same Hassan II Mosque photo intentionally used by the 11-day Casablanca grand tour and the 2-day Marrakech→Casablanca & Rabat tour)

## Reviewer notes on specific matches
- **2-Day Marrakech to Agadir & Essaouira** (0.82): the image folder and its cover reference Ait Benhaddou, which is not on this Atlantic itinerary. Match is correct (only remaining 2-day coastal program), but the cover is flagged `replacement_recommended: true`.
- **3-Day Tangier to Chefchaouen & Fes** (0.82): cover shows Tetouan, which is in the same northern loop region but not explicitly in the itinerary — noted in `review_notes`.
- All Fes one-way vs return variants, the Ouarzazate return tour, and the Tangier "desert" tours were disambiguated by reading itineraries, not just titles.

## Integrity
19. Missing image paths: **0** (all 98 assigned paths exist on disk)
20. Hash mismatches: **0** (every embedded SHA-256 matches the file on disk)
21. Validation failures: **0** — the file was re-parsed after editing: 77 records, all titles, categories, durations, overviews, itineraries, map iframes, included/excluded lists and booleans byte-identical; diff vs backup contains **only added lines** (2,056 insertions, 0 deletions); LF line endings and UTF-8 preserved; no absolute Windows paths; no `public/` prefixes (paths use `assets/images/programs/...` per the theme's `asset()` convention).

## Files
22. Backup: `tours-data.backup-before-image-matching.md`
23. tours-data.md SHA-256 before: `bffd6ca43af8bb08ec6ff6ea385d1d98b9529bac5e475a61f0d49835d2fe1dd4`
24. tours-data.md SHA-256 after: `2e39a5f82ea49b5bc13afaca2b907ff04dd2d9eec24980ab4e6fc259c27d3989`
25. Non-image program content is confirmed unchanged (field-by-field re-parse comparison + additive-only diff). No Laravel code, models, seeders, Blade files, or database records were touched; no image file was modified.

Reports: `tours-data-parse-audit.csv`, `program-image-folder-inventory.csv`, `program-image-matching-plan.csv`, `program-image-matching-results.csv`. Rollback: `rollback-tours-data-image-matching.ps1`.

# Internal Linking — Verified Against Live Routes & Database

All links below were checked against `routes/web.php` and the live `tours`, `activities`, `trekking`, `tour_categories`, and `locations` tables on **2026-07-16**. Every URL in `01-article.md` corresponds to a real, existing page — none are placeholders. If any of these slugs are renamed or the tour/activity is deleted later, search-and-replace the anchor's target in the article.

Route naming reference (for the developer wiring this into Blade, or for confirming in `php artisan route:list`):
- Tours: `front.tours.show` → `/tours/{slug}`, `front.tours.index` → `/tours` (supports `?tour_category_slug=` filter)
- Activities: `front.activities.show` → `/activities/{slug}`
- Trekking: `front.trekking.show` → `/trekking/{slug}`
- Contact: `front.contact` → `/contact`

## Links used in the article

| Anchor Text (as used in article) | URL | Type | Verified Against |
|---|---|---|---|
| Marrakech food tour through the Medina's street food scene | `/activities/marrakech-food-tour-medina-street-food` | Activity | `activities` table slug |
| hammam and Moroccan massage | `/activities/marrakech-hammam-moroccan-massage` | Activity | `activities` table slug |
| Agafay Desert (Marrakech section, luxury camp) | `/activities/agafay-desert-tour-from-marrakech-luxury-camp` | Activity | `activities` table slug |
| tours departing from Marrakech | `/tours?tour_category_slug=tours-from-marrakech` | Tour listing (filtered) | `tour_categories` slug + confirmed filter param in `FrontTourController::index` |
| 2-day Merzouga desert tour | `/tours/merzouga-desert-tour-from-marrakech-2-days` | Tour | `tours` table slug |
| 3-day Marrakech desert tour to the Merzouga dunes | `/tours/marrakech-desert-tour-3-days-to-merzouga-dunes` | Tour | `tours` table slug |
| 4-day desert tour from Marrakech to Merzouga | `/tours/4-day-desert-tour-from-marrakech-to-merzouga` | Tour | `tours` table slug |
| Ourika Valley day trip from Marrakech | `/tours/marrakech-to-ourika-valley-day-trip` | Tour | `tours` table slug |
| 2-day Toubkal trekking route | `/trekking/2-days-toubkal-trekking` | Trekking | `trekking` table slug |
| 3-day Berber villages trek | `/trekking/3-days-berber-villages-trek` | Trekking | `trekking` table slug |
| 3-day Toubkal summit trek | `/trekking/3-days-toubkal-summit-trek` | Trekking | `trekking` table slug |
| Marrakech to Essaouira day trip | `/tours/marrakech-to-essaouira-day-trip` | Tour | `tours` table slug |
| 2-day Marrakech desert tour to Essaouira | `/tours/2-day-marrakech-desert-tour-to-essaouira` | Tour | `tours` table slug |
| 2-day Ouarzazate to Merzouga route | `/tours/2-days-ouarzazate-to-merzouga` | Tour | `tours` table slug |
| Marrakech to Aït Benhaddou day trip | `/tours/marrakech-to-ait-benhaddou-day-trip` | Tour | `tours` table slug |
| tours departing from Ouarzazate | `/tours?tour_category_slug=tours-from-ouarzazate` | Tour listing (filtered) | `tour_categories` slug |
| 3-day Sahara Desert tour from Marrakech to Chigaga | `/tours/sahara-desert-tour-from-marrakech-3-days-to-chigaga` | Tour | `tours` table slug |
| guided Medina tour in Fes | `/tours/guided-medina-tour-in-fes` | Tour | `tours` table slug |
| 3-day Fes to Merzouga desert tour | `/tours/3-days-fes-to-merzouga-desert` | Tour | `tours` table slug |
| tours departing from Fes | `/tours?tour_category_slug=tours-from-fes` | Tour listing (filtered) | `tour_categories` slug |
| 2-day Fes to Chefchaouen route | `/tours/2-days-fes-to-chefchaouen` | Tour | `tours` table slug |
| Fes to Chefchaouen day trip | `/tours/fes-to-chefchaouen-day-trip` | Tour | `tours` table slug |
| Marrakech hot air balloon flight | `/activities/marrakech-hot-air-balloon` | Activity | `activities` table slug |
| Agafay Desert luxury camp experience | `/activities/agafay-desert-tour-from-marrakech-luxury-camp` | Activity | `activities` table slug |
| Agafay Desert tour from Marrakech | `/tours/agafay-desert-tour-from-marrakech` | Tour | `tours` table slug |
| Casablanca to Rabat day trip | `/tours/casablanca-to-rabat-day-trip` | Tour | `tours` table slug |
| Casablanca to Marrakech day trip | `/tours/casablanca-to-marrakech-day-trip` | Tour | `tours` table slug |
| tours departing from Casablanca | `/tours?tour_category_slug=tours-from-casablanca` | Tour listing (filtered) | `tour_categories` slug |
| 7 Days Sahara & Imperial Cities | `/tours/7-days-sahara-imperial-cities` | Tour | `tours` table slug |
| 5-day Toubkal & Merzouga tour | `/tours/5-days-toubkal-merzouga-tour` | Tour | `tours` table slug |
| 14 Days Grand Morocco Tour | `/tours/14-days-grand-morocco-tour` | Tour | `tours` table slug |
| Get in touch to plan a personalized route | `/contact` | Static page | `routes/web.php` — `front.contact` |

## Gaps found (things the article asked for that don't exist yet)

These were requested in the original brief but **do not currently exist** as dedicated pages, so the article does not link to them as invented URLs. Options are noted for each.

| Requested link | Status | Recommendation |
|---|---|---|
| A dedicated "Morocco 10-day itinerary" tour package | No exact 10-day tour in the `tours` table | Either create one in admin, or keep the article's itinerary section text-only (current approach) |
| A dedicated "Aït Benhaddou day trip" as its own standalone activity (not tour) | Exists only as a **tour**, not an activity | Used the existing tour: `marrakech-to-ait-benhaddou-day-trip` |
| Taghazout as a destination/activity page | No Taghazout tour, activity, or location record exists | Removed from the destination list and replaced with **Casablanca & Rabat**, which does have real, linkable tours |
| A location page for Merzouga, Essaouira, Ouarzazate (beyond Ouarzazate city), Chefchaouen sub-areas | Only `locations` table entries: marrakech-morocco, fes-morocco, tangier-morocco, agadir-morocco, chefchaouen-morocco, ouarzazate-morocco, casablanca-morocco, morocco | Article links to **tours/activities** in these areas instead of `/locations/{slug}` pages, since most requested destinations don't have their own location record |
| Marrakech city tour (as a distinct product) | No activity/tour titled exactly "Marrakech city tour" — closest is `marrakech-medina-tour-half-day` | Consider linking `/activities/marrakech-medina-tour-half-day` if you want a "city tour" anchor — not currently used in the article to avoid mismatched anchor text |

## If you want to strengthen this further

1. **Add a 10-day and a genuinely mid-range Casablanca/coastal-combo tour** in the admin Tours screen if none exists close to what's described in the 10-day itinerary — right now that itinerary is realistic but doesn't map to one single bookable product.
2. **Add `location_slug` links** once/if you create Location pages for Merzouga, Essaouira, and Chefchaouen specifically (currently only the city-level `chefchaouen-morocco` exists) — this would let you link `/locations/merzouga-morocco` etc. directly from the destination sections instead of only linking to individual tours.
3. Re-run the slug check before publishing if any tours/activities have been added, renamed, or removed since 2026-07-16 — a quick way is `php artisan tinker` and re-pulling `Tour::pluck('title','slug')` etc. (same command used to build this table).

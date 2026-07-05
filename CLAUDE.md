# CLAUDE.md — Authentic Morocco Adventures

Guidance for Claude / developers working in this repo. Read this first; it lets you
make changes without re-scanning the whole project every time.

> Brand: **Authentic Morocco Adventures** — domain **authenticmoroccoadventures.com**.
> This is an independent tourism brand. Do NOT introduce any other brand name into
> visible content, meta, schema, emails, or social links.

---

## 1. Project architecture

Laravel app (MVC + Blade) for a Morocco tour operator. Two distinct UI areas:

- **Frontend (public site)** — marketing + booking. Lives in `resources/views/front/`.
- **Admin dashboard** — content management (tours, activities, trekking, blog,
  locations, reviews). Lives in `resources/views/admin/` + `resources/views/layouts/`
  (this is a separate bought admin theme; not customer-facing).

Stack: Laravel, Blade, jQuery + GSAP/ScrollMagic/Swiper (theme vendors),
spatie/medialibrary for images, SCSS compiled to `public/assets/css/`.

Routes: `routes/web.php`. Frontend route name prefixes: `front.tours.*`,
`front.activities.*`, `front.trekking.*`, `front.locations.*`, `blog.*`, plus
`home`, `front.about`, `front.contact`, `front.terms`, `front.help-center`,
`newsletter.subscribe`, `contact.send`. Admin under `/admin` (`admin.*`, auth-gated).

---

## 2. Main folders / files

```
app/Http/Controllers/        HomeController, FrontTourController, FrontActivityController,
                             FrontTrekkingController, FrontLocationController, PostController,
                             ContactController, NewsletterController, *ReservationController
app/Models/                  Tour, Activity, Trekking, Location, Post, User, Review, ...
resources/views/front/       Frontend Blade (see below)
resources/views/emails/      Transactional emails (contact, newsletter, reservations)
resources/views/errors/404   Custom 404
public/assets/css/           Compiled CSS  (main.css / main.min.css, vendors.*)
public/assets/sass/          SCSS source (compile to the above)
public/assets/js/            Site JS (main.js/min, vendors, favorites.js, homepage)
public/sitemap.xml, robots.txt
```

### Frontend Blade map (`resources/views/front/`)

- `layouts/app.blade.php` — **primary** layout. Hard-coded homepage SEO block +
  generic fallback title. Includes `_header`, `_footer`, `_wishlist`.
- `layouts/app2.blade.php` — secondary layout using `@yield` SEO sections
  (`title`, `meta_description`, `og_*`, `twitter_*`). Includes `_header2`,
  `_footer2`, `_wishlist`.
- `partials/_header.blade.php`, `_footer.blade.php` — used by `app`.
- `partials/_header2.blade.php`, `_footer2.blade.php` — used by `app2`.
- `partials/_wishlist.blade.php` — floating wishlist button + slide-in panel (added).
- `index.blade.php` — homepage (uses `app`). Tour/Activity/Trek cards.
- `about/contact/terms/help-center.blade.php` — static pages.
- `tours/`, `activities/`, `trekking/` — `*-list.blade.php` (listing) +
  `*-details.blade.php` (single).
- `locations/` — `index` + `show`.
- `blog/` — `post.blade.php` (list) + `post-details.blade.php`.

---

## 3. How pages are built

- Each page `@extends('front.layouts.app')` or `...app2` and fills `@section('content')`.
- `app2` pages set SEO via `@section('title')`, `@section('meta_description')`,
  `@section('og_*')`, etc. `app` pages get SEO from the hard-coded head block.
- Listing pages loop a paginated collection (`$tours`, `$activities`, `$treks`) and
  render a `.tourCard`. Cover image comes from medialibrary:
  `$model->getFirstMedia('cover')` with custom props `alt/title/caption/description`.
- Card link to detail: `route('front.<type>.show', $model->slug)`.

---

## 4. Theme / design rules

- **Do not change the theme design, colors, spacing, cards, animations, or
  responsive behavior.** This is a purchased theme; only edit content + the
  documented feature additions.
- Brand colors (`public/assets/sass/abstracts/_variables.scss`):
    - `accent-1: #ffc421` (yellow — primary CTAs, "New" labels)
    - `accent-2: #044cb8` (blue — footer bg, wishlist button)
- Utility classes are theme-provided (`text-14`, `mt-5`, `x-gap-5`, `d-flex`,
  `tourCard__*`, `button -outline-accent-1`, etc.). Reuse them; don't invent new ones.
- CSS is compiled. Editing `public/assets/css/main.min.css` directly is the quick
  path; the SCSS source in `public/assets/sass/` is the proper path (needs a build).
  Small page-specific tweaks are done with inline `<style>` blocks in partials
  (existing pattern — e.g. `_wishlist`, WhatsApp float).

---

## 5. JS behavior

- `public/assets/js/main.js` / `main.min.js` — theme bootstrap. `initialReveal()`
  now just calls `RevealAnim.init()` + `initComponents()` directly (the preloader was
  fully removed — see §10).
- `public/assets/js/favorites.js` — **wishlist system** (rewritten, see §7).
- Scripts load `defer` at end of `<body>`; jQuery from CDN. Layouts log
  `typeof jQuery` for debugging.

---

## 6. Content conventions

- Visible brand name is always **Authentic Morocco Adventures**.
- Contact email: `authenticmoroccoadventures@gmail.com` (display).
  Phone/WhatsApp: `+212 666 107 312`.
- Social handles: `AuthenticMoroccoAdventures` (FB/IG/Pinterest/LinkedIn),
  X handle `AuthMoroccoAdv`.
- Card empty-state rules:
    - Location row is **hidden** when `$model->location?->name` is empty
      (no "Unknown Location"). Activity/Trek lists may use a clean `'Marrakech'` fallback.
    - When `reviews_count == 0`, show **"New tour / New activity / New trek"** instead of
      a `0.0 (0)` rating.
    - "Popular" badge renders only when `$model->bestseller_flag` is true (in `index`).

---

## 7. Wishlist / favorites (localStorage)

Implemented in `public/assets/js/favorites.js` (loaded by both `app` and `app2`).

- Storage key: `amaWishlist` in **localStorage**. Value: JSON array of
  `{ id, type, title, image, url }`.
- Heart buttons use `class="js-favorite-btn" data-id data-type` (type =
  `tour|activity|trekking|location`). On click it toggles save/remove and adds/removes
  the `.is-favorited` class (red heart).
- Item metadata (title/image/url) is **read from the DOM at click time** by walking up
  to the nearest card (`.tourCard` etc.) — so individual cards do NOT need extra data
  attributes. Detail pages fall back to `<h1>`, `og:image`, and current URL. You can
  override by adding `data-title` / `data-image` / `data-url` to a button.
- Floating button (`.js-wishlist-toggle`) sits **above** the WhatsApp float; shows a
  live count badge (`.js-wishlist-count`). Clicking opens the slide-in panel
  (`.js-wishlist-panel`) listing saved items with remove buttons. No server route —
  fully client-side. Responsive (smaller on ≤767px).
- The old cookie-based favorites + per-type `favorites-*.min.js` files are no longer
  loaded.

---

## 8. SEO / meta structure

- `app.blade.php`: hard-coded homepage `<title>`, description, canonical, keywords,
  OG, Twitter, and JSON-LD (`@type: TourGuide`). Non-home pages get a fallback title.
- `app2.blade.php`: all SEO via `@yield(...)` with brand defaults; JSON-LD TourGuide.
- `index.blade.php` also has a page-level JSON-LD (`ImageObject`/brand).
- Canonical/OG URLs use `https://www.authenticmoroccoadventures.com/`.
- `public/sitemap.xml` + `robots.txt` reference the same domain. Keep SEO pages
  (about, contact, terms, privacy, help-center) — do not delete.

---

## 9. Safe update rules

- Edit **content only** unless a task explicitly asks for behavior. Keep theme markup,
  classes, and animations intact.
- Don't rename asset files (logos, images) — change `alt`/visible text instead.
  Known asset still named with old brand: `public/assets/images/logo/LocalMoroccoTours_bg.png`
  (referenced in `_header2` + `auth/login`). Replace the _image content_, keep the path,
  or rename the file AND update both references together.
- Don't change route URLs or names; many views build links via `route(...)`.
- After Blade edits run `php artisan view:clear`.
- Don't add packages for small features (the wishlist is dependency-free).
- The receiving inbox `localmoroccotour1@gmail.com` in
  `*ReservationController` / `ContactController` and `localmoroccotour@gmail.com` in the
  `/test-mail` route are **backend recipients** (not user-visible). Change only when the
  business provides the new inbox, and update all controllers together.

---

## 10. Future update notes / TODO

- [ ] Replace logo graphic(s) so the image itself reads "Authentic Morocco Adventures"
      (files: `logo_white.png`, `LocalMoroccoTours_bg.png`). Then optionally rename the
      `LocalMoroccoTours_bg.png` file + update `_header2.blade.php` and `auth/login.blade.php`.
- [ ] Update backend notification inboxes once the new brand email is provisioned.
- [ ] Confirm the new social media handles exist (FB/IG/X/LinkedIn/Pinterest) or update URLs.
- [x] Preloader fully removed: HTML (both layouts), JS logic (`initialReveal` in
      `main.js`/`main.min.js`), CSS rules (`main.css`/`main.min.css`), SCSS partial
      (`_preloader.scss` deleted + import removed from `main.scss`). Swiper's own
      `swiper-lazy-preloader` vendor classes are unrelated and intentionally kept.
- [ ] Tripadvisor links now point to the Marrakech activities listing (generic). Swap to
      the brand's own Tripadvisor page when available.

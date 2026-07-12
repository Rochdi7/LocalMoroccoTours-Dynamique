# Security Audit — Before Remediation

**Project:** Authentic Morocco Adventures (Laravel 11.36.1, PHP 8.2, spatie/laravel-medialibrary 11, spatie/laravel-permission 6)
**Branch:** `security/hardening-and-upload-protection` (based on `feat/program-data-importer` @ `98cc596`)
**Date:** 2026-07-12
**Scope:** Full application — routes, controllers, forms, uploads, auth, config, dependencies.

Severity scale: **Critical** (unauthenticated RCE/full compromise) · **High** (auth bypass, stored XSS, arbitrary file upload) · **Medium** (requires specific conditions) · **Low** (defense-in-depth).

---

## 1. Critical

### 1.1 Admin panel has no role/permission check — any authenticated user reaches full admin CRUD + raw upload endpoint
- **Severity:** Critical
- **File:** [routes/web.php:116-136](routes/web.php#L116-L136)
- **Evidence:** `Route::middleware(['auth'])->prefix('adminPanel')->name('admin.')->group(...)` gates every admin route (tours, activities, trekking, blog posts, categories, users, special offers) with only `auth`. `spatie/laravel-permission` is installed and `App\Models\User` uses `HasRoles` ([app/Models/User.php:15](app/Models/User.php#L15)), but no controller, middleware, or route calls `->role()`, `can()`, or a permission gate anywhere under `app/Http/Controllers/Admin/`.
- **Impact:** Any user who registers via the public `Auth::routes()` registration form (or any authenticated customer account) can access `/adminPanel/*`, including creating/editing/deleting tours, activities, blog posts, users, and — critically — `POST /adminPanel/posts/upload-image` (§1.2). This is a full authorization bypass.
- **Auth required:** Yes (but any registered account qualifies — registration itself is open).
- **Fix:** Add a role check (e.g. `role:admin` middleware backed by spatie/laravel-permission) to the `adminPanel` route group.

### 1.2 Unrestricted file upload — `Admin/PostController::uploadImage`
- **Severity:** Critical
- **File:** [app/Http/Controllers/Admin/PostController.php:147-162](app/Http/Controllers/Admin/PostController.php#L147-L162)
- **Evidence:**
  ```php
  public function uploadImage(Request $request)
  {
      if ($request->hasFile('image')) {
          $path = $request->file('image')->store('uploads/posts', 'public');
          return response()->json(['success' => true, 'url' => asset('storage/' . $path)]);
      }
      ...
  }
  ```
  No `$request->validate()` call at all. No extension allowlist, no MIME sniff, no size cap, no image-decode check. The file is stored with `Str::random(40)` (Laravel's default `store()` filename) but the **original extension is preserved verbatim** — so `shell.php` stored via this endpoint keeps the `.php` extension.
- **Impact:** Combined with §1.1 (any authenticated user reaches this route), an attacker can upload a PHP webshell to `storage/app/public/uploads/posts/`, which is publicly served via the `public/storage` junction → `storage/app/public` (confirmed present, [public/storage](public/storage)). If the web server executes PHP in that directory (typical default Apache/PHP-FPM config — no `.htaccess` execution block exists there), this is **unauthenticated-adjacent remote code execution**.
- **Fix:** Add strict allowlist validation (§ Upload Hardening below), re-encode through GD, generate a random filename, and add web-server execution blocking on `storage/app/public/uploads/`.

---

## 2. High

### 2.1 Public review "leave a review" image upload — no MIME sniff, no re-encode, extension preserved
- **Severity:** High
- **Files:**
  - [app/Http/Controllers/FrontTourController.php:334-342](app/Http/Controllers/FrontTourController.php#L334-L342) (`leaveReview`)
  - [app/Http/Controllers/FrontActivityController.php:274-283](app/Http/Controllers/FrontActivityController.php#L274-L283)
  - [app/Http/Controllers/FrontTrekkingController.php:321-328](app/Http/Controllers/FrontTrekkingController.php#L321-L328)
  - [app/Http/Controllers/PostController.php:190-196](app/Http/Controllers/PostController.php#L190-L196) (blog comments)
- **Evidence:** All four use the identical pattern:
  ```php
  'images.*' => 'nullable|image|max:2048',
  ...
  $path = $image->store('reviews', 'public');
  ```
  This is the public, unauthenticated "leave a review" gallery-upload feature (name/email/title/comment/ratings + images) referenced in the task — reachable by anyone via `POST /tours/{slug}/leave-review` etc., **no auth, no CSRF exemption issue (CSRF is fine, see §7), no rate limit**.
  Laravel's `image` rule (`Illuminate\Validation\Rules\File` under the hood) checks the file *is decodable as an image* via `getimagesize()`-equivalent logic, which blocks plain `.php`/`.svg`/`.html` renamed to `.jpg` reasonably well in Laravel 11 — **but**:
  1. It is subject to **CVE-2025-27515** (Laravel file-validation bypass, affects `<11.44.1`; installed version is `11.36.1`, unpatched — see §6.1).
  2. Even when validation passes, the uploaded bytes are stored **as-is** (`$image->store(...)`), preserving the original filename's extension and never re-encoding — so a valid-image polyglot (e.g., a JPEg with an appended PHP payload, or an image with malicious EXIF) is stored and served byte-for-byte.
  3. No dimension/pixel-count cap → decompression-bomb-sized images are accepted up to the 2MB byte limit.
- **Impact:** Combined with weak/absent web-server upload-directory execution hardening, a crafted polyglot file could be stored publicly. At minimum, EXIF/metadata is preserved and served to all visitors (privacy leak — GPS tags, device info from reviewer photos).
- **Fix:** Re-encode via GD (strip EXIF, normalize to JPEG/PNG), verify real MIME via `finfo`, enforce dimension/pixel-count limits, generate random filenames independent of Laravel's default.

### 2.2 SVG upload allowed for Special Offers — stored XSS via SVG + unescaped Blade output
- **Severity:** High
- **Files:**
  - [app/Http/Controllers/Admin/SpecialOfferController.php:28](app/Http/Controllers/Admin/SpecialOfferController.php#L28) and [:60](app/Http/Controllers/Admin/SpecialOfferController.php#L60) — `'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'`
  - [resources/views/front/index.blade.php:307](resources/views/front/index.blade.php#L307) — `{!! $offer->title !!}` (unescaped Blade output on the public homepage)
- **Evidence:** `SpecialOfferController` is the only controller in the app that allows `svg` as an accepted MIME for uploads. SVG files can embed `<script>` tags or event-handler attributes; when served directly (medialibrary serves raw uploaded bytes with `Content-Type: image/svg+xml` by default), a browser navigating directly to the SVG URL can execute the embedded script (stored XSS scoped to the storage-disk origin). Separately, `$offer->title` — a plain fillable string field, editable by anyone who can reach `/adminPanel/special-offers` (i.e., any authenticated user per §1.1) — is rendered with `{!! !!}` (no escaping) on the public homepage.
- **Impact:** Chained with §1.1 (no admin role check), any registered user can (a) set a Special Offer title to `<script>...</script>` for direct stored XSS on the homepage seen by every visitor, and/or (b) upload a malicious SVG that executes JS when viewed directly.
- **Fix:** Remove `svg` from the accepted mimes (task explicitly requires JPEG/PNG/JPG only unless proven necessary — it is not). Change `{!! $offer->title !!}` to `{{ $offer->title }}`.

### 2.3 Composer dependency: Laravel Framework file-validation bypass (CVE-2025-27515)
- **Severity:** High
- **Package:** `laravel/framework` installed `v11.36.1`, vulnerable range `>=11.0.0,<11.44.1`
- **Evidence:** `composer audit` output (saved run, see §6). Advisory: [GHSA-78fx-h6xr-vch4](https://github.com/advisories/GHSA-78fx-h6xr-vch4) — the `image`/`mimes` validation rules can be bypassed under specific conditions, directly undermining the `image` rule relied on by every upload path audited above (§2.1, §2.2, admin gallery uploads).
- **Impact:** Directly weakens every file-upload validation in the app that relies on Laravel's built-in `image`/`mimes` rules.
- **Fix:** Upgrade `laravel/framework` to `>=11.44.1` (patch-level, no breaking changes expected within the 11.x line). Requires `composer update laravel/framework --with-dependencies` — flagged for confirmation per change-management rules (dependency upgrade, not a migration, low risk but still requires your sign-off before running).

### 2.4 Laravel Framework: CRLF injection in default email validation rule
- **Severity:** High
- **Package:** `laravel/framework` installed `v11.36.1`, vulnerable range includes `<11.60.0`... (advisory range `>=9.0,<12.60.0` inclusive of our line)
- **Evidence:** `composer audit` — [GHSA-5vg9-5847-vvmq](https://github.com/advisories/GHSA-5vg9-5847-vvmq). Affects the default `email` validation rule used throughout this app (`ContactController`, `NewsletterController`, all reservation controllers, `leaveReview` methods all validate `'email' => 'required|email'`).
- **Impact:** Crafted email input could inject CRLF sequences into outgoing mail headers in specific configurations (email header injection), potentially enabling spoofed recipients/BCC injection via the contact form, newsletter, or reservation mail flows.
- **Fix:** Same upgrade as §2.3 covers this (fixed in `12.60.0`/`11.x` equivalent patch — verify exact patched 11.x tag at upgrade time).

---

## 3. Medium

### 3.1 Unauthenticated `/test-mail` route sends live email with no rate limiting
- **Severity:** Medium
- **File:** [routes/web.php:106-113](routes/web.php#L106-L113)
- **Evidence:** `Route::get('/test-mail', function () { Mail::raw(...)->to('localmoroccotour@gmail.com')... });` — no auth, no throttle.
- **Impact:** Anyone can trigger outbound email sends repeatedly (mail-relay abuse / spam vector, minor SMTP quota exhaustion). Also references the old `localmoroccotour@gmail.com` inbox per CLAUDE.md §9 (separate content issue, not in scope here).
- **Fix:** Remove the route (it's a debug leftover) or gate behind `auth` + `throttle`.

### 3.2 No security headers middleware anywhere in the stack
- **Severity:** Medium
- **File:** [app/Http/Kernel.php](app/Http/Kernel.php) (global + `web` middleware groups)
- **Evidence:** No middleware sets `X-Content-Type-Options`, `X-Frame-Options` / `frame-ancestors`, `Referrer-Policy`, `Permissions-Policy`, or CSP anywhere in the global or `web` middleware stack.
- **Impact:** No clickjacking protection, no MIME-sniff protection for served uploads (compounds §1.2/§2.1/§2.2 — browsers may sniff an uploaded file as HTML/script even with a correct `Content-Type`), no baseline CSP.
- **Fix:** Add a lightweight `SecurityHeaders` middleware applied globally, starting with non-breaking headers (`X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, `X-Frame-Options: SAMEORIGIN`). CSP deferred/report-only given the number of third-party script origins (GSAP CDN, jQuery CDN, Google Fonts, WhatsApp, Tripadvisor embed, etc.) — recommend a follow-up pass to enumerate exact allowed origins before enforcing.

### 3.3 No rate limiting on public form-submission routes
- **Severity:** Medium
- **Files:** [routes/web.php](routes/web.php) — `contact.send`, `newsletter.subscribe`, all `reserve` and `leave-review` routes, `review.helpful`/`review.notHelpful`
- **Evidence:** None of these routes use the `throttle` middleware alias (already registered in [app/Http/Kernel.php:65](app/Http/Kernel.php#L65) but unused outside the `api` group).
- **Impact:** Spam/abuse of contact form, newsletter signup, and — most relevant here — repeated review/image-upload submissions (upload-flood, fake-review spam). `ReviewController::markHelpful`/`markNotHelpful` do have their own IP-based one-vote guard, which is good, but the routes themselves have no throttle.
- **Fix:** Apply `throttle:10,1` (10 requests/minute, adjust per route) to public POST routes. Chosen to be generous enough not to block real customers per task constraints.

### 3.4 `Admin/PostController` and `ProfileController` uploads bypass spatie/medialibrary entirely
- **Severity:** Medium (rolled into §1.2 upload hardening scope)
- **Files:** [app/Http/Controllers/ProfileController.php:40-44](app/Http/Controllers/ProfileController.php#L40-L44)
- **Evidence:** `$path = $request->file('profile_photo')->store('profile_photos', 'public');` — same raw-store pattern as §1.2/§2.1, this time for authenticated users' own profile photo. Lower severity since it requires an authenticated+verified account and the `mimes:jpeg,png,jpg` allowlist (no SVG), but still no re-encode/EXIF-strip/dimension-cap.
- **Fix:** Route through the same hardened upload pipeline as §2.1.

---

## 4. Low

### 4.1 `APP_DEBUG=true` in local `.env`
- **File:** [.env:4](.env#L4)
- **Note:** Correctly scoped to `APP_ENV=local` and `.env` is gitignored and never committed (verified via `git log --all -- .env` — no history). **Not a live issue** as long as production deployment sets `APP_DEBUG=false`. Flagged only as a reminder for the production `.env`, not fixed here (per task: never change production environment values without explicit confirmation).

### 4.2 npm dependency advisories (dev/build tooling only)
- **Evidence:** `npm audit` reports vulnerabilities in `@babel/*` (build-time transpilation, including one High: arbitrary-code-generation in `@babel/plugin-transform-modules-systemjs` on malicious *input source*, not attacker-reachable at runtime), `ajv`, and other build-chain packages. These do not ship to the browser or affect runtime; low real-world exploitability for a marketing site with no user-supplied code compiled through Babel.
- **Fix:** Deferred to a routine `npm audit fix` pass (non-major) — listed in §6, not applied automatically per task constraints (no `--force`, no major upgrades without confirmation).

---

## 5. Reviewed and found safe (no action needed)

- **CSRF:** `App\Http\Middleware\VerifyCsrfToken` has an empty `$except` array — CSRF protection is active on all `web`-group POST routes, including every form audited (contact, newsletter, reservations, reviews). ✔
- **SQL injection:** All query construction goes through Eloquent/Query Builder with bound parameters. The one `whereRaw` in `FrontActivityController::index` ([app/Http/Controllers/FrontActivityController.php:57-60](app/Http/Controllers/FrontActivityController.php#L57-L60)) uses `?` placeholders with a bound values array — parameterized, not injectable. ✔
- **Mass assignment:** All Eloquent models reviewed (`Review`, `SpecialOffer`, `User`, `Post`) declare explicit `$fillable` arrays; none use `$guarded = []`. ✔ (Note: `SpecialOfferController::store/update` passes `$request->except(...)` directly to `create()`/`update()`, which is safe *only* because `$fillable` is a tight allowlist — flagged as a pattern to avoid in new code, not a live vuln.)
- **ProgramImport pipeline** (new CLI-only feature on this branch): path traversal, command injection, SQL injection, unsafe deserialization, and rollback-scope checks were all reviewed by an independent sub-review — no exploitable findings. Path containment uses `realpath()` canonicalization; no shell-outs; DB access is Eloquent-only. See background review notes (not a public-facing feature; CLI/operator-trusted per project threat model).
- **Open redirects / SSRF:** No user-controlled redirect targets or outbound HTTP calls with attacker-controlled host found in reviewed controllers.
- **Session cookies:** `config/session.php` — default Laravel secure-cookie config; `secure`/`http_only`/`same_site` are environment-driven and default to safe values in Laravel 11 skeleton. Verify `SESSION_SECURE_COOKIE=true` is set in the **production** `.env` (not committed, cannot verify from repo) — flagged as a manual deployment check, not a code fix.
- **CORS:** `config/cors.php` scoped to `api/*` and `sanctum/csrf-cookie` only; `supports_credentials: false`. Not a broad CORS misconfiguration. ✔

---

## 6. Dependency Audit Summary

### 6.1 Composer (`composer audit`) — 28 advisories across 14 packages

| Package | Installed | Severity | Advisory | Fixed in | Relevant here? |
|---|---|---|---|---|---|
| laravel/framework | 11.36.1 | High | CRLF injection in email validation (GHSA-5vg9-5847-vvmq / CVE-2026-48019) | 11.60.0-line patch | Yes — affects email validation across all forms (§2.4) |
| laravel/framework | 11.36.1 | Medium | File validation bypass (GHSA-78fx-h6xr-vch4 / CVE-2025-27515) | 11.44.1 | **Yes — directly relevant to upload hardening (§2.3)** |
| laravel/framework | 11.36.1 | Medium | Temporary signed URL path confusion (GHSA-crmm-hgp2-wgrp) | 12.61.1-line | Low relevance (no signed URLs used in reviewed code) |
| guzzlehttp/guzzle | 7.9.2 | Medium | Dot-only cookie domain host match (CVE-2026-55767) | 7.12.1 | Low (Guzzle used for outbound API calls only, not user-facing) |
| guzzlehttp/guzzle | 7.9.2 | Medium | Silent HTTPS→cleartext proxy downgrade (CVE-2026-55568) | 7.12.1 | Low |
| guzzlehttp/psr7 | 2.7.0 | Medium | CRLF injection in HTTP start-line (CVE-2026-55766) | 2.12.1 | Low |
| guzzlehttp/psr7 | 2.7.0 | Medium | CRLF injection via URI host (CVE-2026-49214) | 2.10.2 | Low |
| guzzlehttp/psr7 | 2.7.0 | Medium | Host confusion via authority reinterpretation (CVE-2026-48998) | 2.10.2 | Low |
| league/commonmark | 2.6.0 | Medium | Embed extension allowed_domains bypass (CVE-2026-33347) | check advisory | Not used for user-generated content in this app |
| league/commonmark | 2.6.0 | Medium | DisallowedRawHtml bypass via whitespace (CVE-2026-30838) | check advisory | Not used for user-generated content in this app |
| *(+ ~18 more, mostly transitive, see full `composer audit` output)* | | | | | |

Full output preserved for reference (not committed — contains no secrets, just advisory text; available on request).

**Recommendation:** Run `composer update laravel/framework guzzlehttp/guzzle guzzlehttp/psr7 --with-dependencies` (patch/minor only, no major-version bumps). **Not run automatically — requires your confirmation per task constraints.**

### 6.2 npm (`npm audit`)

Multiple advisories in **build-time only** dependencies (`@babel/*`, `ajv`, transitive `vite`/`webpack-mix` toolchain packages). None are shipped to the browser bundle or reachable by end users. One High-severity `@babel/plugin-transform-modules-systemjs` finding requires attacker control over the *source code being compiled* (not applicable — no user-generated code is ever passed through the build pipeline).

**Recommendation:** Routine `npm audit fix` (non-force) during a normal maintenance window. Not urgent; deferred, not applied in this pass.

---

## 7. Forms Inventory (documented current behavior)

| Form | Route | Auth | CSRF | File upload | Rate limit | Notes |
|---|---|---|---|---|---|---|
| Contact | `POST /contact/send` | No | Yes | No | **None** | Synchronous mail send |
| Newsletter | `POST /newsletter/subscribe` | No | Yes | No | **None** | `unique:` DB constraint prevents dupes |
| Tour reservation | `POST /tours/{slug}/reserve` | No | Yes | No | **None** | Logic stubbed ("to be implemented") |
| Activity reservation | `POST /activities/{slug}/reserve` | No | Yes | No | **None** | |
| Trekking reservation | `POST /trekking/{slug}/reserve` | No | Yes | No | **None** | |
| Tour review + gallery | `POST /tours/{slug}/leave-review` | No | Yes | **Yes — unhardened (§2.1)** | **None** | |
| Activity review + gallery | `POST /activities/{slug}/leave-review` | No | Yes | **Yes — unhardened (§2.1)** | **None** | |
| Trekking review + gallery | `POST /trekking/{slug}/leave-review` | No | Yes | **Yes — unhardened (§2.1)** | **None** | |
| Blog comment + gallery | `POST /blog/{slug}/leave-review` | No | Yes | **Yes — unhardened (§2.1)** | **None** | |
| Review helpful/not-helpful | `POST /review/{review}/helpful` etc. | No | Yes | No | IP-based one-vote guard (app-level, not throttle middleware) | |
| Admin post image upload | `POST /adminPanel/posts/upload-image` | **Auth only, no role (§1.1)** | Yes | **Yes — unrestricted (§1.2, Critical)** | **None** | |
| Admin gallery/cover uploads (Tour/Activity/Trekking/Location/Post/SpecialOffer) | Various `/adminPanel/*` resource routes | **Auth only, no role (§1.1)** | Yes | Yes — via spatie/medialibrary `addMediaFromRequest`, SVG allowed for SpecialOffer only (§2.2) | **None** | |
| Profile photo update | `POST /profile/update` | Auth + verified | Yes | **Yes — unhardened (§3.4)** | **None** | |

---

## 8. Fix Plan (next phase)

1. Add role-based authorization to `adminPanel` route group (§1.1).
2. Build a single hardened upload pipeline (allowlist, MIME sniff via `finfo`, GD re-encode + EXIF strip, random filename, dimension/pixel caps) and route all raw `->store()` upload sites through it: `Admin/PostController::uploadImage`, `ProfileController::update`, and all four `leaveReview` methods (§1.2, §2.1, §3.4).
3. Remove `svg` from `SpecialOfferController` mimes allowlist; escape `$offer->title` in `index.blade.php` (§2.2).
4. Add Apache execution-blocking for `storage/app/public/uploads/` and `storage/app/public/reviews/` (and `profile_photos/`).
5. Add `throttle` middleware to public POST routes (§3.3).
6. Add a lightweight security-headers middleware (§3.2).
7. Remove or gate `/test-mail` (§3.1).
8. Flag composer upgrade for your confirmation (§2.3, §2.4) — not applied automatically.
9. Add feature tests covering upload rejection/acceptance and authorization.

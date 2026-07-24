@extends('front.layouts.app')

@push('styles')
    {{-- Load Bootstrap Icons only if not already in the layout --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* ---- Hero typewriter effect (homepage) ---- */
        /* Force the heroIntro visible even though it sits inside the theme's
               data-anim-child reveal wrapper, so the JS typewriter is what plays. */
        .heroIntro {
            opacity: 1 !important;
            transform: none !important;
        }

        /* Blinking caret that trails the typed text. It's a span the JS keeps
               at the end of whichever line is currently typing. */
        .heroCaret {
            display: inline-block;
            width: 3px;
            margin-left: 2px;
            background: currentColor;
            animation: heroCaretBlink 0.7s steps(1) infinite;
            vertical-align: text-bottom;
        }

        .heroIntro__title .heroCaret {
            height: 0.9em;
        }

        .heroIntro__text .heroCaret {
            height: 1em;
        }

        @keyframes heroCaretBlink {

            0%,
            50% {
                opacity: 1;
            }

            50.01%,
            100% {
                opacity: 0;
            }
        }

        /* Reserve height so the hero doesn't jump as text types in. */
        .heroIntro__title {
            min-height: 1.1em;
        }

        .heroIntro__text {
            min-height: 3em;
        }

        /* Reduce the hero title size (theme default is 70px) for a calmer,
               more balanced hero. Keep the theme's responsive step-down. */
        .hero.-type-8 .hero__title {
            font-size: 56px;
        }

        @media (max-width: 991px) {
            .hero.-type-8 .hero__title {
                font-size: 48px;
            }
        }

        @media (max-width: 767px) {
            .hero.-type-8 .hero__title {
                font-size: 34px;
            }
        }

        @media (max-width: 575px) {
            .hero.-type-8 .hero__title {
                font-size: 26px;
            }
        }

        /* Reduced motion: skip typing, JS fills text instantly (see script). */

        /* ---- Hero background carousel (crossfade) ---- */
        /* The theme's .hero__bg img is only object-fit:cover (not positioned),
               so three imgs would stack vertically. Absolutely position each slide
               to overlap in the same box, then crossfade via opacity. */
        .js-hero-carousel .heroSlide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }

        .js-hero-carousel .heroSlide.is-active {
            opacity: 1;
        }

        @media (prefers-reduced-motion: reduce) {

            /* No crossfade animation; only the first (active) slide shows. */
            .js-hero-carousel .heroSlide {
                transition: none;
            }
        }

        /* ---- "Popular" badge (Find Popular Tours/Activities/Trekking) ---- */
        .popularBadge {
            position: absolute;
            top: 12px;
            left: 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px 6px 10px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
            letter-spacing: 0.02em;
            color: #fff;
            border-radius: 999px;
            background: linear-gradient(135deg, #ff8a00 0%, #ff5e3a 100%);
            box-shadow: 0 6px 16px rgba(255, 94, 58, 0.35);
            backdrop-filter: saturate(1.2);
            z-index: 2;
        }

        .popularBadge i {
            font-size: 13px;
            animation: popularFlameFlicker 1.6s ease-in-out infinite;
        }

        @keyframes popularFlameFlicker {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.15);
                opacity: 0.85;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .popularBadge i {
                animation: none;
            }
        }

        /* ---- Marrakech CTA (desktop): the heading/paragraph column is wide
               enough to run under the right-hand image. Cap the text width so it
               wraps before it reaches the image edge. ---- */
        @media (min-width: 992px) {
            .cta.-type-4 .cta__content .col-xl-7 h2,
            .cta.-type-4 .cta__content .col-xl-7 p {
                max-width: 560px;
            }
        }

        /* ---- Marrakech CTA (mobile): add breathing room between the
               "Explore Tours" button and the image stacked below it. The theme
               reserves fixed bottom padding for the absolutely-positioned image;
               bump it so the button no longer touches the image. ---- */
        @media (max-width: 767px) {
            .cta.-type-4 .cta__content {
                padding-bottom: 340px;
            }
            /* Pin the image to the bottom of the content and force its height to
               match the reserved padding above, so it fills the whole reserved
               strip (no white gap under the image). */
            .cta.-type-4 .cta__image {
                top: unset;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 320px;
                padding-right: 0;
            }
            .cta.-type-4 .cta__image figure,
            .cta.-type-4 .cta__image img {
                height: 100%;
                width: 100%;
                margin: 0;
                object-fit: cover;
            }
        }

        /* ---- Decorative travel SVG in the Marrakech CTA left column ----
               Sits as a faint watermark BEHIND the text/button, absolutely
               positioned so it takes no layout space and never stretches the
               column or pushes content around. */
        .ctaTextCol {
            position: relative;
        }

        .ctaTravelArt {
            position: absolute;
            left: 0;
            right: 0;
            bottom: -18px;
            max-width: 460px;
            opacity: .16;
            pointer-events: none;
            z-index: 0;
        }

        /* Keep the real content above the watermark. */
        .ctaTextCol > h2,
        .ctaTextCol > p,
        .ctaTextCol > button {
            position: relative;
            z-index: 1;
        }

        /* Corner accents (top-left / top-right), framing the heading with room
           to breathe so they never sit on top of the letters. Reserve a strip of
           space above the heading (padding-top on the text column) so the icons
           get their own row instead of overlapping text. Shown on desktop and
           mobile alike. */
        .ctaTextCol {
            padding-top: 52px;
        }

        .ctaCornerArt {
            position: absolute;
            top: 0;
            width: 40px;
            height: 40px;
            opacity: .55;
            pointer-events: none;
            z-index: 0;
        }

        .ctaCornerArt--left {
            left: 2px;
        }

        .ctaCornerArt--right {
            right: 2px;
        }

        @media (max-width: 767px) {
            .ctaTextCol {
                padding-top: 44px;
            }

            .ctaCornerArt {
                width: 34px;
                height: 34px;
            }
        }

        .ctaTravelArt svg {
            width: 100%;
            height: auto;
            display: block;
            /* gentle float so it feels alive without being distracting */
            animation: ctaTravelFloat 5s ease-in-out infinite;
        }

        @keyframes ctaTravelFloat {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-6px); }
        }

        @media (prefers-reduced-motion: reduce) {
            .ctaTravelArt svg { animation: none; }
        }

        /* Mobile: the watermark spans the full stacked column, so cap it a bit
           smaller to match the narrower text block. */
        @media (max-width: 767px) {
            .ctaTravelArt {
                max-width: 320px;
                bottom: -10px;
            }
        }

        @media (max-width: 575px) {
            .cta.-type-4 .cta__content {
                padding-bottom: 250px;
            }
            .cta.-type-4 .cta__image {
                height: 230px;
            }
        }

        /* ---- Hero Search button hover ----
               The theme's .button.-dark-1:hover forces a bright blue (--color-blue-1
               #0040a1), which clashes with the button's dark-navy (accent-2 #05073C)
               base. Keep the hover in our dark-blue palette: deepen slightly instead
               of switching to the bright blue. */
        .searchForm__button .button.-dark-1:hover {
            background-color: #0a1052 !important;
            border-color: #0a1052;
            color: white !important;
        }

        /* ---- Hero search-bar labels (Where / When / Tour Type) ----
               Use the brand gold accent-1 (#C49539) for the field labels. */
        .searchFormItem__content h5 {
            color: #C49539;
        }

        /* ---- Hero search DROPDOWNS: make the option rows more compact ----
               The theme sets each dropdown row (location + tour type) to a fixed
               60px height, which reads oversized. Trim the height/padding/font so
               the lists look tighter on desktop and mobile alike. */
        .searchForm.-type-1 .searchFormItemDropdown.-location .searchFormItemDropdown__item button,
        .searchForm.-type-1 .searchFormItemDropdown.-tour-type .searchFormItemDropdown__item button {
            height: 42px;
            padding: 0 14px;
        }

        .searchForm.-type-1 .searchFormItemDropdown.-location .searchFormItemDropdown__item button > span:nth-child(1),
        .searchForm.-type-1 .searchFormItemDropdown.-tour-type .searchFormItemDropdown__item button > span:nth-child(1) {
            font-size: 14px;
            line-height: 1.4;
        }

        .searchForm.-type-1 .searchFormItemDropdown.-location .searchFormItemDropdown__item button > span:nth-child(2) {
            font-size: 12px;
            line-height: 1.4;
        }

        /* Calendar: drop the tall min-height so the panel isn't oversized. */
        .searchForm.-type-1 .searchFormItemDropdown.-calendar .searchFormItemDropdown__container {
            min-height: 0;
            padding: 16px;
        }

        /* ---- Hero search bar ----
               DESKTOP / TABLET: restored to the theme default — the search bar
               sits inside the hero (no seam-float). The seam-overlap treatment is
               now MOBILE-ONLY (see the max-width:767px block below), which is the
               layout that was requested to stay as-is on phones. On desktop the
               .heroSearchOverlap / .heroAboutSpacer classes are inert. */

        @media (max-width: 767px) {

            /* --- Mobile: float the search bar on the seam between the hero and
                   the About section (kept as the current phone layout). --- */
            .hero.-type-8 {
                min-height: 620px;
                display: flex;
                padding-bottom: 40px;
            }

            .hero.-type-8>.container {
                width: 100%;
                align-self: stretch;
                display: flex;
            }

            .hero.-type-8>.container>.row {
                width: 100%;
                align-items: stretch;
            }

            .hero.-type-8 .hero__content {
                height: 100%;
                justify-content: flex-start;
            }

            /* The theme reorders .hero__content children on mobile; with our
                   DOM order (title first, search last) that would move the search
                   bar back to the top. Force the natural order. */
            .hero.-type-8 .hero__content>*:nth-child(1) {
                order: 1;
            }

            .hero.-type-8 .hero__content>*:nth-child(2) {
                order: 2;
            }

            /* Horizontal centering fix: on mobile the theme column
                   (.col-lg-8/.col-md-10) doesn't span the full container width, so
                   the search bar sat flush-left with an uneven gap on the right.
                   Force the column + row to full width so the bar is symmetric
                   within the container's 15px side padding. */
            .hero.-type-8>.container>.row {
                justify-content: center;
                margin-left: 0;
                margin-right: 0;
            }

            .hero.-type-8>.container>.row>[class*="col-"] {
                flex: 0 0 100%;
                max-width: 100%;
                padding-left: 0;
                padding-right: 0;
            }

            .hero.-type-8 .hero__content {
                align-items: stretch;
                text-align: center;
            }

            /* On mobile the search bar is tall (stacked). Sit its TOP edge at the
                   hero's bottom line so the bar hangs down into the section below
                   (like the reference), rather than being centered on the seam. */
            .heroSearchOverlap {
                width: 100%;
                margin-top: auto;
                margin-bottom: 0;
                /* Pin the bar to the hero's bottom edge, then push it DOWN so it
                   hangs across the seam into the white section below (matches the
                   reference). The .heroAboutSpacer padding-top reserves room so the
                   translated bar doesn't cover the About content. */
                transform: translateY(58%);
                z-index: 6;
                position: relative;
            }

            /* --- Make the mobile search bar more compact (smaller than desktop) --- */
            .heroSearchOverlap .searchFormItem__button {
                padding: 14px 16px;
            }

            .heroSearchOverlap .searchFormItem__icon.size-50 {
                width: 40px;
                height: 40px;
            }

            .heroSearchOverlap .searchFormItem__icon i {
                font-size: 16px;
            }

            .heroSearchOverlap .searchFormItem__content h5 {
                font-size: 15px;
                margin-bottom: 2px;
            }

            .heroSearchOverlap .searchFormItem__content > div,
            .heroSearchOverlap .searchFormItem__content .js-select-control-chosen {
                font-size: 14px;
            }

            .heroSearchOverlap .searchForm__button .button {
                min-height: 0;
                padding-top: 16px;
                padding-bottom: 16px;
                font-size: 15px;
            }

            .heroSearchOverlap>form {
                width: 100%;
                max-width: 100%;
                margin-left: auto;
                margin-right: auto;
            }

            .heroAboutSpacer {
                padding-top: 175px;
            }
        }
    </style>
@endpush

@section('content')

    <section data-anim-wrap class="hero -type-8">
        <div data-anim-child="slide-up" class="hero__bg js-hero-carousel">
            <img class="heroSlide is-active"
                src="{{ asset('assets/images/hero/sahara-desert-luxury-camp-stargazing-morocco.webp') }}"
                alt="Luxury desert camp under the stars in the Sahara, Morocco" width="1920" height="860"
                fetchpriority="high" decoding="async">
            <img class="heroSlide" src="{{ asset('assets/images/hero/morocco-sahara-camel-trek-sunset-merzouga.webp') }}"
                alt="Camel trek at sunset in the Merzouga dunes, Morocco" width="1920" height="860" loading="lazy"
                decoding="async">
            <img class="heroSlide"
                src="{{ asset('assets/images/hero/marrakech-palace-courtyard-riad-architecture-morocco.avif') }}"
                alt="Marrakech palace courtyard with traditional riad architecture, Morocco" width="1920" height="860"
                loading="lazy" decoding="async">
        </div>

        <div class="container">
            <div data-anim-child="slide-up delay-2" class="row justify-center">
                <div class="col-lg-8 col-md-10">
                    <div class="hero__content text-center">

                        {{-- TITLE & TEXT (typewriter effect via JS below) --}}
                        <div class="heroIntro">
                            <h1 class="hero__title text-white heroIntro__title js-typewriter"
                                data-text="Find Next Place To Visit">Find Next Place To Visit</h1>
                            <div class="hero__text text-white mt-10 heroIntro__text js-typewriter"
                                data-text="Discover amazing places at exclusive deals. Eat, Shop, Visit interesting places around the world.">
                                Discover amazing places at exclusive deals. Eat, Shop, Visit interesting places around the
                                world.</div>
                        </div>

                        {{-- SEARCH FILTER — theme-default placement inside the hero on
                             desktop/tablet. On mobile, .heroSearchOverlap floats it on
                             the seam between the hero and the About section (see CSS). --}}
                        <div class="hero__filter mb-60 md:mb-0 md:mt-30 heroSearchOverlap">
                            <form action="{{ route('front.tours.index') }}" method="GET">
                                <div class="searchForm -type-1 shadow-1 rounded-200">
                                    <div class="searchForm__form">

                                        {{-- WHERE DROPDOWN --}}
                                        <div class="searchFormItem js-select-control js-form-dd">
                                            <div class="searchFormItem__button" data-x-click="location">
                                                <div class="searchFormItem__icon size-50 rounded-full border-1 flex-center">
                                                    <i class="text-20 icon-pin"></i>
                                                </div>
                                                <div class="searchFormItem__content">
                                                    <h5>Where</h5>
                                                    <div class="js-select-control-chosen">Search destinations</div>
                                                </div>
                                            </div>
                                            <div class="searchFormItemDropdown -location" data-x="location"
                                                data-x-toggle="is-active">
                                                <div class="searchFormItemDropdown__container">
                                                    <div class="searchFormItemDropdown__list scroll-bar-1">
                                                        @forelse ($locationsForSearch as $location)
                                                            <div class="searchFormItemDropdown__item">
                                                                <button type="button" class="js-select-control-button"
                                                                    data-slug="{{ $location->slug }}"
                                                                    data-name="{{ $location->name }}">
                                                                    <span
                                                                        class="js-select-control-choice">{{ $location->name }}</span>
                                                                    <span>Location</span>
                                                                </button>
                                                            </div>
                                                        @empty
                                                            <div class="searchFormItemDropdown__item">
                                                                <span class="text-14 text-light-1">No destinations available
                                                                    yet</span>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- WHEN DROPDOWN (calendar logic stays unchanged) --}}
                                        <div class="searchFormItem js-select-control js-form-dd js-calendar">
                                            <div class="searchFormItem__button" data-x-click="calendar">
                                                <div class="searchFormItem__icon size-50 rounded-full border-1 flex-center">
                                                    <i class="text-20 icon-calendar"></i>
                                                </div>
                                                <div class="searchFormItem__content">
                                                    <h5>When</h5>
                                                    <div>
                                                        <span class="js-first-date">Add dates</span>
                                                        <span class="js-last-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="searchFormItemDropdown -calendar" data-x="calendar"
                                                data-x-toggle="is-active">
                                                <div class="searchFormItemDropdown__container">
                                                    <div class="searchMenu-date -searchForm js-form-dd js-calendar-el">
                                                        <div class="searchMenu-date__field shadow-2"
                                                            data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">
                                                            <div class="bg-white rounded-4">
                                                                <div class="elCalendar js-calendar-el-calendar"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- TOUR TYPE DROPDOWN --}}
                                        <div class="searchFormItem js-select-control js-form-dd">
                                            <div class="searchFormItem__button" data-x-click="tour-type">
                                                <div class="searchFormItem__icon size-50 rounded-full border-1 flex-center">
                                                    <i class="text-20 icon-flag"></i>
                                                </div>
                                                <div class="searchFormItem__content">
                                                    <h5>Tour Type</h5>
                                                    <div class="js-select-control-chosen">All tour</div>
                                                </div>
                                            </div>
                                            <div class="searchFormItemDropdown -tour-type" data-x="tour-type"
                                                data-x-toggle="is-active">
                                                <div class="searchFormItemDropdown__container">
                                                    <div class="searchFormItemDropdown__list scroll-bar-1">
                                                        @forelse ($tourCategories as $category)
                                                            <div class="searchFormItemDropdown__item">
                                                                <button type="button" class="js-select-control-button"
                                                                    data-slug="{{ $category->slug }}"
                                                                    data-name="{{ $category->name }}">
                                                                    <span
                                                                        class="js-select-control-choice">{{ $category->name }}</span>
                                                                </button>
                                                            </div>
                                                        @empty
                                                            <div class="searchFormItemDropdown__item">
                                                                <span class="text-14 text-light-1">No tour types available
                                                                    yet</span>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- SEARCH BUTTON --}}
                                    <div class="searchForm__button">
                                        <button type="submit" class="button -dark-1 bg-accent-2 text-white">
                                            <i class="icon-search text-16 mr-10"></i>
                                            Search
                                        </button>
                                    </div>

                                    {{-- Hidden fields to store selected data --}}
                                    <input type="hidden" name="location_slug" id="location_slug">
                                    <input type="hidden" name="tour_category_slug" id="tour_category_slug">
                                    <input type="hidden" name="start_date" id="start_date">
                                    <input type="hidden" name="end_date" id="end_date">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        {{-- TEST ONLY: disable scroll-reveal animations on the homepage to check
             if they are causing lag. Strips the data-anim* attributes before the
             theme's RevealAnim (window.load) can wire up ScrollMagic scenes, and
             forces the elements visible. Remove this block to restore animations. --}}
        <style>
            [data-anim],
            [data-anim-wrap],
            [data-anim-child] {
                opacity: 1 !important;
                transform: none !important;
                visibility: visible !important;
            }
        </style>
        <script>
            (function() {
                function killAnims() {
                    document.querySelectorAll('[data-anim], [data-anim-wrap], [data-anim-child]')
                        .forEach(function(el) {
                            el.removeAttribute('data-anim');
                            el.removeAttribute('data-anim-wrap');
                            el.removeAttribute('data-anim-child');
                        });
                }
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', killAnims);
                } else {
                    killAnims();
                }
            })();
        </script>
        <script>
            (function() {
                var els = Array.prototype.slice.call(document.querySelectorAll('.heroIntro .js-typewriter'));
                if (!els.length) return;

                var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                // If the user prefers reduced motion, just leave the static text as-is.
                if (reduce) return;

                // Clear each line and prep a caret; hold the real text in data-text.
                els.forEach(function(el) {
                    el.textContent = '';
                });

                function typeLine(el, done) {
                    var text = el.getAttribute('data-text') || '';
                    var caret = document.createElement('span');
                    caret.className = 'heroCaret';
                    el.textContent = '';
                    el.appendChild(caret);

                    var i = 0;
                    // ~35ms/char for the title, a touch faster for the longer paragraph.
                    var speed = text.length > 40 ? 22 : 45;

                    (function tick() {
                        if (i < text.length) {
                            caret.insertAdjacentText('beforebegin', text.charAt(i));
                            i++;
                            setTimeout(tick, speed);
                        } else {
                            // Remove the caret once a line finishes so nothing keeps blinking.
                            el.removeChild(caret);
                            if (done) done();
                        }
                    })();
                }

                // Type each line in sequence: title first, then the paragraph.
                function run(idx) {
                    if (idx >= els.length) return;
                    var isLast = idx === els.length - 1;
                    typeLine(els[idx], isLast ? null : function() {
                        run(idx + 1);
                    });
                }

                // Kick off shortly after load so the hero image/reveal settles.
                setTimeout(function() {
                    run(0);
                }, 500);
            })();

            // ---- Hero background carousel: auto-crossfade every 5s ----
            (function() {
                var carousel = document.querySelector('.js-hero-carousel');
                if (!carousel) return;

                var slides = Array.prototype.slice.call(carousel.querySelectorAll('.heroSlide'));
                if (slides.length < 2) return; // nothing to rotate

                var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (reduce) return; // honor reduced-motion: keep the first slide only

                var current = 0;
                setInterval(function() {
                    slides[current].classList.remove('is-active');
                    current = (current + 1) % slides.length;
                    slides[current].classList.add('is-active');
                }, 5000);
            })();
        </script>
    @endpush

    <section class="layout-pt-lg heroAboutSpacer">
        <div data-anim-wrap class="container">

            {{-- ABOUT US SECTION TITLE --}}
            <div data-anim-child="slide-up" class="row justify-between items-end y-gap-10 mb-40">
                <div class="col-auto">
                    <h2 class="text-30 md:text-24">About Us</h2>
                </div>
            </div>

            <div class="row y-gap-30 justify-between items-center">

                <div data-anim-child="slide-up" class="col-lg-6">
                    <figure class="m-0">
                        <img src="{{ asset('assets/images/hero/chefchaouen-blue-city-aerial-drone-view-morocco.avif') }}"
                            alt="Locals walking through a narrow terracotta-walled street in the Marrakech medina, Morocco"
                            title="Narrow street in the Marrakech medina, Morocco" class="rounded-12 w-100 h-auto"
                            loading="lazy" width="960" height="640" style="object-fit: cover;">
                        <figcaption class="visually-hidden">
                            A traditional narrow alley in the old medina of Marrakech, with locals and terracotta walls
                            capturing
                            everyday Moroccan life.
                        </figcaption>
                    </figure>
                </div>

                <div data-anim-child="slide-up delay-2" class="col-lg-5">
                    <h2 class="text-24 md:text-20 fw-700 mb-20" style="color: #C49539;">
                        Discover Authentic Morocco Adventures — Your Gateway to Authentic Moroccan Experiences
                    </h2>

                    <p>
                        At Authentic Morocco Adventures, we’re passionate about revealing Morocco’s vibrant spirit and
                        hidden treasures.
                        From the blue streets of Chefchaouen to the golden dunes of the Sahara, our expertly crafted tours
                        immerse you
                        in authentic culture, stunning landscapes, and unforgettable moments.
                        <br><br>
                        Let our local team guide you beyond the usual paths, creating memories that capture the true essence
                        of Morocco.
                    </p>

                    <a href="{{ route('front.tours.index', ['type' => 'multi_day']) }}"
                        class="button -sm -dark-1 bg-accent-1 text-white mt-30">
                        Explore Our Tours
                    </a>
                </div>

            </div>
        </div>
    </section>


    @if ($specialOffers->isNotEmpty())
        <style>
            /* Ensure the special offer image always fills the card (overrides the
               .h-auto utility so the bottom of the image reaches the card edge,
               especially on mobile where the card becomes full-width). */
            .specialCard__image img {
                height: 100% !important;
                width: 100% !important;
                object-fit: cover;
            }
        </style>
        <section class="layout-pt-xl">
            <div data-anim-wrap class="container">
                <div data-anim-child="slide-up" class="row justify-between items-end y-gap-10">
                    <div class="col-auto">
                        <h2 class="text-30 md:text-24">Special Offers</h2>
                    </div>
                </div>

                <div class="specialCardGrid row y-gap-30 md:y-gap-20 pt-40 sm:pt-20">
                    @foreach ($specialOffers as $offer)
                        <div data-anim-child="slide-up delay-{{ $loop->iteration }}" class="col-xl-4 col-lg-6 col-md-6">
                            <a href="{{ $offer->link ?? '#' }}" class="specialCard"
                                aria-label="{{ strip_tags($offer->title) }}">
                                <div class="specialCard__image">
                                    <img src="{{ $offer->getFirstMediaUrl('special_offers') }}"
                                        alt="{{ $offer->getFirstMedia('special_offers')?->getCustomProperty('alt') ?? $offer->title }}"
                                        title="{{ $offer->getFirstMedia('special_offers')?->getCustomProperty('title') ?? $offer->title }}"
                                        loading="lazy" width="600" height="400" class="rounded-12 w-100 h-auto">
                                </div>

                                <div class="specialCard__content">
                                    <div class="specialCard__subtitle">{{ $offer->subtitle }}</div>
                                    <h3 class="specialCard__title">{!! $offer->title !!}</h3>
                                    <div class="specialCard__text">{{ $offer->text }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($locationsForSection->isNotEmpty())
        <style>
            /* Round "trending destination" avatar cards — circular image,
               title and tour count beneath, matching the theme's existing
               -hover-image-scale interaction pattern but without needing
               the .featureCard aspect-ratio wrapper. */
            .destAvatar {
                display: block;
                text-align: center;
            }
            .destAvatar__image {
                width: 130px;
                height: 130px;
                margin: 0 auto;
                border-radius: 50%;
                overflow: hidden;
            }
            .destAvatar__image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>
        <section class="layout-pt-xl layout-pb-xl">
            <div data-anim-wrap class="container">
                <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-end">
                    <div class="col-auto">
                        <h2 class="text-30">Trending Morocco Destinations</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('front.locations.index') }}" class="buttonArrow d-flex items-center">
                            <span>See all</span>
                            <i class="icon-arrow-top-right text-16 ml-10"></i>
                        </a>
                    </div>
                </div>

                <div data-anim-child="slide-up delay-2" class="relative pt-40 sm:pt-20">
                    <div class="overflow-hidden js-section-slider" data-gap="36"
                        data-slider-cols="xl-8 lg-5 md-4 sm-3 base-2" data-nav-prev="js-slider5-prev"
                        data-nav-next="js-slider5-next">

                        <div class="swiper-wrapper">
                            @foreach ($locationsForSection as $location)
                                @php
                                    $media = $location->getFirstMedia('locations');
                                    $imgUrl = $media?->getUrl() ?? asset('assets/images/aga1.jpg');
                                    $alt = $media?->getCustomProperty('alt') ?? $location->name;
                                    $title = $media?->getCustomProperty('title') ?? $location->name;
                                @endphp

                                <div class="swiper-slide">
                                    <a href="{{ route('front.locations.show', $location->slug) }}"
                                        class="destAvatar -hover-image-scale"
                                        title="{{ $title }}" aria-label="Explore {{ $location->name }}">
                                        <div class="destAvatar__image -hover-image-scale__image">
                                            <img src="{{ $imgUrl }}" alt="{{ $alt }}"
                                                title="{{ $title }}" loading="lazy" width="130" height="130">
                                        </div>

                                        <h3 class="text-16 fw-500 mt-20">{{ $location->name }}</h3>
                                        <div class="text-14 mt-5">
                                            {{ $location->tours_count }}
                                            {{ \Illuminate\Support\Str::plural('Tour', $location->tours_count) }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="navAbsolute">
                        <button class="navAbsolute__button bg-white js-slider5-prev" aria-label="Previous slide">
                            <i class="icon-arrow-left text-14"></i>
                        </button>
                        <button class="navAbsolute__button bg-white js-slider5-next" aria-label="Next slide">
                            <i class="icon-arrow-right text-14"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <style>
        /* Keep the heading from crowding the souk image on desktop only */
        @media (min-width: 992px) {
            .ctaHeading {
                padding-right: 40px;
            }
        }
    </style>

    <section data-anim="slide-up" class="cta -type-4 -style-2">
        <div class="container">
            <div class="cta__content">
                <div class="row justify-between">
                    <div class="col-xl-7 col-lg-8 ctaTextCol">
                        {{-- Corner accents: small decorative SVGs that frame the
                             heading (top-left pin, top-right plane), offset clear
                             of the text so they never overlap letters. Shown on
                             both desktop and mobile. --}}
                        <svg class="ctaCornerArt ctaCornerArt--left" viewBox="0 0 64 64" fill="none"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <circle cx="32" cy="32" r="30" fill="none" stroke="#C49539" stroke-width="1.5"
                                stroke-dasharray="1 7" stroke-linecap="round" opacity=".5" />
                            <path
                                d="M32 15c-7.2 0-13 5.77-13 12.9 0 9.68 13 21.1 13 21.1s13-11.42 13-21.1C45 20.77 39.2 15 32 15z"
                                fill="#C49539" />
                            <circle cx="32" cy="27.5" r="5.5" fill="#fff" />
                        </svg>

                        <svg class="ctaCornerArt ctaCornerArt--right" viewBox="0 0 64 64" fill="none"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M6 46c10-18 26-30 46-34" stroke="#044cb8" stroke-width="1.5"
                                stroke-linecap="round" stroke-dasharray="1 7" opacity=".45" />
                            <g transform="translate(30 6) rotate(48)">
                                <path
                                    d="M0 11.5 24 0l-6.5 9.8L28 12l-1 4.6-11.5-2.4L13 26l-4.3-1.6-2-10.2z"
                                    fill="#05073C" />
                            </g>
                        </svg>

                        <h2 class="text-24 lh-13 ctaHeading">
                            Uncover the Magic of Marrakech with Authentic Morocco Adventures
                        </h2>

                        <p class="mt-10" style="max-width: 500px;">
                            Discover Marrakech’s vibrant souks filled with glowing lanterns, authentic Moroccan
                            craftsmanship, and unforgettable cultural experiences with Authentic Morocco Adventures.
                        </p>

                        <button>
                            <a href="{{ route('front.tours.index', ['type' => 'multi_day']) }}"
                                class="button -md -accent-1 bg-dark-1 text-white mt-10"
                                aria-label="Explore tours in Marrakech with Authentic Morocco Adventures">
                                Explore Tours
                                <i class="icon-arrow-top-right ml-10" aria-hidden="true"></i>
                            </a>
                        </button>

                        {{-- Decorative travel illustration (self-contained SVG) —
                             a dotted flight path from a start pin to a destination
                             pin with a plane, plus a small compass. Purely visual,
                             hidden on small screens so it never crowds the text. --}}
                        <div class="ctaTravelArt" aria-hidden="true">
                            <svg viewBox="0 0 520 120" fill="none" xmlns="http://www.w3.org/2000/svg"
                                role="img" aria-label="Travel route illustration">
                                <!-- dotted flight path -->
                                <path d="M40 92 C 150 20, 260 20, 350 60"
                                    stroke="#044cb8" stroke-width="2.5" stroke-linecap="round"
                                    stroke-dasharray="2 10" opacity=".55" />

                                <!-- start location pin -->
                                <g>
                                    <path d="M40 92c0 0-13-13-13-24a13 13 0 1 1 26 0c0 11-13 24-13 24z"
                                        fill="#C49539" />
                                    <circle cx="40" cy="68" r="5" fill="#fff" />
                                </g>

                                <!-- plane travelling along the path -->
                                <g transform="translate(200 34) rotate(18)">
                                    <path d="M2 12l30-8-6 10 14 2-2 6-14-2 2 12-6-2-4-12-14 4z"
                                        fill="#05073C" />
                                </g>

                                <!-- destination location pin (brand blue) -->
                                <g>
                                    <path d="M350 60c0 0-14-14-14-26a14 14 0 1 1 28 0c0 12-14 26-14 26z"
                                        fill="#044cb8" />
                                    <circle cx="350" cy="34" r="5.5" fill="#fff" />
                                </g>

                                <!-- little compass -->
                                <g transform="translate(430 40)">
                                    <circle cx="30" cy="30" r="28" fill="#fff" stroke="#e3e3e3"
                                        stroke-width="2" />
                                    <circle cx="30" cy="30" r="28" fill="none" stroke="#C49539"
                                        stroke-width="2" stroke-dasharray="3 5" opacity=".6" />
                                    <path d="M30 12l7 18-7 6-7-6z" fill="#044cb8" />
                                    <path d="M30 48l-7-18 7-6 7 6z" fill="#C49539" />
                                    <circle cx="30" cy="30" r="3" fill="#05073C" />
                                </g>
                            </svg>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="cta__image">
                            <figure>
                                <img src="{{ asset('assets/images/home/marrakech-souk-moroccan-brass-lanterns-market.webp') }}"
                                    alt="Golden Moroccan brass lanterns glowing in a traditional Marrakech souk, showcasing Moroccan craftsmanship and vibrant culture."
                                    title="Marrakech Souk Moroccan Brass Lanterns Market" loading="lazy"
                                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                <figcaption style="display: none;">
                                    Traditional brass lanterns fill the vibrant souks of Marrakech with shimmering light and
                                    artistry.
                                </figcaption>
                            </figure>

                            {{-- Decorative torn-edge shape overlays removed so the image
                                 renders as a clean rectangle. --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TouristAttraction",
  "name": "Marrakech Souk Moroccan Brass Lanterns Market",
  "description": "A stunning view inside a traditional Moroccan souk in Marrakech, filled with intricately crafted brass lanterns and lamps. Each lantern reflects the rich artisan heritage of Morocco, creating a golden glow throughout the market alleys. Explore these magical sights with Authentic Morocco Adventures.",
  "image": "https://www.authenticmoroccoadventures.com/assets/images/home/marrakech-souk-moroccan-brass-lanterns-market.webp",
  "url": "https://www.authenticmoroccoadventures.com",
  "provider": {
    "@type": "TravelAgency",
    "name": "Authentic Morocco Adventures",
    "url": "https://www.authenticmoroccoadventures.com"
  },
  "copyrightNotice": "© 2025 Authentic Morocco Adventures"
}
</script>

    <script></script>

    <!-- Tours Section -->
    @if ($tours->isNotEmpty())
        <section class="layout-pt-xl">
            <div data-anim-wrap class="container">
                <div data-anim-child="slide-up" class="row justify-between items-end y-gap-10">
                    <div class="col-auto">
                        <h2 class="text-30 md:text-24">Best Morocco Multi-Day Tours</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('front.tours.index', ['type' => 'multi_day']) }}" class="buttonArrow d-flex items-center">
                            <span>See all</span>
                            <i class="icon-arrow-top-right text-16 ml-10"></i>
                        </a>
                    </div>
                </div>

                <div class="row y-gap-30 justify-between pt-40 sm:pt-20 mobile-css-slider -w-300 js-mobile-autoscroll">
                    @foreach ($tours as $tour)
                        @php
                            $cover = $tour->getFirstMedia('cover');
                            $coverUrl = $cover?->getUrl() ?? null;

                            if (!$coverUrl) {
                                $galleryImage = $tour->getFirstMedia('gallery');
                                $coverUrl = $galleryImage?->getUrl() ?? asset('assets/images/default-image.png');
                                $media = $galleryImage;
                            } else {
                                $media = $cover;
                            }

                            $alt = $media?->getCustomProperty('alt') ?? $tour->title;
                            $title = $media?->getCustomProperty('title') ?? $tour->title;
                            $caption = $media?->getCustomProperty('caption') ?? '';
                            $desc = $media?->getCustomProperty('description') ?? '';

                            $reviewsCount = (int) ($tour->reviews_count ?? 0);
                            $rating = $tour->avg_rating ?? 0;
                        @endphp

                        <div data-anim-child="slide-up delay-{{ $loop->iteration }}" class="col-lg-3 col-md-6">
                            <div class="tourCard -type-1 py-10 px-10 border-1 rounded-12 -hover-shadow bg-white relative">
                                <div class="tourCard__header">
                                    <div class="tourCard__image ratio ratio-28:20">
                                        <img src="{{ $coverUrl }}" alt="{{ $alt }}"
                                            title="{{ $title }}" data-caption="{{ $caption }}"
                                            data-description="{{ $desc }}" class="img-ratio rounded-12"
                                            loading="lazy" width="560" height="400">
                                    </div>

                                    <button class="tourCard__favorite js-favorite-btn" data-id="{{ $tour->id }}"
                                        data-type="tour" aria-label="Add {{ $tour->title }} to favorites">
                                        <i class="icon-heart"></i>
                                    </button>

                                    @if ($tour->bestseller_flag)
                                        <div class="tourCard__bestseller popularBadge">
                                            <i class="icon-fire"></i> Popular
                                        </div>
                                    @endif
                                </div>

                                <div class="tourCard__content px-10 pt-10">
                                    @if (!empty($tour->location?->name))
                                        <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                            <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                            {{ $tour->location->name }}
                                        </div>
                                    @endif

                                    <h3 class="tourCard__title text-16 fw-500 mt-5">
                                        <a href="{{ route('front.tours.show', $tour->slug) }}" class="text-dark-1">
                                            <span>{{ Str::limit($tour->title, 50) }}</span>
                                        </a>
                                    </h3>

                                    <div class="tourCard__rating mt-5">
                                        @if ($reviewsCount > 0)
                                            <div class="d-flex items-center">
                                                <div class="d-flex x-gap-5 pr-10">
                                                    @php
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                    @endphp

                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="icon-star text-10 text-yellow-2"></i>
                                                    @endfor

                                                    @if ($halfStar)
                                                        <i class="icon-star-half text-10 text-yellow-2"></i>
                                                    @endif

                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="icon-star text-10 text-light-2"></i>
                                                    @endfor
                                                </div>

                                                <span class="text-dark-1 text-13">
                                                    {{ number_format($rating, 1) }} ({{ $reviewsCount }})
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-accent-1 text-13 fw-500">New tour</span>
                                        @endif
                                    </div>

                                    <div
                                        class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                        <div class="d-flex items-center">
                                            <i class="icon-clock text-16 mr-5"></i>
                                            {{ $tour->duration }}
                                        </div>

                                        <div>
                                            @if ($tour->base_price > 0)
                                                From
                                                <span class="text-16 fw-500">
                                                    ${{ number_format($tour->base_price, 2) }}
                                                </span>
                                            @else
                                                <span class="text-14 fw-500">Contact for price</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Day Trips Section -->
    @if ($dayTrips->isNotEmpty())
        <section class="layout-pt-xl">
            <div data-anim-wrap class="container">
                <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-center y-gap-10">
                    <div class="col-auto">
                        <h2 class="text-30">Best Morocco Day Trips</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('front.tours.index', ['type' => 'day_trip']) }}"
                            class="buttonArrow d-flex items-center">
                            <span>See all</span>
                            <i class="icon-arrow-top-right text-16 ml-10"></i>
                        </a>
                    </div>
                </div>

                <div data-anim-child="slide-up delay-2" class="relative pt-40 sm:pt-20">
                    <div class="overflow-hidden js-section-slider" data-gap="30"
                        data-slider-cols="xl-4 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider4-prev"
                        data-nav-next="js-slider4-next">

                        <div class="swiper-wrapper">
                            @foreach ($dayTrips as $tour)
                                @php
                                    $cover = $tour->getFirstMedia('cover');
                                    $coverUrl = $cover?->getUrl() ?? null;

                                    if (!$coverUrl) {
                                        $galleryImage = $tour->getFirstMedia('gallery');
                                        $coverUrl =
                                            $galleryImage?->getUrl() ?? asset('assets/images/default-image.png');
                                        $media = $galleryImage;
                                    } else {
                                        $media = $cover;
                                    }

                                    $alt = $media?->getCustomProperty('alt') ?? $tour->title;
                                    $title = $media?->getCustomProperty('title') ?? $tour->title;
                                    $caption = $media?->getCustomProperty('caption') ?? '';
                                    $desc = $media?->getCustomProperty('description') ?? '';
                                @endphp

                                <div class="swiper-slide">
                                    <div class="tourCard -type-1 d-block bg-white relative">
                                        <div class="tourCard__header">
                                            <div class="tourCard__image ratio ratio-28:20">
                                                <img src="{{ $coverUrl }}" alt="{{ $alt }}"
                                                    title="{{ $title }}" data-caption="{{ $caption }}"
                                                    data-description="{{ $desc }}" class="img-ratio rounded-12"
                                                    loading="lazy" width="560" height="400">
                                            </div>

                                            <button class="tourCard__favorite js-favorite-btn swiper-no-swiping"
                                                data-id="{{ $tour->id }}" data-type="tour"
                                                aria-label="Add {{ $tour->title }} to favorites"
                                                style="position: absolute; bottom: -17px; right: 10px; width: 35px; height: 35px; border-radius: 50%; background: white; display: flex; justify-content: center; align-items: center; box-shadow: 0px 10px 40px rgba(0,0,0,0.05); z-index: 2;">
                                                <i class="icon-heart"></i>
                                            </button>

                                            @if ($tour->bestseller_flag)
                                                <div class="tourCard__bestseller popularBadge">
                                                    <i class="icon-fire"></i> Popular
                                                </div>
                                            @endif
                                        </div>

                                        <div class="tourCard__content pt-10">
                                            @if (!empty($tour->location?->name))
                                                <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                                    <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                                    {{ $tour->location->name }}
                                                </div>
                                            @endif

                                            <h3 class="tourCard__title text-16 fw-500 mt-5">
                                                <a href="{{ route('front.tours.show', $tour->slug) }}"
                                                    class="text-dark-1">
                                                    <span>{{ Str::limit($tour->title, 50) }}</span>
                                                </a>
                                            </h3>

                                            @php
                                                $reviewsCount = (int) ($tour->reviews_count ?? 0);
                                                $rating = $tour->avg_rating ?? 0;
                                            @endphp

                                            <div class="tourCard__rating mt-5">
                                                @if ($reviewsCount > 0)
                                                    <div class="d-flex items-center">
                                                        <div class="d-flex x-gap-5 pr-10">
                                                            @php
                                                                $fullStars = floor($rating);
                                                                $halfStar = $rating - $fullStars >= 0.5;
                                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                            @endphp

                                                            @for ($i = 0; $i < $fullStars; $i++)
                                                                <i class="icon-star text-10 text-yellow-2"></i>
                                                            @endfor

                                                            @if ($halfStar)
                                                                <i class="icon-star-half text-10 text-yellow-2"></i>
                                                            @endif

                                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                                <i class="icon-star text-10 text-light-2"></i>
                                                            @endfor
                                                        </div>

                                                        <span class="text-dark-1 text-13">
                                                            {{ number_format($rating, 1) }} ({{ $reviewsCount }})
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-accent-1 text-13 fw-500">New tour</span>
                                                @endif
                                            </div>

                                            <div
                                                class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                                <div class="d-flex items-center">
                                                    <i class="icon-clock text-16 mr-5"></i>
                                                    {{ $tour->duration }}
                                                </div>

                                                <div>
                                                    @if ($tour->base_price > 0)
                                                        From
                                                        <span class="text-16 fw-500">
                                                            ${{ number_format($tour->base_price, 2) }}
                                                        </span>
                                                    @else
                                                        <span class="text-14 fw-500">Contact for price</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="navAbsolute">
                        <button class="navAbsolute__button bg-white js-slider4-prev" aria-label="Previous slide">
                            <i class="icon-arrow-left text-14"></i>
                        </button>
                        <button class="navAbsolute__button bg-white js-slider4-next" aria-label="Next slide">
                            <i class="icon-arrow-right text-14"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Stats / Counters Section -->
    <section class="layout-pt-xl">
        <div data-anim-wrap class="container">
            <div class="row y-gap-30">

                <div class="col-lg-3 col-6">
                    <div data-anim-child="fade delay-2" class="text-center">
                        <img src="{{ asset('assets/img/icons/3/1.svg') }}" alt="Destinations icon">

                        <h3 class="text-40 md:text-30 lh-14 fw-700 mt-30 md:mt-15">12</h3>
                        <p class="lh-15">Total Destinations</p>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div data-anim-child="fade delay-3" class="text-center">
                        <img src="{{ asset('assets/img/icons/3/2.svg') }}" alt="Tours icon">

                        <h3 class="text-40 md:text-30 lh-14 fw-700 mt-30 md:mt-15">45</h3>
                        <p class="lh-15">Amazing Tours</p>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div data-anim-child="fade delay-4" class="text-center">
                        <img src="{{ asset('assets/img/icons/3/3.svg') }}" alt="Happy customers icon">

                        <h3 class="text-40 md:text-30 lh-14 fw-700 mt-30 md:mt-15">350</h3>
                        <p class="lh-15">Happy Customers</p>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div data-anim-child="fade delay-5" class="text-center">
                        <img src="{{ asset('assets/img/icons/3/4.svg') }}" alt="Years of experience icon">

                        <h3 class="text-40 md:text-30 lh-14 fw-700 mt-30 md:mt-15">10</h3>
                        <p class="lh-15">Years of Experience</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Activities Section -->
    @if ($activities->isNotEmpty())
        <section class="layout-pt-xl">
            <div data-anim-wrap class="container">
                <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-center">
                    <div class="col-auto">
                        <h2 class="text-30">Marrakech Activities</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('front.activities.index') }}" class="buttonArrow d-flex items-center">
                            <span>See all</span>
                            <i class="icon-arrow-top-right text-16 ml-10"></i>
                        </a>
                    </div>
                </div>

                <div data-anim-child="slide-up delay-2" class="relative pt-40 sm:pt-20">
                    <div class="overflow-hidden js-section-slider" data-gap="30"
                        data-slider-cols="xl-4 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider2-prev"
                        data-nav-next="js-slider2-next">

                        <div class="swiper-wrapper">
                            @foreach ($activities as $activity)
                                @php
                                    $cover = $activity->getFirstMedia('cover');
                                    $coverUrl = $cover?->getUrl() ?? null;

                                    if (!$coverUrl) {
                                        $galleryImage = $activity->getFirstMedia('gallery');
                                        $coverUrl =
                                            $galleryImage?->getUrl() ?? asset('assets/images/default-image.png');
                                        $media = $galleryImage;
                                    } else {
                                        $media = $cover;
                                    }

                                    $alt = $media?->getCustomProperty('alt') ?? $activity->title;
                                    $title = $media?->getCustomProperty('title') ?? $activity->title;
                                    $caption = $media?->getCustomProperty('caption') ?? '';
                                    $desc = $media?->getCustomProperty('description') ?? '';
                                @endphp

                                <div class="swiper-slide">
                                    <div class="tourCard -type-1 d-block bg-white relative">
                                        <div class="tourCard__header">
                                            <div class="tourCard__image ratio ratio-28:20">
                                                <img src="{{ $coverUrl }}" alt="{{ $alt }}"
                                                    title="{{ $title }}" loading="lazy" width="560"
                                                    height="400" data-caption="{{ $caption }}"
                                                    data-description="{{ $desc }}" class="img-ratio rounded-12">
                                            </div>

                                            <button class="tourCard__favorite js-favorite-btn swiper-no-swiping"
                                                data-id="{{ $activity->id }}" data-type="activity"
                                                aria-label="Add {{ $activity->title }} to favorites"
                                                style="position: absolute; bottom: -17px; right: 10px; width: 35px; height: 35px; border-radius: 50%; background: white; display: flex; justify-content: center; align-items: center; box-shadow: 0px 10px 40px rgba(0,0,0,0.05); z-index: 2;">
                                                <i class="icon-heart"></i>
                                            </button>

                                            @if ($activity->bestseller_flag)
                                                <div class="tourCard__bestseller popularBadge">
                                                    <i class="icon-fire"></i> Popular
                                                </div>
                                            @endif
                                        </div>

                                        <div class="tourCard__content pt-10">
                                            @if (!empty($activity->location?->name))
                                                <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                                    <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                                    {{ $activity->location->name }}
                                                </div>
                                            @endif

                                            <h3 class="tourCard__title text-16 fw-500 mt-5">
                                                <a href="{{ route('front.activities.show', $activity->slug) }}"
                                                    class="text-dark-1">
                                                    <span>{{ Str::limit($activity->title, 50) }}</span>
                                                </a>
                                            </h3>

                                            @php
                                                $reviewsCount = (int) ($activity->reviews_count ?? 0);
                                                $rating = $activity->avg_rating ?? 0;
                                            @endphp

                                            <div class="tourCard__rating mt-5">
                                                @if ($reviewsCount > 0)
                                                    <div class="d-flex items-center">
                                                        <div class="d-flex x-gap-5 pr-10">
                                                            @php
                                                                $fullStars = floor($rating);
                                                                $halfStar = $rating - $fullStars >= 0.5;
                                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                            @endphp

                                                            @for ($i = 0; $i < $fullStars; $i++)
                                                                <i class="icon-star text-10 text-yellow-2"></i>
                                                            @endfor

                                                            @if ($halfStar)
                                                                <i class="icon-star-half text-10 text-yellow-2"></i>
                                                            @endif

                                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                                <i class="icon-star text-10 text-light-2"></i>
                                                            @endfor
                                                        </div>

                                                        <span class="text-dark-1 text-13">
                                                            {{ number_format($rating, 1) }} ({{ $reviewsCount }})
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-accent-1 text-13 fw-500">New activity</span>
                                                @endif
                                            </div>

                                            <div
                                                class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                                <div class="d-flex items-center">
                                                    <i class="icon-clock text-16 mr-5"></i>
                                                    {{ $activity->duration }}
                                                </div>

                                                <div>
                                                    @if ($activity->base_price > 0)
                                                        From
                                                        <span class="text-16 fw-500">
                                                            ${{ number_format($activity->base_price, 2) }}
                                                        </span>
                                                    @else
                                                        <span class="text-14 fw-500">Contact for price</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="navAbsolute">
                        <button class="navAbsolute__button bg-white js-slider2-prev" aria-label="Previous slide">
                            <i class="icon-arrow-left text-14"></i>
                        </button>
                        <button class="navAbsolute__button bg-white js-slider2-next" aria-label="Next slide">
                            <i class="icon-arrow-right text-14"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Trekking Section -->
    @if ($trekking->isNotEmpty())
        <section class="layout-pt-xl">
            <div data-anim-wrap class="container">
                <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-center">
                    <div class="col-auto">
                        <h2 class="text-30">Morocco Treking Tours</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('front.trekking.index') }}" class="buttonArrow d-flex items-center">
                            <span>See all</span>
                            <i class="icon-arrow-top-right text-16 ml-10"></i>
                        </a>
                    </div>
                </div>

                <div data-anim-child="slide-up delay-2" class="relative pt-40 sm:pt-20">
                    <div class="overflow-hidden js-section-slider" data-gap="30"
                        data-slider-cols="xl-4 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider3-prev"
                        data-nav-next="js-slider3-next">

                        <div class="swiper-wrapper">
                            @foreach ($trekking as $trek)
                                @php
                                    $cover = $trek->getFirstMedia('cover');
                                    $coverUrl = $cover?->getUrl() ?? null;

                                    if (!$coverUrl) {
                                        $galleryImage = $trek->getFirstMedia('gallery');
                                        $coverUrl =
                                            $galleryImage?->getUrl() ?? asset('assets/images/default-image.png');
                                    } else {
                                        $media = $cover;
                                    }

                                    $alt = $media?->getCustomProperty('alt') ?? $trek->title;
                                    $title = $media?->getCustomProperty('title') ?? $trek->title;
                                    $caption = $media?->getCustomProperty('caption') ?? '';
                                    $desc = $media?->getCustomProperty('description') ?? '';
                                @endphp

                                <div class="swiper-slide">
                                    <div class="tourCard -type-1 d-block bg-white relative">
                                        <div class="tourCard__header">
                                            <div class="tourCard__image ratio ratio-28:20">
                                                <img src="{{ $coverUrl }}" alt="{{ $alt }}"
                                                    title="{{ $title }}" loading="lazy" width="560"
                                                    height="400" data-caption="{{ $caption }}"
                                                    data-description="{{ $desc }}" class="img-ratio rounded-12">
                                            </div>

                                            <button class="tourCard__favorite js-favorite-btn swiper-no-swiping"
                                                data-id="{{ $trek->id }}" data-type="trekking"
                                                aria-label="Add {{ $trek->title }} to favorites"
                                                style="position: absolute; bottom: -17px; right: 10px; width: 35px; height: 35px; border-radius: 50%; background: white; display: flex; justify-content: center; align-items: center; box-shadow: 0px 10px 40px rgba(0,0,0,0.05); z-index: 2;">
                                                <i class="icon-heart"></i>
                                            </button>

                                            @if ($trek->bestseller_flag)
                                                <div class="tourCard__bestseller popularBadge">
                                                    <i class="icon-fire"></i> Popular
                                                </div>
                                            @endif
                                        </div>

                                        <div class="tourCard__content pt-10">
                                            @if (!empty($trek->location?->name))
                                                <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                                    <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                                    {{ $trek->location->name }}
                                                </div>
                                            @endif

                                            <h3 class="tourCard__title text-16 fw-500 mt-5">
                                                <a href="{{ route('front.trekking.show', $trek->slug) }}"
                                                    class="text-dark-1">
                                                    <span>{{ Str::limit($trek->title, 50) }}</span>
                                                </a>
                                            </h3>

                                            @php
                                                $reviewsCount = (int) ($trek->reviews_count ?? 0);
                                                $rating = $trek->avg_rating ?? 0;
                                            @endphp

                                            <div class="tourCard__rating mt-5">
                                                @if ($reviewsCount > 0)
                                                    <div class="d-flex items-center">
                                                        <div class="d-flex x-gap-5 pr-10">
                                                            @php
                                                                $fullStars = floor($rating);
                                                                $halfStar = $rating - $fullStars >= 0.5;
                                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                            @endphp

                                                            @for ($i = 0; $i < $fullStars; $i++)
                                                                <i class="icon-star text-10 text-yellow-2"></i>
                                                            @endfor

                                                            @if ($halfStar)
                                                                <i class="icon-star-half text-10 text-yellow-2"></i>
                                                            @endif

                                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                                <i class="icon-star text-10 text-light-2"></i>
                                                            @endfor
                                                        </div>

                                                        <span class="text-dark-1 text-13">
                                                            {{ number_format($rating, 1) }} ({{ $reviewsCount }})
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-accent-1 text-13 fw-500">New trek</span>
                                                @endif
                                            </div>

                                            <div
                                                class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                                <div class="d-flex items-center">
                                                    <i class="icon-clock text-16 mr-5"></i>
                                                    {{ $trek->duration }}
                                                </div>
                                                <div>
                                                    @if ($trek->base_price > 0)
                                                        From
                                                        <span class="text-16 fw-500">
                                                            ${{ number_format($trek->base_price, 2) }}
                                                        </span>
                                                    @else
                                                        <span class="text-14 fw-500">Contact for price</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="navAbsolute">
                        <button class="navAbsolute__button bg-white js-slider3-prev" aria-label="Previous slide">
                            <i class="icon-arrow-left text-14"></i>
                        </button>
                        <button class="navAbsolute__button bg-white js-slider3-next" aria-label="Next slide">
                            <i class="icon-arrow-right text-14"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <style>
        .swiper-slide {
            pointer-events: auto;
        }
    </style>
    <script></script>
    <style>
        /* Fix "Why Choose" horizontal swipe on mobile — make columns
               real scroll items so users can switch to the cards on the right. */
        @media (max-width: 575px) {
            #whyChoose .mobile-css-slider {
                -webkit-overflow-scrolling: touch;
                scroll-padding-left: 15px;
                padding-bottom: 10px;
            }

            #whyChoose .mobile-css-slider>[class*="col-"] {
                flex: 0 0 auto;
                width: 280px;
                max-width: 280px;
            }
        }
    </style>
    <section id="whyChoose" class="layout-pt-xl" style="margin-bottom: 120px">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row">
                <div class="col-auto">
                    <h2 class="text-30 md:text-24">Why Choose Authentic Morocco Adventures</h2>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="row md:x-gap-20 pt-40 sm:pt-20 mobile-css-slider -w-280">

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="{{ asset('assets/img/icons/1/ticket.svg') }}"
                                alt="Ticket icon representing flexible booking" loading="lazy" width="64"
                                height="64">
                        </div>
                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Ultimate Flexibility</h3>
                        <p class="featureIcon__text mt-10">
                            Explore Morocco your way. With Authentic Morocco Adventures, enjoy free cancellation and payment
                            options
                            to suit your plans and budget.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="{{ asset('assets/img/icons/1/hot-air-balloon.svg') }}"
                                alt="Hot air balloon icon representing memorable experiences" loading="lazy"
                                width="64" height="64">
                        </div>
                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Memorable Experiences</h3>
                        <p class="featureIcon__text mt-10">
                            Discover unique tours, cultural treasures, and hidden gems across Morocco that you’ll love
                            sharing with friends.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="{{ asset('assets/img/icons/1/diamond.svg') }}"
                                alt="Diamond icon representing quality service" loading="lazy" width="64"
                                height="64">
                        </div>
                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Quality at Our Core</h3>
                        <p class="featureIcon__text mt-10">
                            Authentic Morocco Adventures is committed to quality. Exceptional guides, authentic experiences,
                            and
                            glowing reviews ensure your trip exceeds expectations.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="{{ asset('assets/img/icons/1/medal.svg') }}"
                                alt="Medal icon representing award-winning support" loading="lazy" width="64"
                                height="64">
                        </div>
                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Award-Winning Support</h3>
                        <p class="featureIcon__text mt-10">
                            New plans? New adventures? No problem. Our Authentic Morocco Adventures team is here to support
                            your
                            Morocco journey 24/7.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="bg-accent-1-05">
        <section data-anim-wrap class="relative layout-pt-xl layout-pb-xl">
            <div data-anim-child="slide-up delay-1" class="sectionBg md:d-none">
                <img src="{{ asset('assets/img/testimonials/1/1.png') }}"
                    alt="Background graphic featuring Authentic Morocco Adventures theme" loading="lazy"
                    role="presentation">
            </div>

            <div data-anim-child="slide-up delay-3" class="container">
                <div class="row justify-center text-center">
                    <div class="col-auto">
                        <h2 class="text-30 md:text-24">
                            What Travelers Say About Authentic Morocco Adventures
                        </h2>
                    </div>
                </div>

                <div class="row justify-center pt-60 md:pt-20">
                    <div class="col-xl-6 col-md-8 col-sm-10">
                        <div class="overflow-hidden js-section-slider" data-slider-cols="xl-1 lg-1 md-1 sm-1 base-1"
                            data-pagination="js-testimonials-pagination">
                            <div class="swiper-wrapper">

                                {{-- Review 1 --}}
                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="{{ asset('assets/images/reviews/testimonial-matteo-italy_isnet-general-use.webp') }}"
                                                alt="Matteo Rossi, traveler from Italy enjoying Morocco desert tour with camel rides and sunset views"
                                                loading="eager">
                                            <div class="testimonials__icon" aria-hidden="true">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="visually-hidden">
                                            Matteo Rossi loved the desert tour with camel rides and sunset views in Morocco.
                                        </div>
                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">
                                            Incredible Desert Tour!
                                        </div>
                                        <div class="text-20 fw-500 mt-20">
                                            My family and I booked a desert adventure with Authentic Morocco Adventures.
                                            Riding
                                            camels through the dunes at sunset was magical. Truly the best way to see
                                            Morocco!
                                        </div>
                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Matteo Rossi</div>
                                            <div class="lh-16">Traveler from Italy</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Review 2 --}}
                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="{{ asset('assets/images/reviews/testimonial-carlos-brazil_bria.webp') }}"
                                                alt="Carlos Almeida, traveler from Brazil discovering Moroccan culture with Authentic Morocco Adventures"
                                                loading="eager">
                                            <div class="testimonials__icon" aria-hidden="true">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="visually-hidden">
                                            Carlos Almeida discovered authentic Moroccan culture and hidden gems with
                                            Authentic Morocco Adventures.
                                        </div>
                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">
                                            Authentic Moroccan Culture
                                        </div>
                                        <div class="text-20 fw-500 mt-20">
                                            Thanks to Authentic Morocco Adventures, I discovered hidden spots in Marrakech.
                                            The
                                            guides were knowledgeable and passionate about sharing Moroccan culture.
                                        </div>
                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Carlos Almeida</div>
                                            <div class="lh-16">Traveler from Brazil</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Review 3 --}}
                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="{{ asset('assets/images/reviews/testimonial-james-usa_bria.webp') }}"
                                                alt="James Peterson, traveler from USA praising seamless Morocco trip planning with Authentic Morocco Adventures"
                                                loading="eager">
                                            <div class="testimonials__icon" aria-hidden="true">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="visually-hidden">
                                            James Peterson appreciated the easy planning and professional arrangements for
                                            his Morocco trip.
                                        </div>
                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">
                                            Seamless Planning
                                        </div>
                                        <div class="text-20 fw-500 mt-20">
                                            I was worried about planning my trip to Morocco, but Authentic Morocco
                                            Adventures made it
                                            so easy. From transport to accommodations, everything was perfectly arranged.
                                        </div>
                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">James Peterson</div>
                                            <div class="lh-16">Traveler from USA</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Review 4 --}}
                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="{{ asset('assets/images/reviews/testimonial-aysha-morocco_bria.webp') }}"
                                                alt="Aysha El Fassi, Moroccan traveler exploring hidden gems with Authentic Morocco Adventures"
                                                loading="eager">
                                            <div class="testimonials__icon" aria-hidden="true">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="visually-hidden">
                                            Aysha El Fassi explored hidden gems and local secrets in Morocco with
                                            Authentic Morocco Adventures.
                                        </div>
                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">
                                            Hidden Gems
                                        </div>
                                        <div class="text-20 fw-500 mt-20">
                                            I’ve visited Morocco before, but Authentic Morocco Adventures showed me places
                                            I’d never
                                            seen. A truly authentic experience that felt personalized and unique.
                                        </div>
                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Aysha El Fassi</div>
                                            <div class="lh-16">Traveler from Morocco</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Review 5 --}}
                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="{{ asset('assets/images/reviews/testimonial-anastasia-russia_bria.webp') }}"
                                                alt="Anastasia Ivanova, traveler from Russia sharing a professional and safe experience with Authentic Morocco Adventures"
                                                loading="eager">
                                            <div class="testimonials__icon" aria-hidden="true">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="visually-hidden">
                                            Anastasia Ivanova shared a professional and safe experience traveling with
                                            Authentic Morocco Adventures.
                                        </div>
                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">
                                            Professional Team
                                        </div>
                                        <div class="text-20 fw-500 mt-20">
                                            The team at Authentic Morocco Adventures was so professional and friendly. They
                                            answered
                                            all my questions and made me feel safe and excited about exploring Morocco.
                                        </div>
                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Anastasia Ivanova</div>
                                            <div class="lh-16">Traveler from Russia</div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="pagination -type-1 justify-center pt-60 md:pt-40 js-testimonials-pagination">
                                <div class="pagination__button"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @if ($posts->isNotEmpty())
        <section class="layout-pt-xl layout-pb-xl">
            <div data-anim-wrap class="container">
                <div data-anim-child="slide-up" class="row justify-between items-end y-gap-10">
                    <div class="col-auto">
                        <h2 class="text-30 md:text-24">Travel Articles</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('blog.index') }}" class="buttonArrow d-flex items-center">
                            <span>See all</span>
                            <i class="icon-arrow-top-right text-16 ml-10"></i>
                        </a>
                    </div>
                </div>

                <div data-anim-child="slide-up delay-2" class="row y-gap-30 pt-40 sm:pt-20">
                    @foreach ($posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('blog.show', $post->slug) }}" class="blogCard -type-1">
                                <div class="blogCard__image ratio ratio-41:30">
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                                        loading="lazy" width="410" height="300" class="img-ratio rounded-12">
                                    @if ($post->category)
                                        <div class="blogCard__badge">
                                            {{ $post->category->name }}
                                        </div>
                                    @endif
                                </div>
                                <div class="blogCard__content mt-30">
                                    <div class="blogCard__info text-14">
                                        <div class="lh-13">
                                            {{ $post->published_at ? $post->published_at->format('F d, Y') : 'N/A' }}
                                        </div>
                                        <div class="blogCard__line"></div>
                                        <div class="lh-13">
                                            By {{ $post->author->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <h3 class="blogCard__title text-18 fw-500 mt-10">
                                        {{ $post->title }}
                                    </h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


@endsection

/**
 * Auto-scroll for the homepage card carousels.
 *
 * Advances a fixed set of `.js-section-slider` instances one slide every 3s.
 * We deliberately drive only three sliders (Best Morocco Day Trips, Marrakech
 * Activities, Morocco Trekking Tours) — identified by their unique
 * `data-nav-next` class — so other sliders (e.g. testimonials) are left alone.
 *
 * Non-destructive: we never create or destroy a Swiper. We read the existing
 * instance the theme already created (`el.swiper`, the same handle slider-fix.js
 * uses) and call slideNext()/slideTo(0). Each slider gets its OWN independent
 * interval, so one pausing/looping never affects the others.
 */
(function () {
    'use strict';

    var INTERVAL_MS = 3000;

    // Auto-scroll is desktop/tablet only. On phones we leave the carousels
    // static (the user asked for the old, non-auto behavior on mobile). 768px
    // matches the theme's mobile boundary (its 767px media queries / sm cols).
    var MOBILE_MAX_WIDTH = 767;

    function isMobile() {
        return window.innerWidth <= MOBILE_MAX_WIDTH;
    }

    // Only these sliders auto-scroll. Match by the data-nav-next value that the
    // Blade markup sets on each target section.
    var TARGET_NAV_NEXT = [
        'js-slider4-next', // Home: Best Morocco Day Trips
        'js-slider2-next', // Home: Marrakech Activities
        'js-slider3-next', // Home: Morocco Trekking Tours
        'js-slider5-next', // Home: Morocco Destinations (locations)
        'js-slider1-next'  // Detail pages: "You might also like..." (tours/activities/trekking)
    ];

    function isTargetSlider(el) {
        return TARGET_NAV_NEXT.indexOf(el.getAttribute('data-nav-next')) !== -1;
    }

    function advance(el) {
        var sw = el.swiper;
        if (!sw || typeof sw.slideNext !== 'function') return;

        // Loop back to the first slide once the last one is reached, otherwise
        // step forward by one. (These sliders are created without loop:true, so
        // we handle the wrap-around ourselves.)
        if (sw.isEnd) {
            sw.slideTo(0);
        } else {
            sw.slideNext();
        }
    }

    function startAutoScroll(el) {
        if (el.__autoScrollTimer) return; // already running
        if (isMobile()) return;           // no auto-scroll on phones
        el.__autoScrollTimer = setInterval(function () {
            // Skip a tick while the tab is hidden or the user is hovering, so
            // the slider doesn't jump the moment they look back at it.
            if (document.hidden || el.__autoScrollPaused) return;
            advance(el);
        }, INTERVAL_MS);
    }

    function stopAutoScroll(el) {
        if (!el.__autoScrollTimer) return;
        clearInterval(el.__autoScrollTimer);
        el.__autoScrollTimer = null;
    }

    function pause(el) { el.__autoScrollPaused = true; }
    function resume(el) { el.__autoScrollPaused = false; }

    function bindPauseHandlers(el) {
        if (el.__autoScrollBound) return;
        el.__autoScrollBound = true;

        // Pause while the pointer is over the slider (desktop) or the user is
        // actively touching it (mobile); resume when they leave / lift off.
        el.addEventListener('mouseenter', function () { pause(el); });
        el.addEventListener('mouseleave', function () { resume(el); });
        el.addEventListener('touchstart', function () { pause(el); }, { passive: true });
        el.addEventListener('touchend', function () { resume(el); }, { passive: true });
    }

    function initSliders() {
        var sliders = document.querySelectorAll('.js-section-slider');
        sliders.forEach(function (el) {
            if (!isTargetSlider(el)) return;
            if (!el.swiper) return; // Swiper not ready yet; a later tick will catch it.
            bindPauseHandlers(el);
            startAutoScroll(el);
        });
    }

    function run() {
        // The theme creates these Swipers on window.load. Poll a few times so we
        // attach as soon as each instance exists, without racing the theme.
        var tries = 0;
        var poll = setInterval(function () {
            initSliders();
            tries++;

            // Stop polling once every target slider has a running timer, or
            // after a reasonable number of attempts.
            var pending = Array.prototype.filter.call(
                document.querySelectorAll('.js-section-slider'),
                function (el) { return isTargetSlider(el) && !el.__autoScrollTimer; }
            );
            if (pending.length === 0 || tries >= 20) clearInterval(poll);
        }, 250);
    }

    window.addEventListener('load', run);
})();

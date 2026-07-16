(function () {
    'use strict';

    var INTERVAL_MS = 3000;

    // Auto-scroll now runs on ALL screen sizes, including phones. (It used to be
    // disabled on mobile; the guard has been removed so the carousels advance on
    // mobile too.)

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

            // Stop polling once every target slider has a running timer (or we
            // give up after enough tries).
            var pending = Array.prototype.filter.call(
                document.querySelectorAll('.js-section-slider'),
                function (el) { return isTargetSlider(el) && !el.__autoScrollTimer; }
            );
            if (pending.length === 0 || tries >= 20) clearInterval(poll);
        }, 250);
    }

    // On resize, (re)initialise any target slider that isn't running yet —
    // e.g. after an orientation change once Swiper has (re)built. Debounced so a
    // drag-resize doesn't thrash. Auto-scroll runs on every screen size now.
    function handleResize() {
        initSliders();
    }

    var resizeT;
    window.addEventListener('resize', function () {
        clearTimeout(resizeT);
        resizeT = setTimeout(handleResize, 200);
    });

    window.addEventListener('load', run);
})();

/**
 * Resync theme Swiper sliders after init.
 * The theme's `.js-section-slider` instances sometimes settle with a stale
 * wrapper transform: slide sizes are computed before the layout (images,
 * fonts) settles, so the per-slide translate is wrong. Navigating left looks
 * fine, but navigating right clips the left half of the incoming cards.
 *
 * Fix: fully recompute sizes/slides, then re-snap to the *current* active
 * index (not just index 0) so the wrapper transform matches the slide widths.
 */
(function () {
    'use strict';

    function resyncSliders() {
        var sliders = document.querySelectorAll('.js-section-slider');
        sliders.forEach(function (el) {
            var sw = el.swiper;
            if (!sw || typeof sw.update !== 'function') return;

            // Force a full geometry recompute (sizes first, then slide widths).
            if (typeof sw.updateSize === 'function') sw.updateSize();
            if (typeof sw.updateSlides === 'function') sw.updateSlides();
            sw.update();

            // Re-snap to wherever we currently are so the wrapper transform
            // lines up with the freshly measured slide widths. Snapping to the
            // current index (instead of always 0) keeps the fix working after
            // the user has navigated right.
            var idx = sw.activeIndex || 0;
            sw.slideTo(idx, 0);
        });
    }

    function bindNavRecheck() {
        // After the first navigation the clipping shows up, so re-measure once
        // the slider settles on its new slide. Guard with a flag so each
        // instance is only wired up a single time.
        document.querySelectorAll('.js-section-slider').forEach(function (el) {
            var sw = el.swiper;
            if (!sw || el.__navRecheckBound) return;
            el.__navRecheckBound = true;
            sw.on('slideChangeTransitionEnd', function () {
                if (typeof sw.updateSlides === 'function') sw.updateSlides();
                sw.update();
                sw.slideTo(sw.activeIndex || 0, 0);
            });
        });
    }

    function run() {
        // Sliders are created on window.load by the theme; give them a tick.
        setTimeout(resyncSliders, 50);
        setTimeout(function () {
            resyncSliders();
            bindNavRecheck();
        }, 400);
    }

    window.addEventListener('load', run);
    window.addEventListener('resize', function () {
        clearTimeout(window.__sliderFixT);
        window.__sliderFixT = setTimeout(resyncSliders, 200);
    });
    window.addEventListener('orientationchange', function () {
        setTimeout(resyncSliders, 300);
    });
})();

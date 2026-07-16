(function () {
    'use strict';

    // ------------------------------------------------------------------
    // Mobile-only auto-scroller for the homepage "Best Morocco Tours" row
    // (the CSS ".mobile-css-slider" that opts in with ".js-mobile-autoscroll").
    // It is NOT a Swiper, so it is handled here, kept separate from
    // slider-autoscroll.js (which drives the .js-section-slider Swipers).
    //
    // MOBILE (<= 575px): the theme turns the row into a horizontal
    //   overflow-x carousel. We auto-advance it to the next card every
    //   STEP_MS and loop back to the first at the end (like the other
    //   carousels).
    //
    // DESKTOP (> 575px): nothing happens. The static grid is left exactly
    //   as the theme renders it (no auto-scroll, no layout change).
    // ------------------------------------------------------------------

    var MOBILE_MAX_WIDTH = 575;
    var STEP_MS = 2000;          // advance every 2 seconds

    function prefersReducedMotion() {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    function isMobile() {
        return window.matchMedia('(max-width: ' + MOBILE_MAX_WIDTH + 'px)').matches;
    }

    function Carousel(root) {
        this.root = root;
        this.cols = Array.prototype.slice.call(root.children); // the tour columns
        this.timer = null;
        this.paused = false;
        this.running = false;
        this.bindHandlers();
    }

    Carousel.prototype.bindHandlers = function () {
        var self = this;
        // Pause on interaction so we don't fight the user's swipe.
        this.root.addEventListener('touchstart', function () { self.paused = true; }, { passive: true });
        this.root.addEventListener('touchend', function () {
            clearTimeout(self._resumeT);
            self._resumeT = setTimeout(function () { self.paused = false; }, 1500);
        }, { passive: true });
        this.root.addEventListener('mouseenter', function () { self.paused = true; });
        this.root.addEventListener('mouseleave', function () { self.paused = false; });
    };

    Carousel.prototype.start = function () {
        if (this.running) return;
        this.running = true;
        this.root.style.scrollBehavior = 'smooth';

        var self = this;
        this.timer = setInterval(function () {
            if (self.paused || document.hidden) return;

            var el = self.root;
            var maxScroll = el.scrollWidth - el.clientWidth;
            if (maxScroll <= 4) return;

            // Step by roughly one card width; loop back at the end.
            var card = self.cols[0];
            var step = card ? card.getBoundingClientRect().width + 20 : el.clientWidth * 0.85;

            if (el.scrollLeft >= maxScroll - 4) {
                el.scrollLeft = 0;
            } else {
                el.scrollLeft = Math.min(el.scrollLeft + step, maxScroll);
            }
        }, STEP_MS);
    };

    Carousel.prototype.stop = function () {
        this.running = false;
        if (this.timer) { clearInterval(this.timer); this.timer = null; }
        this.root.style.scrollBehavior = '';
    };

    Carousel.prototype.apply = function () {
        if (isMobile() && !prefersReducedMotion()) {
            this.start();
        } else {
            this.stop();
        }
    };

    // ------------------------------------------------------------------

    var carousels = [];

    function build() {
        var roots = document.querySelectorAll('.mobile-css-slider.js-mobile-autoscroll');
        carousels = Array.prototype.map.call(roots, function (root) {
            return new Carousel(root);
        });
    }

    function applyAll() {
        carousels.forEach(function (c) { c.apply(); });
    }

    var resizeT;
    window.addEventListener('resize', function () {
        clearTimeout(resizeT);
        resizeT = setTimeout(applyAll, 200);
    });

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) applyAll();
    });

    window.addEventListener('load', function () {
        build();
        applyAll();
    });

    if (document.readyState === 'complete') {
        build();
        applyAll();
    }
})();

document.addEventListener("DOMContentLoaded", () => {
    // Hero search dropdown logic
    document.querySelectorAll('[data-x="location"] .js-select-control-button').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();
            const slug = button.dataset.slug;
            const name = button.dataset.name;
            document.querySelector('[data-x-click="location"] .js-select-control-chosen').textContent = name;
            document.querySelector('#location_slug').value = slug;
        });
    });

    document.querySelectorAll('[data-x="tour-type"] .js-select-control-button').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();
            const slug = button.dataset.slug;
            const name = button.dataset.name;
            document.querySelector('[data-x-click="tour-type"] .js-select-control-chosen').textContent = name;
            document.querySelector('#tour_category_slug').value = slug;
        });
    });

    document.getElementById('applyCustomGroupSize')?.addEventListener('click', () => {
        const min = document.getElementById('customMinGroupSize').value;
        const max = document.getElementById('customMaxGroupSize').value;
        let label = 'Any size';
        if (min || max) {
            label = `${min || '1'} - ${max || '+'}`;
        }
        document.querySelector('[data-x-click="group_size"] .js-select-control-chosen').textContent = label;
        document.querySelector('#group_size_min').value = min;
        document.querySelector('#group_size_max').value = max;
    });

    // Swiper initialization for section sliders
    document.querySelectorAll(".js-section-slider").forEach(sliderEl => {
        const slider = new Swiper(sliderEl, {
            slidesPerView: 1,
            spaceBetween: parseInt(sliderEl.dataset.gap) || 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: sliderEl.closest(".relative").querySelector("[data-nav-next]"),
                prevEl: sliderEl.closest(".relative").querySelector("[data-nav-prev]"),
            },
            breakpoints: {
                576: { slidesPerView: parseInt(sliderEl.dataset.sliderCols?.split(" ")[4]) || 1 },
                768: { slidesPerView: parseInt(sliderEl.dataset.sliderCols?.split(" ")[3]) || 2 },
                992: { slidesPerView: parseInt(sliderEl.dataset.sliderCols?.split(" ")[2]) || 3 },
                1200: { slidesPerView: parseInt(sliderEl.dataset.sliderCols?.split(" ")[1]) || 3 },
                1400: { slidesPerView: parseInt(sliderEl.dataset.sliderCols?.split(" ")[0]) || 4 },
            },
            // Prevent default swipe-on-click behavior
            noSwiping: true,
            noSwipingClass: 'swiper-slide',
            touchStartPreventDefault: false,
            simulateTouch: true,
            allowTouchMove: false, // Disable touch swiping, rely on autoplay and navigation
            on: {
                init() {
                    // Custom click handler for images
                    sliderEl.querySelectorAll('.tourCard__image').forEach(image => {
                        image.addEventListener('click', e => {
                            e.preventDefault();
                            e.stopPropagation();
                            slider.slideNext();
                        });
                    });

                    // Ensure favorite buttons trigger jQuery events
                    sliderEl.querySelectorAll('.js-favorite-btn').forEach(btn => {
                        btn.addEventListener('click', e => {
                            e.preventDefault();
                            e.stopPropagation();
                            if (typeof jQuery !== 'undefined') {
                                jQuery(btn).trigger('click.favorite');
                            }
                        });
                    });

                    // Ensure title links work
                    sliderEl.querySelectorAll('.tourCard__title a').forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            e.stopPropagation();
                            window.location.href = link.href;
                        });
                    });
                },
                click(event) {
                    // Prevent Swiper from handling clicks on non-image elements
                    if (!event.target.closest('.tourCard__image')) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                },
                // After every slide change (incl. autoplay auto-advance) the
                // loop transform can settle stale and clip the left half of
                // the incoming card. Re-measure and re-snap so it stays clean.
                slideChangeTransitionEnd() {
                    if (typeof slider.updateSlides === 'function') slider.updateSlides();
                    slider.update();
                    slider.slideToLoop(slider.realIndex || 0, 0, false);
                }
            }
        });
    });

    // Testimonials slider
    document.querySelectorAll(".js-testimonials-slider").forEach(sliderEl => {
        const slider = new Swiper(sliderEl, {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: sliderEl.querySelector('.' + sliderEl.dataset.pagination),
                clickable: true,
            },
        });
    });
});
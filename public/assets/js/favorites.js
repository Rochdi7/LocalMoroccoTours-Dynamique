/**
 * Wishlist / Favorites — localStorage based.
 * - Persists across refresh.
 * - Heart shows active state when saved.
 * - Click toggles save/remove.
 * - Floating wishlist button shows live count and opens a slide-in panel.
 * Works with or without jQuery (uses vanilla DOM).
 */
(function () {
    'use strict';

    var STORAGE_KEY = 'amaWishlist';

    /* ---------- storage ---------- */
    function readWishlist() {
        try {
            var raw = localStorage.getItem(STORAGE_KEY);
            var data = raw ? JSON.parse(raw) : [];
            return Array.isArray(data) ? data : [];
        } catch (e) {
            return [];
        }
    }

    function writeWishlist(items) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
        } catch (e) {}
    }

    function keyOf(type, id) {
        return String(type) + ':' + String(id);
    }

    function findIndex(items, type, id) {
        var k = keyOf(type, id);
        for (var i = 0; i < items.length; i++) {
            if (keyOf(items[i].type, items[i].id) === k) return i;
        }
        return -1;
    }

    /* ---------- read item metadata from the DOM at click time ---------- */
    function extractItem(btn) {
        var id = btn.getAttribute('data-id');
        var type = btn.getAttribute('data-type') || 'tour';

        var title = btn.getAttribute('data-title') || '';
        var image = btn.getAttribute('data-image') || '';
        var url = btn.getAttribute('data-url') || '';

        // Try to read from the enclosing card if attributes are missing.
        var card = btn.closest('.tourCard, .col-12, .col-lg-4, article');
        if (card) {
            if (!title) {
                var t = card.querySelector('.tourCard__title, h3, h2');
                if (t) title = t.textContent.trim();
            }
            if (!image) {
                var img = card.querySelector('img');
                if (img) image = img.getAttribute('src') || '';
            }
            if (!url) {
                var link = card.querySelector('a[href]');
                if (link) url = link.getAttribute('href') || '';
            }
        }

        // Detail pages: fall back to page-level data.
        if (!title) {
            var h1 = document.querySelector('h1');
            title = h1 ? h1.textContent.trim() : 'Saved item';
        }
        if (!image) {
            var og = document.querySelector('meta[property="og:image"]');
            image = og ? og.getAttribute('content') : '';
        }
        if (!url || url === '#') {
            url = window.location.pathname;
        }

        return { id: id, type: type, title: title, image: image, url: url };
    }

    /* ---------- UI sync ---------- */
    function markButtons() {
        var items = readWishlist();
        var btns = document.querySelectorAll('.js-favorite-btn');
        btns.forEach(function (btn) {
            var id = btn.getAttribute('data-id');
            var type = btn.getAttribute('data-type') || 'tour';
            if (findIndex(items, type, id) > -1) {
                btn.classList.add('is-favorited');
            } else {
                btn.classList.remove('is-favorited');
            }
        });
    }

    function updateCount() {
        var count = readWishlist().length;
        var badge = document.querySelector('.js-wishlist-count');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    function renderPanel() {
        var list = document.querySelector('.js-wishlist-list');
        var empty = document.querySelector('.js-wishlist-empty');
        if (!list) return;

        var items = readWishlist();
        list.innerHTML = '';

        if (empty) empty.style.display = items.length ? 'none' : 'block';

        items.forEach(function (item) {
            var a = document.createElement('a');
            a.href = item.url || '#';
            a.className = 'wishlistItem';

            var img = document.createElement('img');
            img.src = item.image || '';
            img.alt = item.title || '';
            img.className = 'wishlistItem__img';
            img.loading = 'lazy';

            var info = document.createElement('div');
            info.className = 'wishlistItem__info';
            var ttl = document.createElement('div');
            ttl.className = 'wishlistItem__title';
            ttl.textContent = item.title || 'Saved item';
            var typ = document.createElement('div');
            typ.className = 'wishlistItem__type';
            typ.textContent = (item.type || '').charAt(0).toUpperCase() + (item.type || '').slice(1);
            info.appendChild(ttl);
            info.appendChild(typ);

            var rm = document.createElement('button');
            rm.type = 'button';
            rm.className = 'wishlistItem__remove js-wishlist-remove';
            rm.setAttribute('data-id', item.id);
            rm.setAttribute('data-type', item.type);
            rm.setAttribute('aria-label', 'Remove from wishlist');
            rm.innerHTML = '&times;';

            a.appendChild(img);
            a.appendChild(info);
            a.appendChild(rm);
            list.appendChild(a);
        });
    }

    function syncAll() {
        markButtons();
        updateCount();
        renderPanel();
    }

    /* ---------- actions ---------- */
    function toggle(btn) {
        var items = readWishlist();
        var id = btn.getAttribute('data-id');
        var type = btn.getAttribute('data-type') || 'tour';
        var idx = findIndex(items, type, id);

        if (idx > -1) {
            items.splice(idx, 1);
            btn.classList.remove('is-favorited');
        } else {
            items.push(extractItem(btn));
            btn.classList.add('is-favorited');
        }
        writeWishlist(items);
        syncAll();
    }

    function removeItem(type, id) {
        var items = readWishlist();
        var idx = findIndex(items, type, id);
        if (idx > -1) {
            items.splice(idx, 1);
            writeWishlist(items);
            syncAll();
        }
    }

    /* ---------- panel open/close ---------- */
    function openPanel() {
        var panel = document.querySelector('.js-wishlist-panel');
        if (panel) {
            panel.classList.add('is-open');
            document.documentElement.classList.add('wishlist-open');
        }
    }

    function closePanel() {
        var panel = document.querySelector('.js-wishlist-panel');
        if (panel) {
            panel.classList.remove('is-open');
            document.documentElement.classList.remove('wishlist-open');
        }
    }

    /* ---------- events ---------- */
    var touchStartX = 0, touchStartY = 0, touchTracking = false, suppressNextClick = false;

    function target(e) {
        var t = e.target;
        // e.target can be a text node in some browsers.
        if (t && t.nodeType === 3) t = t.parentElement;
        return t;
    }

    // Route an activation (click or tap) to the right action.
    // Returns true if it handled a wishlist control.
    function handleActivate(t) {
        if (!t || !t.closest) return false;

        var favBtn = t.closest('.js-favorite-btn');
        if (favBtn) { toggle(favBtn); return true; }

        if (t.closest('.js-wishlist-toggle')) { openPanel(); return true; }

        var rm = t.closest('.js-wishlist-remove');
        if (rm) { removeItem(rm.getAttribute('data-type'), rm.getAttribute('data-id')); return true; }

        if (t.closest('.js-wishlist-close') || (t.classList && t.classList.contains('js-wishlist-overlay'))) {
            closePanel();
            return true;
        }
        return false;
    }

    // Capture phase so we run BEFORE Swiper / theme handlers that may stop
    // propagation on slides. Handles cards rendered inside sliders too.
    document.addEventListener('click', function (e) {
        // A tap on touch devices was already handled by touchend below.
        if (suppressNextClick) { suppressNextClick = false; e.preventDefault(); e.stopPropagation(); return; }
        var t = target(e);
        if (handleActivate(t)) {
            e.preventDefault();
            e.stopPropagation();
        }
    }, true);

    // Swiper is stopped from swiping on these controls via the
    // `swiper-no-swiping` class. But Swiper may still call preventDefault on
    // touchstart for the slide, which suppresses the synthesized click — so on
    // touch devices we drive the action from touchstart/touchend directly and
    // detect a tap (no significant finger movement).
    document.addEventListener('touchstart', function (e) {
        var t = target(e);
        if (t && t.closest && t.closest('.js-favorite-btn, .js-wishlist-toggle, .js-wishlist-remove, .js-wishlist-close')) {
            touchTracking = true;
            var pt = e.touches && e.touches[0];
            touchStartX = pt ? pt.clientX : 0;
            touchStartY = pt ? pt.clientY : 0;
        } else {
            touchTracking = false;
        }
    }, { capture: true, passive: true });

    document.addEventListener('touchend', function (e) {
        if (!touchTracking) return;
        touchTracking = false;
        var pt = e.changedTouches && e.changedTouches[0];
        var dx = pt ? Math.abs(pt.clientX - touchStartX) : 0;
        var dy = pt ? Math.abs(pt.clientY - touchStartY) : 0;
        if (dx > 12 || dy > 12) return; // it was a swipe/scroll, not a tap

        var t = target(e);
        if (handleActivate(t)) {
            suppressNextClick = true; // stop the ghost click that follows
            e.preventDefault();
            e.stopPropagation();
        }
    }, { capture: true, passive: false });

    // Keep multiple tabs in sync.
    window.addEventListener('storage', function (e) {
        if (e.key === STORAGE_KEY) syncAll();
    });

    document.addEventListener('DOMContentLoaded', syncAll);
    // In case DOMContentLoaded already fired (deferred script).
    if (document.readyState !== 'loading') syncAll();
})();

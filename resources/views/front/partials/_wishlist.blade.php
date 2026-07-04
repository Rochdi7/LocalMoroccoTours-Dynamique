{{-- Floating wishlist button + slide-in panel (localStorage powered via favorites.js) --}}
<button type="button" class="wishlist-float js-wishlist-toggle" aria-label="Open your wishlist">
    <i class="icon-heart" aria-hidden="true"></i>
    <span class="wishlist-float__count js-wishlist-count" aria-hidden="true">0</span>
</button>

<div class="wishlist-panel js-wishlist-panel" role="dialog" aria-label="Your wishlist" aria-modal="true">
    <div class="wishlist-panel__overlay js-wishlist-overlay" aria-hidden="true"></div>
    <div class="wishlist-panel__content">
        <div class="wishlist-panel__header">
            <div class="wishlist-panel__title">My Wishlist</div>
            <button type="button" class="wishlist-panel__close js-wishlist-close" aria-label="Close wishlist">
                <i class="icon-cross" aria-hidden="true"></i>
            </button>
        </div>

        <div class="wishlist-panel__body">
            <p class="wishlist-panel__empty js-wishlist-empty">
                Your wishlist is empty. Tap the heart on any tour, activity or trek to save it here.
            </p>
            <div class="wishlist-panel__list js-wishlist-list"></div>
        </div>
    </div>
</div>

<style>
    .wishlist-float {
        position: fixed;
        right: 30px;
        bottom: 100px; /* sits above the WhatsApp button */
        z-index: 101;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: none;
        background: #044cb8;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        cursor: pointer;
        transition: transform 0.25s ease, background 0.25s ease;
    }

    .wishlist-float:hover {
        transform: translateY(-3px);
        background: #033a8f;
    }

    .wishlist-float i {
        font-size: 24px;
        line-height: 1;
    }

    .wishlist-float__count {
        position: absolute;
        top: -4px;
        right: -4px;
        min-width: 22px;
        height: 22px;
        padding: 0 6px;
        border-radius: 11px;
        background: #ffc421;
        color: #1a1a1a;
        font-size: 12px;
        font-weight: 700;
        display: none;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    /* Panel */
    .wishlist-panel {
        position: fixed;
        inset: 0;
        z-index: 2000;
        visibility: hidden;
        pointer-events: none;
    }

    .wishlist-panel.is-open {
        visibility: visible;
        pointer-events: auto;
    }

    .wishlist-panel__overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .wishlist-panel.is-open .wishlist-panel__overlay {
        opacity: 1;
    }

    .wishlist-panel__content {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 380px;
        max-width: 90vw;
        background: #fff;
        box-shadow: -10px 0 40px rgba(0, 0, 0, 0.12);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .wishlist-panel.is-open .wishlist-panel__content {
        transform: translateX(0);
    }

    .wishlist-panel__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #eee;
    }

    .wishlist-panel__title {
        font-size: 20px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .wishlist-panel__close {
        border: none;
        background: #f4f4f4;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .wishlist-panel__body {
        padding: 16px 20px 30px;
        overflow-y: auto;
        flex: 1;
    }

    .wishlist-panel__empty {
        color: #777;
        font-size: 15px;
        margin: 20px 4px;
        line-height: 1.5;
    }

    .wishlistItem {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: 12px;
        text-decoration: none;
        transition: background 0.2s ease;
        position: relative;
    }

    .wishlistItem:hover {
        background: #f6f8fc;
    }

    .wishlistItem__img {
        width: 64px;
        height: 64px;
        border-radius: 10px;
        object-fit: cover;
        flex: 0 0 auto;
        background: #eee;
    }

    .wishlistItem__info {
        flex: 1;
        min-width: 0;
    }

    .wishlistItem__title {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .wishlistItem__type {
        font-size: 12px;
        color: #044cb8;
        margin-top: 3px;
    }

    .wishlistItem__remove {
        border: none;
        background: transparent;
        color: #bbb;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        flex: 0 0 auto;
        padding: 0 4px;
    }

    .wishlistItem__remove:hover {
        color: #ff4d4d;
    }

    /* Active heart state (shared) — only the heart turns red, never a block bg.
       Overrides the legacy bundled rule that painted the whole button red. */
    .js-favorite-btn.is-favorited {
        background-color: transparent;
        color: inherit;
    }

    .js-favorite-btn.is-favorited i,
    .js-favorite-btn.is-favorited .icon-heart {
        color: #ff4d4d;
    }

    /* Circular card heart keeps its white pill background when active. */
    .tourCard__favorite.js-favorite-btn.is-favorited {
        background: #fff;
    }

    @media (max-width: 767px) {
        .wishlist-float {
            right: 20px;
            bottom: 84px;
            width: 54px;
            height: 54px;
        }

        .wishlist-float i {
            font-size: 21px;
        }
    }
</style>

<style>
    /* ---- Mega-menu: nested (3-level) hover flyouts.
       Level 1 = desktopNav__item (Morocco Tours / Day Trips).
       Level 2 = .megaFlyout with city groups.
       Level 3 = .megaFlyout__sub with the tours in that city.
       Colors reuse the theme (accent-1 / accent-2). Shared by both headers. ---- */
    .header .desktopNav__item>a {
        white-space: nowrap;
    }

    .megaNav__item {
        position: relative;
    }

    /* Panel look copied from the Viatours theme's .desktopNavSubnav__content:
       12px radius, white bg, soft shadow, 1px border, 260px min-width. We keep the
       brand accent for hover (blue) instead of the theme demo's orange. */
    .megaFlyout {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 220px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0px 10px 40px 0px rgba(0, 0, 0, .08);
        border: 1px solid var(--border, #E7E6E6);
        padding: 10px 12px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(8px);
        transition: opacity .2s ease, transform .2s ease;
        z-index: 300;
        list-style: none;
        margin: 0;
    }

    .megaNav__item:hover>.megaFlyout {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .megaFlyout__li {
        position: relative;
    }

    .megaFlyout__li>a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 13px;
        line-height: 1.35;
        color: #14110d !important;
        white-space: nowrap;
        transition: background .15s ease, color .15s ease;
    }

    .megaFlyout__li>a:hover {
        background: rgba(4, 76, 184, .07);
        color: var(--color-accent-2, #044cb8) !important;
    }

    /* Chevron-right on parents, matching the theme's icon-chevron-right marker */
    .megaFlyout__li.-has-sub>a::after {
        content: "";
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-right: 1.5px solid currentColor;
        border-bottom: 1.5px solid currentColor;
        transform: rotate(-45deg);
        opacity: .6;
    }

    /* Third level opens to the right of its city group (theme: top:0; left:100%) */
    .megaFlyout__sub {
        position: absolute;
        top: -14px;
        left: 100%;
        min-width: 240px;
        max-width: 300px;
        max-height: 78vh;
        overflow-y: auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0px 10px 40px 0px rgba(0, 0, 0, .08);
        border: 1px solid var(--border, #E7E6E6);
        padding: 12px 14px;
        opacity: 0;
        visibility: hidden;
        transform: translateX(8px);
        transition: opacity .2s ease, transform .2s ease;
        z-index: 310;
        list-style: none;
        margin: 0;
    }

    /* Long tour titles wrap inside the capped sub-panel instead of stretching
       it wide across the screen. */
    .megaFlyout__sub .megaFlyout__li>a {
        white-space: normal;
    }

    .megaFlyout__li:hover>.megaFlyout__sub {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }

    .megaFlyout__head {
        padding: 4px 12px 8px;
        font-size: 11px;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #8a8f88;
        font-weight: 600;
    }

    /* A single-column flat flyout (Activities / Atlas & Toubkal) */
    .megaFlyout.-flat {
        max-height: 80vh;
        overflow-y: auto;
    }

    /* ---- Native theme dropdown (About) — match the flyout look above so both
       dropdown systems read identically. The theme's own .desktopNavSubnav rules
       already handle position/animation; we only align the panel + item styling
       (radius, shadow, border, hover, spacing) to the megaFlyout above. ---- */
    .header .desktopNav .desktopNavSubnav__content {
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0px 10px 40px 0px rgba(0, 0, 0, .08);
        border: 1px solid var(--border, #E7E6E6);
        min-width: 260px;
        padding: 16px 20px;
    }

    .header .desktopNav .desktopNavSubnav__content>*+* {
        padding-top: 0;
    }

    .header .desktopNav .desktopNavSubnav__item>a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 15px;
        color: #14110d;
        white-space: nowrap;
        transition: background .15s ease, color .15s ease;
    }

    .header .desktopNav .desktopNavSubnav__item>a:hover {
        background: rgba(4, 76, 184, .07);
        color: var(--color-accent-2, #044cb8);
    }

    /* If a city flyout would overflow the right edge, the last
       nav items flip their 3rd level to the left. */
    .megaNav__item.-flip .megaFlyout__sub {
        left: auto;
        right: 100%;
        transform: translateX(-8px);
    }

    .megaNav__item.-flip .megaFlyout__li:hover>.megaFlyout__sub {
        transform: translateX(0);
    }

    /* ---- Mobile menu: keep the footer visible ----
       Our menu has more nav items than the theme demo, so on shorter screens the
       nav list + footer exceed the viewport and the footer (phone + socials) gets
       cut off at the bottom. The theme's .menu__content is height:100% with no
       scroll, so overflow just spills off-screen. Make the nav list flex-grow and
       scroll internally, and keep the footer pinned so it never gets clipped. */
    .menu__container {
        overflow: hidden;
    }

    .menu__content {
        flex: 1 1 auto;
        height: auto;
        min-height: 0;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .menu__footer {
        flex-shrink: 0;
    }

    /* ---- Mobile menu footer social icons ----
       The footer mixes the theme's icomoon icons (Facebook/Twitter/Instagram/
       LinkedIn) with Bootstrap Icons (Pinterest/YouTube). Bootstrap's .bi inherit
       the body's tall line-height (1.875), which vertically misaligns them next to
       the icomoon icons. Force line-height:1 and equal sizing so all six icons in
       the row line up and read at the same weight/size. Shared by both headers. */
    .menu__footer .d-flex i {
        font-size: 15px;
        line-height: 1;
        display: inline-flex;
        align-items: center;
    }

    .menu__footer .d-flex i::before {
        line-height: 1;
    }
</style>

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

    .megaFlyout {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 260px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(20, 17, 13, .14);
        padding: 10px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(8px);
        transition: opacity .18s ease, transform .18s ease;
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
        gap: 12px;
        padding: 9px 14px;
        border-radius: 6px;
        font-size: 14px;
        color: #14110d !important;
        white-space: nowrap;
        transition: background .15s ease, color .15s ease;
    }

    .megaFlyout__li>a:hover {
        background: rgba(4, 76, 184, .07);
        color: var(--color-accent-2, #044cb8) !important;
    }

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

    /* Third level opens to the right of its city group */
    .megaFlyout__sub {
        position: absolute;
        top: -10px;
        left: 100%;
        min-width: 300px;
        max-height: 78vh;
        overflow-y: auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(20, 17, 13, .14);
        padding: 10px;
        opacity: 0;
        visibility: hidden;
        transform: translateX(8px);
        transition: opacity .18s ease, transform .18s ease;
        z-index: 310;
        list-style: none;
        margin: 0;
    }

    .megaFlyout__li:hover>.megaFlyout__sub {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }

    .megaFlyout__head {
        padding: 6px 14px 4px;
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
</style>

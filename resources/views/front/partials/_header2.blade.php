<header class="header -type-8 js-header">
    <div data-anim="fade delay-3" class="header__container container">
        <div class="headerMobile__left">
            <button class="header__menuBtn js-menu-button">
                <i class="icon-main-menu"></i>
            </button>
        </div>

        <div class="header__left">
            <div class="header__logo">
                <a href="{{ route('home') }}" class="header__logo">
                    <img id="header-logo" src="/assets/images/logo/ama_logo_dark.png"
                        data-default="/assets/images/logo/ama_logo_dark.png"
                        data-white="/assets/images/logo/ama_logo_white.png" alt="Authentic Morocco Adventures Logo">
                </a>

                <div class="xl:d-none ml-30">
                    <div class="desktopNav">
                        @include('front.partials._nav_desktop_items')
                    </div>
                </div>
            </div>
        </div>

        <div class="headerMobile__right">
            <a href="https://www.tripadvisor.com/Attraction_Review-g293734-d6868602-Reviews-Authentic_Morocco_Adventures-Marrakech_Marrakech_Safi.html"
                target="_blank" class="tripadvisor-icon-mobile d-flex items-center">
                <img src="/assets/images/icon/tripdavisor.svg" alt="Tripadvisor">
            </a>
        </div>

        <style>
            /* Responsive size for mobile devices */
            @media (max-width: 768px) {
                .tripadvisor-icon-mobile img {
                    width: 30px;
                    height: 30px;
                }
            }
        </style>

        <div class="header__right">
            <a href="https://www.tripadvisor.com/Attraction_Review-g293734-d6868602-Reviews-Authentic_Morocco_Adventures-Marrakech_Marrakech_Safi.html"
                target="_blank" class="button -sm rounded-200 ml-30 d-flex items-center">
                <img src="/assets/images/icon/tripdavisor.svg" alt="Tripadvisor"
                    style="width: 18px; height: 18px; margin-right: 5px;">
                Tripadvisor
            </a>
        </div>

    </div>
</header>

<!-- MOBILE MENU -->
<div class="menu js-menu">
    <div class="menu__overlay js-menu-button"></div>

    <div class="menu__container">
        <div class="menu__header">
            <h4>Main Menu</h4>
            <button class="js-menu-button"><i class="icon-cross text-10"></i></button>
        </div>

        <div class="menu__content">
            <ul class="menuNav js-navList">
                <li class="menuNav__item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                @include('front.partials._nav_mobile_items')
            </ul>
        </div>

        <div class="menu__footer">
            <i class="icon-headphone text-50"></i>
            <div class="text-20 lh-12 fw-500 mt-20">
                <div>Speak to our expert at</div>
                <div class="text-accent-1">+212 666 107 312</div>
            </div>
            <div class="d-flex items-center x-gap-10 pt-30">
                <div>
                    <a href="https://web.facebook.com/authenticmoroccoadventures/" target="_blank" class="d-block"
                        aria-label="Facebook">
                        <i class="icon-facebook"></i>
                    </a>
                </div>

                <div>
                    <a href="https://x.com/AMADMCmor" target="_blank" class="d-block" aria-label="Twitter (X)">
                        <i class="icon-twitter"></i>
                    </a>
                </div>

                <div>
                    <a href="https://www.instagram.com/authenticmoroccoadventures/" target="_blank" class="d-block"
                        aria-label="Instagram">
                        <i class="icon-instagram"></i>
                    </a>
                </div>

                <div>
                    <a href="https://www.linkedin.com/in/authentic-moroccoadventures-99812a420/" target="_blank"
                        class="d-block" aria-label="LinkedIn">
                        <i class="icon-linkedin"></i>
                    </a>
                </div>

                <div>
                    <a href="https://fr.pinterest.com/amoroccoadventures/" target="_blank" class="d-block text-dark"
                        aria-label="Pinterest">
                        <i class="bi bi-pinterest"></i>
                    </a>
                </div>

                <div>
                    <a href="https://www.youtube.com/@AuthenticMoroccoAdventures" target="_blank"
                        class="d-block text-dark" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Initial header styles */
    .header {
        background-color: #fff;
        color: #111;
    }

    .header a,
    .header i,
    .header .button {
        color: #111;
    }

    .header .button {
        border-color: #111;
        background-color: transparent;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        font-size: 14px;
        font-weight: 500;
    }

    .header .button i {
        margin-right: 5px;
    }

    /* Header after scroll */
    .header.-is-sticky {
        background-color: #0b1444;
        /* your dark color */
        color: #fff;
    }

    .header.-is-sticky a,
    .header.-is-sticky i,
    .header.-is-sticky .button {
        color: #fff;
    }

    .header.-is-sticky .button {
        border-color: #fff;
        background-color: transparent;
    }



    /* Force links in dropdown to stay black even in sticky header */
    .desktopNavSubnav a {
        color: #111 !important;
    }

    /* Logo sizing (image is a wide wordmark lockup, constrain by height) */
    #header-logo {
        height: 48px;
        width: auto;
        max-width: 220px;
        object-fit: contain;
    }

    @media (max-width: 767px) {
        #header-logo {
            height: 36px;
            max-width: 160px;
        }
    }

    /* Keep nav labels on one line so the wider logo doesn't force a wrap */
    .header .desktopNav__item>a {
        white-space: nowrap;
    }

    .header .desktopNav>* {
        padding: 8px 14px;
    }
</style>

@include('front.partials._nav_megamenu_styles')

<script>
    document.addEventListener("scroll", function() {
        let header = document.querySelector(".header");
        let logo = document.getElementById("header-logo");

        if (window.scrollY > 20) {
            header.classList.add("-is-sticky");
            if (logo) {
                logo.src = logo.getAttribute("data-white");
            }
        } else {
            header.classList.remove("-is-sticky");
            if (logo) {
                logo.src = logo.getAttribute("data-default");
            }
        }
    });
</script>

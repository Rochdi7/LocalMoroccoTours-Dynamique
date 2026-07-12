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
                        <div class="desktopNav__item">
                            <a href="{{ route('front.tours.index') }}">Tours</a>
                        </div>
                        <div class="desktopNav__item">
                            <a href="{{ route('front.tours.index', ['type' => 'day_trip']) }}">Day Trips</a>
                        </div>


                        <div class="desktopNav__item">
                            <a href="{{ route('front.activities.index') }}">Activities</a>
                        </div>
                        <div class="desktopNav__item">
                            <a href="{{ route('front.trekking.index') }}">Trekking</a>
                        </div>
                        <div class="desktopNav__item">
                            <a href="{{ route('blog.index') }}">Blog</a>
                        </div>
                        <div class="desktopNav__item">
                            <a href="{{ route('front.contact') }}">Contact</a>
                        </div>

                        <!-- Help & Info dropdown - DESKTOP -->
                        <div class="desktopNav__item">
                            <a href="#">
                                Help & Info
                                <i class="icon-chevron-down"></i>
                            </a>
                            <div class="desktopNavSubnav">
                                <div class="desktopNavSubnav__content">
                                    <div class="desktopNavSubnav__item">
                                        <a href="{{ route('front.about') }}">About</a>
                                    </div>
                                    <div class="desktopNavSubnav__item">
                                        <a href="{{ route('front.help-center') }}">Help Center</a>
                                    </div>
                                    <div class="desktopNavSubnav__item">
                                        <a href="{{ route('front.terms') }}">Terms & Conditions</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Help & Info dropdown -->
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
                    <a href="{{ route('front.tours.index') }}">Tours</a>
                </li>
                <li class="menuNav__item">
                    <a href="{{ route('front.tours.index', ['type' => 'day_trip']) }}">Day Trips</a>
                </li>

                <li class="menuNav__item">
                    <a href="{{ route('front.activities.index') }}">Activities</a>
                </li>
                <li class="menuNav__item">
                    <a href="{{ route('front.trekking.index') }}">Trekking</a>
                </li>
                <li class="menuNav__item">
                    <a href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="menuNav__item">
                    <a href="{{ route('front.contact') }}">Contact</a>
                </li>

                <!-- Help & Info dropdown - MOBILE -->
                <li class="menuNav__item -has-submenu js-has-submenu">
                    <a>
                        Help & Info
                        <i class="icon-chevron-right"></i>
                    </a>
                    <ul class="submenu">
                        <li class="submenu__item js-nav-list-back">
                            <a>Back</a>
                        </li>
                        <li class="submenu__item">
                            <a href="{{ route('front.about') }}">About</a>
                        </li>
                        <li class="submenu__item">
                            <a href="{{ route('front.help-center') }}">Help Center</a>
                        </li>
                        <li class="submenu__item">
                            <a href="{{ route('front.terms') }}">Terms & Conditions</a>
                        </li>
                    </ul>
                </li>
                <!-- End Help & Info dropdown -->
            </ul>
        </div>

        <div class="menu__footer">
            <i class="icon-headphone text-50"></i>
            <div class="text-20 lh-12 fw-500 mt-20">
                <div>Speak to our expert at</div>
                <div class="text-accent-1">+212 666-107312</div>
            </div>
            <div class="d-flex items-center x-gap-10 pt-30">
                <div><a class="d-block"><i class="icon-facebook"></i></a></div>
                <div><a class="d-block"><i class="icon-twitter"></i></a></div>
                <div><a class="d-block"><i class="icon-instagram"></i></a></div>
                <div><a class="d-block"><i class="icon-linkedin"></i></a></div>
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

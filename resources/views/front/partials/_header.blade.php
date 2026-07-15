{{-- Mobile-only top contact bar (phone + email). Hidden on desktop (≥768px). --}}
<div class="mobileTopBar">
    <a href="tel:+212666107312" class="mobileTopBar__item" aria-label="Call us">
        <i class="bi bi-telephone-fill"></i>
        <span>+212 666 107 312</span>
    </a>
    <a href="mailto:authenticmoroccoadventures@gmail.com" class="mobileTopBar__item" aria-label="Email us">
        <i class="bi bi-envelope-fill"></i>
        <span>authenticmoroccoadventures@gmail.com</span>
    </a>
</div>

<style>
    .mobileTopBar {
        display: none;
    }

    @media (max-width: 767px) {
        .mobileTopBar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: nowrap;
            gap: 12px;
            background: var(--color-accent-2, #05073C);
            color: #fff;
            padding: 7px 10px;
            font-size: 11px;
            line-height: 1.2;
            /* Fixed at the very top; the header (also fixed) is pushed down below
               it so both stay pinned while scrolling and never overlap. */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1001;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .mobileTopBar__item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #fff !important;
            white-space: nowrap;
            min-width: 0;
        }

        .mobileTopBar__item i {
            flex-shrink: 0;
        }

        .mobileTopBar__item span {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Extra-narrow phones: shrink a touch more so both items stay on one line. */
        @media (max-width: 360px) {
            .mobileTopBar {
                font-size: 10px;
                gap: 8px;
            }
        }

        .mobileTopBar__item i {
            font-size: 12px;
            color: var(--color-accent-1, #C49539);
        }

        /* Push the fixed header down so it sits below the top contact bar. */
        .header.-type-8 {
            top: var(--mobileTopBarH, 38px);
        }
    }
</style>

<script>
    // Keep the fixed header positioned exactly below the mobile top bar, whatever
    // its measured height (it can wrap on very narrow phones). Runs on mobile only.
    (function () {
        var bar = document.querySelector('.mobileTopBar');
        if (!bar) return;
        function sync() {
            var h = window.innerWidth <= 767 ? bar.offsetHeight : 0;
            document.documentElement.style.setProperty('--mobileTopBarH', h + 'px');
        }
        sync();
        window.addEventListener('resize', sync);
        window.addEventListener('load', sync);
    })();
</script>

<header class="header -type-8 js-header">
    <div data-anim="fade delay-3" class="header__container container">
        <div class="headerMobile__left">
            <button class="header__menuBtn js-menu-button">
                <i class="icon-main-menu text-white"></i>
            </button>
        </div>

        <div class="header__left">
            <div class="header__logo">
                <a href="{{ route('home') }}" class="header__logo">
                    <img src="/assets/images/logo/ama_logo_white.png" alt="Authentic Morocco Adventures Logo"
                        class="header__logoImg">
                </a>

                <style>
                    .header__logoImg {
                        height: 48px;
                        width: auto;
                        max-width: 220px;
                        object-fit: contain;
                    }

                    @media (max-width: 767px) {
                        .header__logoImg {
                            height: 36px;
                            max-width: 160px;
                        }

                        /* The header is transparent over the hero by default, which
                           makes the white logo/menu icon lose contrast depending on
                           which hero slide is behind them. On mobile there's no
                           scroll-triggered ".-is-sticky" background yet (user hasn't
                           scrolled), so give the bar a permanent solid dark-blue
                           background instead of relying on the hero image. */
                        .header.-type-8 {
                            background: var(--color-dark-1);
                        }
                    }

                    .header.-type-8 .desktopNav__item>a {
                        white-space: nowrap;
                    }
                </style>

                <div class="xl:d-none ml-30">
                    <div class="desktopNav -light -hover-light">
                        @include('front.partials._nav_desktop_items')
                    </div>
                </div>
            </div>
        </div>

        <div class="headerMobile__right">

            <a href="https://www.tripadvisor.com/Attraction_Review-g293734-d6868602-Reviews-Authentic_Morocco_Adventures-Marrakech_Marrakech_Safi.html"
                target="_blank" class="tripadvisor-icon-mobile d-flex items-center ml-20">
                <img src="/assets/images/icon/tripdavisor.svg" alt="Tripadvisor">
            </a>

            <style>
                /* Responsive size for mobile devices */
                @media (max-width: 768px) {
                    .tripadvisor-icon-mobile img {
                        width: 30px;
                        height: 30px;
                    }
                }
            </style>

        </div>

        <div class="header__right">
            <!-- LET'S PLAN button -->
            <a href="#" class="button -sm -outline-white text-white rounded-200 ml-30 px-20 py-8 fs-14"
                style="font-weight: 600;">
                Let's Plan
            </a>

            <!-- Tripadvisor icon with flying hover effect -->
            <a href="https://www.tripadvisor.com/Attraction_Review-g293734-d6868602-Reviews-Authentic_Morocco_Adventures-Marrakech_Marrakech_Safi.html"
                target="_blank" class="ml-20 d-flex items-center tripadvisor-hover">
                <img src="/assets/images/icon/tripdavisor.svg" alt="Tripadvisor">
            </a>
        </div>
        <style>
            .tripadvisor-hover img {
                width: 45px;
                height: 45px;
                transition: transform 0.3s ease-in-out;
            }

            .tripadvisor-hover:hover img {
                animation: fly-flap 1s ease-in-out infinite;
            }

            /* Flying with wing-like flaps */
            @keyframes fly-flap {
                0% {
                    transform: translateY(0) rotate(0deg) scale(1);
                }

                25% {
                    transform: translateY(-5px) rotate(-10deg) scale(1.05);
                }

                50% {
                    transform: translateY(-8px) rotate(10deg) scale(1.1);
                }

                75% {
                    transform: translateY(-5px) rotate(-10deg) scale(1.05);
                }

                100% {
                    transform: translateY(0) rotate(0deg) scale(1);
                }
            }
        </style>


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

@include('front.partials._nav_megamenu_styles')
{{-- <style>
.header .desktopNav__item > a {
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3px 3px;
  text-decoration: none;
  color: #ffffff;
  transition: background-color 0.3s, color 0.3s;
}

.header .desktopNav__item > a::after {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  height: 100%;
  width: calc(100% + 20px);
  border-radius: 50px;
  background-color: rgba(255, 255, 255, 0.1);
  opacity: 0;
  transition: opacity 0.3s;
  z-index: -1;
  pointer-events: none;
}

.header .desktopNav__item > a:hover::after {
  opacity: 1;
}

.header .desktopNav__item > a:hover {
  color: var(--color-accent-1);
}
</style> --}}

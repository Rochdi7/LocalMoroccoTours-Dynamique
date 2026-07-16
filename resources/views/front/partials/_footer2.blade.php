<footer class="footer -type-1">
    <div class="footer__main">
        <div class="footer__bg">
            <img src="{{ asset('assets/img/footer/1/bg.svg') }}" alt="image">
        </div>

        <div class="container">
            <div class="footer__info">
                <div class="row y-gap-20 justify-between">
                    <div class="col-auto">
                        <div class="row y-gap-20 items-center">
                            <div class="col-auto">
                                <i class="icon-headphone text-50"></i>
                            </div>

                            <div class="col-auto">
                                <div class="text-20 fw-500">
                                    Speak to our expert at
                                    <span class="text-accent-1">+212 666 107 312</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tripadvisor Travelers' Choice 2026 award. Light footer: keep the
                             badge art black (noir) as-is — no filter. --}}
                        <div class="mt-20">
                            <img src="{{ asset('assets/images/authentic-morocco-adventures-tripadvisor-travelers-choice-2026-award.webp') }}"
                                alt="Authentic Morocco Adventures — Tripadvisor Travelers' Choice 2026 award winner"
                                title="Authentic Morocco Adventures — Tripadvisor Travelers' Choice 2026"
                                width="300" loading="lazy"
                                data-caption="Authentic Morocco Adventures — Tripadvisor Travelers' Choice 2026 award"
                                data-description="Authentic Morocco Adventures was recognized with the Tripadvisor Travelers' Choice 2026 award for its Morocco tours, activities and trekking experiences."
                                style="width: 300px; max-width: 100%; height: auto;">
                        </div>
                    </div>

                    <div class="col-auto">
                        <style>
                            /* Styles for YouTube and Pinterest only */
                            .footerSocials__icons .bi-youtube,
                            .footerSocials__icons .bi-pinterest {
                                font-size: 1rem;
                                width: 24px;
                                height: 24px;
                                display: inline-flex;
                                justify-content: center;
                                align-items: center;
                            }

                            /* Optional: spacing between icons */
                            .footerSocials__icons {
                                display: flex;
                                gap: 12px;
                                align-items: center;
                            }
                        </style>

                        <div class="footerSocials">
                            <div class="footerSocials__title">
                                Follow Us
                            </div>

                            <div class="footerSocials__icons">
                                <a href="https://web.facebook.com/authenticmoroccoadventures/" target="_blank"
                                    class="icon-facebook"></a>

                                <a href="https://x.com/AMADMCmor" target="_blank" class="icon-twitter"></a>

                                <a href="https://www.instagram.com/authenticmoroccoadventures/" target="_blank"
                                    class="icon-instagram"></a>

                                <a href="https://www.linkedin.com/in/authentic-moroccoadventures-99812a420/" target="_blank"
                                    class="icon-linkedin"></a>

                                <a href="https://fr.pinterest.com/amoroccoadventures/" target="_blank"
                                    class="text-dark">
                                    <i class="bi bi-pinterest"></i>
                                </a>

                                <a href="https://www.youtube.com/@AuthenticMoroccoAdventures"
                                    target="_blank" class="text-dark">
                                    <i class="bi bi-youtube"></i>
                                </a>

                                {{-- Tripadvisor (light footer: keep the brand teal SVG as-is). --}}
                                <a href="https://www.tripadvisor.com/Attraction_Review-g293734-d6868602-Reviews-Authentic_Morocco_Adventures-Marrakech_Marrakech_Safi.html"
                                    target="_blank" rel="noopener" class="d-flex align-items-center" aria-label="Tripadvisor">
                                    <img src="{{ asset('assets/images/icon/tripdavisor.svg') }}" alt="Tripadvisor"
                                        style="width: 20px; height: 20px;">
                                </a>

                            </div>
                        </div>

                        {{-- Trusted by the World's Leading Travel Brands. Light footer: keep the
                             logos in their original dark colour (no inversion). --}}
                        <div class="footer-trusted-brands mt-20">
                            <div class="footer-trusted-brands__title text-accent-1 text-14 fw-500 mb-10">
                                Trusted by the World&rsquo;s Leading Travel Brands
                            </div>
                            <div class="footer-trusted-brands__logos d-flex items-center flex-wrap x-gap-20 y-gap-10">
                                <img src="{{ asset('assets/images/clients/bokun.webp') }}" alt="Bókun" loading="lazy" class="footer-brand-logo">
                                <img src="{{ asset('assets/images/clients/tourhub.png') }}" alt="Tourhub" loading="lazy" class="footer-brand-logo">
                                <img src="{{ asset('assets/images/clients/tourradar.svg') }}" alt="TourRadar" loading="lazy" class="footer-brand-logo">
                                <img src="{{ asset('assets/images/clients/tripadvisor.svg') }}" alt="Tripadvisor" loading="lazy" class="footer-brand-logo">
                                <a href="https://fr.trustpilot.com/review/authenticmoroccoadventures.com" target="_blank" rel="noopener" aria-label="Read our reviews on Trustpilot" class="d-flex align-items-center">
                                    <img src="{{ asset('assets/images/clients/trustpilot-seeklogo.svg') }}" alt="Trustpilot" loading="lazy" class="footer-brand-logo">
                                </a>
                                <img src="{{ asset('assets/images/clients/viator-seeklogo-2.svg') }}" alt="Viator" loading="lazy" class="footer-brand-logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .footer-trusted-brands__logos { max-width: 420px; }
                .footer-brand-logo {
                    height: 26px;
                    width: auto;
                    max-width: 90px;
                    object-fit: contain;
                    vertical-align: middle;
                }
                @media (max-width: 991px) {
                    .footer-trusted-brands__logos { max-width: none; }
                }
            </style>

            <div class="footer__content">
                <div class="row y-gap-40 justify-between">

                    <div class="col-lg-4 col-md-6">
                        <h4 class="text-20 fw-500">Contact</h4>

                        <div class="y-gap-10 mt-20">
                            <span class="d-block">Phone: +212 666 107 312</span>
                            <span class="d-block">WhatsApp: +212 666 107 312</span>
                            <a class="d-block" href="mailto:authenticmoroccoadventures@gmail.com">authenticmoroccoadventures@gmail.com</a>
                        </div>
                    </div>

                    <div class="col-lg-auto col-6">
                        <h4 class="text-20 fw-500">Company</h4>

                        <div class="y-gap-10 mt-20">
                            <a class="d-block fw-500" href="{{ route('front.about') }}">
                                About
                            </a>

                            <a class="d-block fw-500" href="{{ route('blog.index') }}">
                                Blog
                            </a>

                            <a class="d-block fw-500" href="{{ route('front.contact') }}">
                                Contact
                            </a>

                            <a class="d-block fw-500" href="{{ route('front.terms') }}">
                                Terms
                            </a>

                            <a class="d-block fw-500" href="{{ route('front.help-center') }}">
                                Help Center
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-auto col-6">
                        <h4 class="text-20 fw-500">Explore</h4>

                        <div class="y-gap-10 mt-20">
                            <a class="d-block fw-500" href="{{ route('front.tours.index') }}">
                                Tours
                            </a>
                            <a class="d-block fw-500" href="{{ route('front.activities.index') }}">
                                Activities
                            </a>
                            <a class="d-block fw-500" href="{{ route('front.trekking.index') }}">
                                Trekking
                            </a>
                            <a class="d-block fw-500" href="{{ route('front.locations.index') }}">
                                Locations
                            </a>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-20 fw-500">Newsletter</h4>
                        <p class="mt-20">Subscribe to the free newsletter and stay up to date</p>

                        <form class="footer__newsletter" action="{{ route('newsletter.subscribe') }}" method="POST" data-recaptcha-action="newsletter">
                            @csrf
                            <label for="footer2-email" class="visually-hidden">Email address</label>
                            <input type="email" id="footer2-email" name="email" placeholder="Your email address" required>
                            <button type="submit">Send</button>
                        </form>
                        @include('front.partials._recaptcha_notice')
                    </div>

                    @if (session('newsletter_success') || session('newsletter_error'))
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                @if (session('newsletter_success'))
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Subscribed!',
                                        text: @json(session('newsletter_success')),
                                        confirmButtonColor: '#3085d6',
                                    });
                                @endif

                                @if (session('newsletter_error'))
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Something went wrong',
                                        text: @json(session('newsletter_error')),
                                        confirmButtonColor: '#d33',
                                    });
                                @endif
                            });
                        </script>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="footer__bottom">
            <div class="row y-gap-5 justify-between items-center">
                <div class="col-auto">
                    <div>
                        © Copyright Authentic Morocco Adventures {{ date('Y') }} •
                        Developed by
                        <a href="https://codesommet.com/" target="_blank" rel="noopener" class="text-accent-1 fw-500">
                            Code Sommet
                        </a>
                    </div>
                </div>

                <div class="col-auto">
                    <div class="footer__images d-flex items-center x-gap-10">
                        <img src="{{ asset('assets/img/footer/cards/1.png') }}" alt="card">
                        <img src="{{ asset('assets/img/footer/cards/2.png') }}" alt="card">
                        <img src="{{ asset('assets/img/footer/cards/3.png') }}" alt="card">
                        <img src="{{ asset('assets/img/footer/cards/4.png') }}" alt="card">
                        <img src="{{ asset('assets/img/footer/cards/5.png') }}" alt="card">
                        <img src="{{ asset('assets/img/footer/cards/6.png') }}" alt="card">
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>

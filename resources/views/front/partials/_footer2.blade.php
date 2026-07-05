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

                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

                        <form class="footer__newsletter" action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <label for="footer2-email" class="visually-hidden">Email address</label>
                            <input type="email" id="footer2-email" name="email" placeholder="Your email address" required>
                            <button type="submit">Send</button>
                        </form>
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
                        <a href="https://www.facebook.com/CodeSommet/" target="_blank" class="text-accent-1 fw-500">
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

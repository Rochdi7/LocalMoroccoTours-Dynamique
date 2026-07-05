<footer class="footer -type-1 -light bg-accent-2">
    <div class="footer__main">
        <div class="container">
            <div class="footer__info">
                <div class="row y-gap-20 justify-between">
                    <div class="col-auto">
                        <div class="row y-gap-20 items-center">
                            <div class="col-auto">
                                <i class="icon-headphone text-50 text-white" aria-hidden="true"></i>
                            </div>
                            <div class="col-auto">
                                <div class="text-20 fw-500 text-white">
                                    Speak to our expert at
                                    <a href="tel:+212666107312" class="text-white">+212 666 107 312</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="footerSocials">
                            <div class="footerSocials__title text-white">
                                Follow Us
                            </div>

                            <div class="footerSocials__icons text-white d-flex align-items-center gap-3">
                                <a href="https://web.facebook.com/authenticmoroccoadventures/" target="_blank" class="icon-facebook" aria-label="Facebook"></a>

                                <a href="https://x.com/AMADMCmor" target="_blank" class="icon-twitter" aria-label="Twitter (X)"></a>

                                <a href="https://www.instagram.com/authenticmoroccoadventures/" target="_blank" class="icon-instagram" aria-label="Instagram"></a>

                                <a href="https://www.linkedin.com/in/authentic-moroccoadventures-99812a420/" target="_blank" class="icon-linkedin" aria-label="LinkedIn"></a>

                                <a href="https://fr.pinterest.com/amoroccoadventures/" target="_blank" class="text-dark" aria-label="Pinterest">
                                    <i class="bi bi-pinterest"></i>
                                </a>

                                <a href="https://www.youtube.com/@AuthenticMoroccoAdventures" target="_blank" class="text-dark" aria-label="YouTube">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-white-15-top">
            <div class="container">
                <div class="footer__content">
                    <div class="row y-gap-40 justify-between">

                        <div class="col-lg-4 col-md-6">
                            <h4 class="text-20 fw-500 text-white">Contact</h4>

                            <div class="y-gap-10 mt-20 text-white">
                                <span class="d-block">Phone: <a href="tel:+212666107312" class="text-white">+212 666 107 312</a></span>
                                <span class="d-block">WhatsApp: <a href="https://wa.me/212666107312" target="_blank" class="text-white">+212 666 107 312</a></span>
                                <a class="d-block text-white" href="mailto:authenticmoroccoadventures@gmail.com">authenticmoroccoadventures@gmail.com</a>
                            </div>
                        </div>

                        <div class="col-lg-auto col-6">
                            <h4 class="text-20 fw-500 text-white">Company</h4>
                            <nav aria-label="Footer Company Menu">
                                <div class="y-gap-10 mt-20">
                                    <a class="d-block fw-500 text-white" href="{{ route('front.about') }}">About</a>
                                    <a class="d-block fw-500 text-white" href="{{ route('blog.index') }}">Blog</a>
                                    <a class="d-block fw-500 text-white" href="{{ route('front.contact') }}">Contact</a>
                                    <a class="d-block fw-500 text-white" href="{{ route('front.terms') }}">Terms</a>
                                    <a class="d-block fw-500 text-white" href="{{ route('front.help-center') }}">Help Center</a>
                                </div>
                            </nav>
                        </div>

                        <div class="col-lg-auto col-6">
                            <h4 class="text-20 fw-500 text-white">Explore</h4>
                            <nav aria-label="Footer Explore Menu">
                                <div class="y-gap-10 mt-20">
                                    <a class="d-block fw-500 text-white" href="{{ route('front.tours.index') }}">Tours</a>
                                    <a class="d-block fw-500 text-white" href="{{ route('front.activities.index') }}">Activities</a>
                                    <a class="d-block fw-500 text-white" href="{{ route('front.trekking.index') }}">Trekking</a>
                                    <a class="d-block fw-500 text-white" href="{{ route('front.locations.index') }}">Locations</a>
                                </div>
                            </nav>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <h4 class="text-20 fw-500 text-white">Newsletter</h4>
                            <p class="text-white mt-20">Subscribe to the free newsletter and stay up to date</p>

                            <form class="footer__newsletter" action="{{ route('newsletter.subscribe') }}" method="POST">
                                @csrf
                                <label for="footer-email" class="visually-hidden">Email address</label>
                                <input type="email" id="footer-email" name="email" placeholder="Your email address" required>
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
    </div>

    <div class="border-white-15-top">
        <div class="container">
            <div class="footer__bottom">
                <div class="row y-gap-5 justify-between items-center">
                    <div class="col-auto text-white">
                        <div>
                            &copy; Copyright Authentic Morocco Adventures {{ date('Y') }} •
                            Developed by
                            <a href="https://www.facebook.com/CodeSommet/" target="_blank" class="text-accent-1 fw-500">
                                Code Sommet
                            </a>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="footer__images d-flex items-center x-gap-10">
                            <img src="{{ asset('assets/img/footer/cards/1.png') }}" alt="Payment card 1">
                            <img src="{{ asset('assets/img/footer/cards/2.png') }}" alt="Payment card 2">
                            <img src="{{ asset('assets/img/footer/cards/3.png') }}" alt="Payment card 3">
                            <img src="{{ asset('assets/img/footer/cards/4.png') }}" alt="Payment card 4">
                            <img src="{{ asset('assets/img/footer/cards/5.png') }}" alt="Payment card 5">
                            <img src="{{ asset('assets/img/footer/cards/6.png') }}" alt="Payment card 6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

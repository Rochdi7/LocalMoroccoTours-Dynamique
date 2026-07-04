@extends('front.layouts.app2')

@section('title', 'About Us - Authentic Morocco Adventures')

@section('content')

    <section data-anim="fade" class="pageHeader -type-1">
        <div class="pageHeader__bg">
            <figure style="margin: 0;">
                <img src="{{ asset('assets/images/home/chefchaouen-blue-stairs-morocco-handicrafts-market.webp') }}"
                    alt="Blue-painted stairs lined with Moroccan crafts and rugs in Chefchaouen, Morocco."
                    title="Chefchaouen Blue Stairs and Moroccan Handicrafts Market" loading="lazy"
                    style="object-fit: cover; width: 100%; height: 100%; display: block;">
                <figcaption class="visually-hidden">
                    Vibrant blue alleyways in Chefchaouen showcase colorful Moroccan handicrafts and woven rugs,
                    capturing the city’s charm and artisan spirit.
                </figcaption>
            </figure>
            <img src="{{ asset('assets/img/hero/1/shape.svg') }}" alt="Decorative shape">
        </div>

        <div class="container">
            <div class="row justify-center">
                <div class="col-12">
                    <div class="pageHeader__content text-center">
                        <h1 class="pageHeader__title">
                            About Authentic Morocco Adventures
                        </h1>

                        <p class="pageHeader__text">
                            Journey into the vivid blue streets of Chefchaouen and beyond with Authentic Morocco Adventures — your
                            trusted guide to authentic Moroccan experiences.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="layout-pt-lg">
        <div data-anim-wrap class="container">
            <div class="row y-gap-20 justify-between">

                <div data-anim-child="slide-up" class="col-lg-6">
                    <h2 class="text-30 fw-700">
                        Discover Authentic Morocco Adventures — Your Gateway to Authentic Moroccan Experiences
                    </h2>
                </div>

                <div data-anim-child="slide-up delay-2" class="col-lg-5">
                    <p>
                        At Authentic Morocco Adventures, we’re passionate about revealing Morocco’s vibrant spirit and hidden
                        treasures.
                        From the blue streets of Chefchaouen to the golden dunes of the Sahara, our expertly crafted tours
                        immerse you in authentic culture, stunning landscapes, and unforgettable moments.
                        <br><br>
                        Let our local team guide you beyond the usual paths, creating memories that capture the true essence
                        of Morocco.
                    </p>

                    <a href="{{ route('front.tours.index') }}" class="button -sm -dark-1 bg-accent-1 text-white mt-30">
                        Explore Our Tours
                    </a>

                </div>

            </div>
        </div>
    </section>

    <section data-anim="slide-up" class="layout-pt-xl">
        <div class="video relative container">
            <div class="video__bg">
                <figure class="figure-no-margin">
                    <img src="{{ asset('assets/images/about/morocco-medina-market-arches.webp') }}"
                        alt="Woman exploring traditional Moroccan medina street lined with colorful carpets and historic arches."
                        title="Exploring Morocco’s vibrant medina streets with artisan carpets and intricate architecture."
                        class="rounded-12" loading="lazy">
                    <figcaption class="visually-hidden">
                        A woman stands beneath ornate arches in a narrow Moroccan medina street, surrounded by colorful rugs
                        and ancient architecture, showcasing the rich culture and craftsmanship of Morocco.
                    </figcaption>
                </figure>
            </div>

            <div class="row justify-center pb-50 md:pb-0">
                <div class="col-auto">
                    <a href="https://www.youtube.com/watch?v=0WyB7Dhn7Kw&ab_channel=YUBA-TD" class="d-block js-gallery"
                        data-gallery="gallery1">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="29" stroke="white" stroke-width="2" />
                            <g clip-path="url(#clip0_79_4379)">
                                <path
                                    d="M39.339 27.6922L27.5265 20.4107C26.6718 19.8846 25.6386 19.8627 24.7625 20.3522C23.8863 20.8416 23.3633 21.7331 23.3633 22.7366V37.2332C23.3633 38.7506 24.5859 39.9918 26.0887 40C26.0928 40 26.0969 40 26.1009 40C26.5705 40 27.0599 39.8528 27.517 39.5739C27.8847 39.3495 28.0009 38.8696 27.7765 38.502C27.5522 38.1342 27.0722 38.0181 26.7046 38.2424C26.4908 38.3728 26.282 38.4402 26.0971 38.4402C25.5301 38.4371 24.923 37.9514 24.923 37.2332V22.7367C24.923 22.3061 25.1474 21.9238 25.5232 21.7139C25.899 21.5039 26.3422 21.5133 26.7083 21.7387L38.5208 29.0202C38.8759 29.2388 39.0791 29.6033 39.0782 30.0202C39.0773 30.4371 38.8727 30.8008 38.5157 31.0187L29.9752 36.2479C29.6078 36.4728 29.4924 36.9529 29.7173 37.3202C29.9422 37.6876 30.4223 37.8031 30.7896 37.5781L39.3291 32.3495C40.1468 31.8507 40.636 30.9812 40.638 30.0234C40.64 29.0656 40.1542 28.1941 39.339 27.6922Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_79_4379">
                                    <rect width="20" height="20" fill="white" transform="translate(22 20)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-xl" style="margin-top: 270px;">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row">
                <div class="col-auto">
                    <h2 class="text-30 md:text-24">Why Choose Authentic Morocco Adventures</h2>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="row md:x-gap-20 pt-40 sm:pt-20 mobile-css-slider -w-280">

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="{{ asset('assets/img/icons/1/ticket.svg') }}" alt="Flexible Booking Icon">
                        </div>

                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Ultimate Flexibility</h3>
                        <p class="featureIcon__text mt-10">
                            Plan your Moroccan adventure with ease — enjoy flexible bookings, free cancellations, and
                            options to fit every traveler.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="{{ asset('assets/img/icons/1/hot-air-balloon.svg') }}"
                                alt="Memorable Experiences Icon">
                        </div>

                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Memorable Experiences</h3>
                        <p class="featureIcon__text mt-10">
                            Discover hidden gems, cultural treasures, and breathtaking Moroccan landscapes that you'll
                            remember forever.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="{{ asset('assets/img/icons/1/diamond.svg') }}" alt="Quality Icon">
                        </div>

                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Quality at Our Core</h3>
                        <p class="featureIcon__text mt-10">
                            Experience the highest standards with trusted guides, authentic itineraries, and excellent guest
                            reviews.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="{{ asset('assets/img/icons/1/medal.svg') }}" alt="Support Icon">
                        </div>

                        <h3 class="featureIcon__title text-18 fw-500 mt-30">24/7 Support</h3>
                        <p class="featureIcon__text mt-10">
                            Our dedicated team is ready around the clock to help you craft your perfect Morocco journey.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

<style>
@media (max-width: 767px) {
  .layout-pt-xl {
    margin-top: 0 !important;
    margin-bottom: 20px;
  }
}
</style>

    <section data-anim="fade" class="layout-pt-xl relative">
        <div class="relative xl:unset container">
            <div class="layout-pt-xl layout-pb-xl rounded-12">
                <div class="sectionBg">
                    <img src="{{ asset('assets/img/about/1/1.png') }}"
                        alt="Traditional Moroccan street scene with colorful stairs and artisan market in Chefchaouen"
                        class="img-ratio rounded-12 md:rounded-0" loading="lazy">
                </div>

                <div class="row y-gap-30 justify-center items-center">
                    <div class="col-lg-4 col-md-6">
                        <h2 class="text-40 lh-13">
                            We Make<br class="md:d-none">
                            World Travel Easy
                        </h2>

                        <p class="mt-10">
                            Traveling under your own power and at your own pace helps you connect more meaningfully
                            with your destination—and have more fun!
                        </p>
                        <a href="{{ route('front.tours.index') }}"
                            class="button -sm -dark-1 bg-accent-1 text-white mt-60 md:mt-30 d-inline-block"
                            style="width: 240px; text-align: center;">
                            Explore Our Tours
                        </a>

                    </div>

                    <div class="col-md-6">
                        <div class="featuresGrid">

                            <div class="featuresGrid__item px-40 py-40 text-center bg-white rounded-12">
                                <img src="{{ asset('assets/img/icons/2/1.svg') }}" alt="Map icon">
                                <div class="text-40 fw-700 color-accent-2 mt-20 lh-14">240</div>
                                <div>Total Destinations</div>
                            </div>

                            <div class="featuresGrid__item px-40 py-40 text-center bg-white rounded-12">
                                <img src="{{ asset('assets/img/icons/2/2.svg') }}" alt="Hot air balloon icon">
                                <div class="text-40 fw-700 color-accent-2 mt-20 lh-14">3672</div>
                                <div>Amazing Tours</div>
                            </div>

                            <div class="featuresGrid__item px-40 py-40 text-center bg-white rounded-12">
                                <img src="{{ asset('assets/img/icons/2/3.svg') }}" alt="Smiling face icon">
                                <div class="text-40 fw-700 color-accent-2 mt-20 lh-14">92,842</div>
                                <div>Happy Customers</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section data-anim-wrap class="relative layout-pt-xl layout-pb-xl">
        <div data-anim-child="slide-up delay-1" class="sectionBg md:d-none">
            <img src="{{ asset('assets/img/testimonials/1/1.png') }}" alt="Authentic Morocco Adventures background">
        </div>

        <div data-anim-child="slide-up delay-3" class="container">
            <div class="row justify-center text-center">
                <div class="col-auto">
                    <h2 class="text-30 md:text-24">What Travelers Say About Authentic Morocco Adventures</h2>
                </div>
            </div>

            <div class="row justify-center pt-60 md:pt-20">
                <div class="col-xl-6 col-md-8 col-sm-10">
                    <div class="overflow-hidden js-section-slider" data-slider-cols="xl-1 lg-1 md-1 sm-1 base-1"
                        data-pagination="js-testimonials-pagination">
                        <div class="swiper-wrapper">

                            {{-- Review 1 --}}
                            <div class="swiper-slide">
                                <div class="testimonials -type-1 pt-10 text-center">
                                    <div class="testimonials__image size-100 rounded-full">
                                        <img src="{{ asset('assets/images/reviews/testimonial-matteo-italy_isnet-general-use.webp') }}"
                                            alt="Matteo Rossi, traveler from Italy enjoying Morocco tour">
                                        <div class="testimonials__icon">
                                            <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                    fill="white" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="visually-hidden">Matteo Rossi loved the desert tour with camel rides
                                        and sunset views in Morocco.</div>
                                    <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Incredible Desert Tour!
                                    </div>
                                    <div class="text-20 fw-500 mt-20">
                                        My family and I booked a desert adventure with Authentic Morocco Adventures. Riding
                                        camels through the dunes at sunset was magical. Truly the best way to see
                                        Morocco!
                                    </div>
                                    <div class="mt-20 md:mt-40">
                                        <div class="lh-16 text-16 fw-500">Matteo Rossi</div>
                                        <div class="lh-16">Traveler from Italy</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Review 2 --}}
                            <div class="swiper-slide">
                                <div class="testimonials -type-1 pt-10 text-center">
                                    <div class="testimonials__image size-100 rounded-full">
                                        <img src="{{ asset('assets/images/reviews/testimonial-carlos-brazil_bria.webp') }}"
                                            alt="Carlos Almeida, traveler from Brazil enjoying Moroccan culture">
                                        <div class="testimonials__icon">
                                            <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                    fill="white" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="visually-hidden">Carlos Almeida discovered authentic Moroccan culture
                                        and hidden gems with Authentic Morocco Adventures.</div>
                                    <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Authentic Moroccan Culture
                                    </div>
                                    <div class="text-20 fw-500 mt-20">
                                        Thanks to Authentic Morocco Adventures, I discovered hidden spots in Marrakech. The
                                        guides were knowledgeable and passionate about sharing Moroccan culture.
                                    </div>
                                    <div class="mt-20 md:mt-40">
                                        <div class="lh-16 text-16 fw-500">Carlos Almeida</div>
                                        <div class="lh-16">Traveler from Brazil</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Review 3 --}}
                            <div class="swiper-slide">
                                <div class="testimonials -type-1 pt-10 text-center">
                                    <div class="testimonials__image size-100 rounded-full">
                                        <img src="{{ asset('assets/images/reviews/testimonial-james-usa_bria.webp') }}"
                                            alt="James Peterson, traveler from USA sharing Morocco experience">
                                        <div class="testimonials__icon">
                                            <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                    fill="white" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="visually-hidden">James Peterson appreciated the easy planning and
                                        professional arrangements for his Morocco trip.</div>
                                    <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Seamless Planning</div>
                                    <div class="text-20 fw-500 mt-20">
                                        I was worried about planning my trip to Morocco, but Authentic Morocco Adventures made it
                                        so easy. From transport to accommodations, everything was perfectly arranged.
                                    </div>
                                    <div class="mt-20 md:mt-40">
                                        <div class="lh-16 text-16 fw-500">James Peterson</div>
                                        <div class="lh-16">Traveler from USA</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Review 4 --}}
                            <div class="swiper-slide">
                                <div class="testimonials -type-1 pt-10 text-center">
                                    <div class="testimonials__image size-100 rounded-full">
                                        <img src="{{ asset('assets/images/reviews/testimonial-aysha-morocco_bria.webp') }}"
                                            alt="Aysha El Fassi, Moroccan traveler sharing local experiences">
                                        <div class="testimonials__icon">
                                            <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                    fill="white" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="visually-hidden">Aysha El Fassi explored hidden gems and local secrets
                                        in Morocco with Authentic Morocco Adventures.</div>
                                    <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Hidden Gems</div>
                                    <div class="text-20 fw-500 mt-20">
                                        I’ve visited Morocco before, but Authentic Morocco Adventures showed me places I’d never
                                        seen. A truly authentic experience that felt personalized and unique.
                                    </div>
                                    <div class="mt-20 md:mt-40">
                                        <div class="lh-16 text-16 fw-500">Aysha El Fassi</div>
                                        <div class="lh-16">Traveler from Morocco</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Review 5 --}}
                            <div class="swiper-slide">
                                <div class="testimonials -type-1 pt-10 text-center">
                                    <div class="testimonials__image size-100 rounded-full">
                                        <img src="{{ asset('assets/images/reviews/testimonial-anastasia-russia_bria.webp') }}"
                                            alt="Anastasia Ivanova, traveler from Russia sharing Morocco experience">
                                        <div class="testimonials__icon">
                                            <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                    fill="white" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="visually-hidden">Anastasia Ivanova shared a professional and safe
                                        experience traveling with Authentic Morocco Adventures.</div>
                                    <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Professional Team</div>
                                    <div class="text-20 fw-500 mt-20">
                                        The team at Authentic Morocco Adventures was so professional and friendly. They answered
                                        all my questions and made me feel safe and excited about exploring Morocco.
                                    </div>
                                    <div class="mt-20 md:mt-40">
                                        <div class="lh-16 text-16 fw-500">Anastasia Ivanova</div>
                                        <div class="lh-16">Traveler from Russia</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="pagination -type-1 justify-center pt-60 md:pt-40 js-testimonials-pagination">
                            <div class="pagination__button"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section data-anim="slide-up" class="cta -type-1">
        <div class="cta__bg">
            <img src="{{ asset('assets/images/cta/newsletter-morocco.webp') }}"
                alt="Stunning Moroccan desert background for Authentic Morocco Adventures newsletter">
        </div>

        <div class="container py-20">
            <div class="row justify-between">
                <div class="col-xl-5 col-lg-6">
                    <div class="cta__content">
                        <h2 class="text-40 md:text-24 lh-13 text-white">
                            Get Exclusive Morocco Travel Deals<br class="lg:d-none">
                            and Insider Tips
                        </h2>

                        <p class="mt-10 text-white">
                            Join the Authentic Morocco Adventures newsletter to discover hidden gems, travel tips,
                            and exclusive discounts on desert adventures, cultural experiences, and coastal escapes.
                        </p>

                        {{-- SUCCESS ALERT --}}
                        @if (session('success'))
                            <div class="alert alert-success mt-20">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- ERROR ALERT --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mt-20">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <div class="singleInput type-1 mt-30">
                                <label for="newsletter-email" class="visually-hidden">Your email</label>
                                <input type="email" id="newsletter-email" name="email"
                                    placeholder="Your email address" required
                                    aria-label="Enter your email address to subscribe" value="{{ old('email') }}">
                                <button type="submit" class="button -md -dark-1 bg-accent-2 text-white">
                                    Subscribe
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* .button.-md {
                padding: 27px 30px;
            } */

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .alert-success {
            background: #4CAF50;
            color: #fff;
        }

        .alert-danger {
            background: #F44336;
            color: #fff;
        }
    </style>

    <section class="layout-pt-xl layout-pb-xl">
        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-auto">
                    <h2 class="text-30">Trusted by the World’s Leading Travel Brands</h2>
                </div>
            </div>

            <div class="row justify-center align-items-center gap-4 flex-wrap pt-40 sm:pt-20">

                <!-- Bokun -->
                <div class="col-auto">
                    <img src="{{ asset('assets/images/clients/bokun.webp') }}"
                        alt="Bokun Logo - leading travel booking platform" class="client-logo">
                    <div class="visually-hidden">
                        <strong>Bokun</strong> is a booking system for tours and activities used by travel operators
                        worldwide.
                    </div>
                </div>

                <!-- Tourhub -->
                <div class="col-auto">
                    <img src="{{ asset('assets/images/clients/tourhub.png') }}"
                        alt="Tourhub Logo - group tour marketplace" class="client-logo">
                    <div class="visually-hidden">
                        <strong>Tourhub</strong> connects travelers with group tour operators globally for unique
                        experiences.
                    </div>
                </div>

                <!-- TourRadar -->
                <div class="col-auto">
                    <img src="{{ asset('assets/images/clients/tourradar.svg') }}"
                        alt="TourRadar Logo - multi-day tour booking platform" class="client-logo">
                    <div class="visually-hidden">
                        <strong>TourRadar</strong> is a platform for booking multi-day tours worldwide.
                    </div>
                </div>

                <!-- TripAdvisor -->
                <div class="col-auto">
                    <img src="{{ asset('assets/images/clients/tripadvisor.svg') }}"
                        alt="Tripadvisor Logo - travel reviews and bookings" class="client-logo">
                    <div class="visually-hidden">
                        <strong>Tripadvisor</strong> is a global platform for travel reviews, guides, and bookings.
                    </div>
                </div>

                <!-- Trustpilot -->
                <div class="col-auto">
                    <img src="{{ asset('assets/images/clients/trustpilot-seeklogo.svg') }}"
                        alt="Trustpilot Logo - trusted review platform" class="client-logo">
                    <div class="visually-hidden">
                        <strong>Trustpilot</strong> is an online review platform trusted worldwide.
                    </div>
                </div>

                <!-- Viator -->
                <div class="col-auto">
                    <img src="{{ asset('assets/images/clients/viator-seeklogo-2.svg') }}"
                        alt="Viator Logo - tours and activities booking platform" class="client-logo">
                    <div class="visually-hidden">
                        <strong>Viator</strong> specializes in tours, activities, and experiences for travelers worldwide.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .client-logo {
            height: 60px;
            width: auto;
            max-width: 160px;
            object-fit: contain;
            display: inline-block;
            vertical-align: middle;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .client-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }
    </style>
@endsection

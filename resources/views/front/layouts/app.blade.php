<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Preconnect to critical origins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Fonts with font-display swap (display=swap already set in the Google Fonts URL) --}}
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    {{-- Critical layout CSS: loaded render-blocking, on purpose, so the page never paints unstyled --}}
    <link rel="stylesheet" href="{{ asset('assets/css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">

    {{-- SEO meta tags for homepage --}}
    @if (Request::is('/'))
        {{-- Title --}}
        <title>Authentic Morocco Adventures | Private Morocco Tours & Authentic Local Experiences</title>

        {{-- Meta description --}}
        <meta name="description"
              content="Authentic Morocco Adventures offers private and authentic tours across Morocco. Explore Marrakech, desert adventures, souks, and cultural gems with a local Moroccan tour guide.">

        {{-- Canonical --}}
        <link rel="canonical" href="https://www.authenticmoroccoadventures.com/">

        {{-- Keywords --}}
        <meta name="keywords"
              content="Morocco tours, Marrakech tours, desert tours, local tour guide Morocco, private tours Morocco, Authentic Morocco Adventures">

        {{-- Robots --}}
        <meta name="robots" content="index, follow">

        {{-- Author --}}
        <meta name="author" content="Authentic Morocco Adventures">

        {{-- Open Graph --}}
        <meta property="og:type" content="website">
        <meta property="og:title" content="Authentic Morocco Adventures | Private Morocco Tours & Authentic Local Experiences">
        <meta property="og:description"
              content="Private and authentic Morocco tours guided by a local expert. Discover the magic of Morocco with personalized desert tours, Marrakech explorations, and cultural gems.">
        <meta property="og:url" content="https://www.authenticmoroccoadventures.com/">
        <meta property="og:image"
              content="https://www.authenticmoroccoadventures.com/assets/images/home/marrakech-souk-moroccan-brass-lanterns-market.webp">
        <meta property="og:image:alt"
              content="Golden Moroccan brass lanterns glowing in the vibrant souks of Marrakech.">
        <meta property="og:site_name" content="Authentic Morocco Adventures">

        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Authentic Morocco Adventures | Private Morocco Tours & Authentic Local Experiences">
        <meta name="twitter:description"
              content="Explore Morocco with Authentic Morocco Adventures. Private desert tours, Marrakech explorations, and unique cultural experiences led by a local Moroccan guide.">
        <meta name="twitter:image"
              content="https://www.authenticmoroccoadventures.com/assets/images/home/marrakech-souk-moroccan-brass-lanterns-market.webp">

        {{-- Favicon --}}
        <link rel="icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" sizes="any">
        <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon/favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/favicon/favicon-96x96.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}">

        {{-- JSON-LD Structured Data --}}
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "TourGuide",
          "name": "Authentic Morocco Adventures",
          "image": "https://www.authenticmoroccoadventures.com/assets/images/home/marrakech-souk-moroccan-brass-lanterns-market.webp",
          "description": "Authentic Morocco Adventures is a professional tour guide company offering private and authentic experiences across Morocco. Explore Marrakech, the Sahara Desert, and hidden cultural gems with a local expert.",
          "url": "https://www.authenticmoroccoadventures.com/",
          "sameAs": [
            "https://web.facebook.com/authenticmoroccoadventures/",
            "https://www.instagram.com/authenticmoroccoadventures/",
            "https://x.com/AMADMCmor",
            "https://fr.pinterest.com/amoroccoadventures/",
            "https://www.youtube.com/@AuthenticMoroccoAdventures",
            "https://www.linkedin.com/in/authentic-moroccoadventures-99812a420/",
            "https://fr.trustpilot.com/review/authenticmoroccoadventures.com"
          ],
          "address": {
            "@type": "PostalAddress",
            "addressCountry": "MA",
            "addressLocality": "Marrakech",
            "addressRegion": "Marrakech-Safi"
          },
          "telephone": "+212666107312",
          "priceRange": "$$",
          "founder": {
            "@type": "Person",
            "name": "Your Name Here",
            "jobTitle": "Tour Guide"
          }
        }
        </script>
    @endif

    {{-- Title fallback for non-homepage --}}
    <title>@yield('title', 'Authentic Morocco Adventures')</title>

    {{-- Per-page pushed styles (e.g. homepage hero animation, Bootstrap Icons) --}}
    @stack('styles')
</head>

<body>
<div class="tourPagesSidebar" data-x="tourPagesSidebar" data-x-toggle="-is-active">
    <div class="tourPagesSidebar__overlay" aria-hidden="true"></div>
    <div class="tourPagesSidebar__content">
        <div class="tourPagesSidebar__header d-flex items-center justify-between">
            <div class="text-20 fw-500">All filters</div>
            <button class="button -dark-1 size-40 rounded-full bg-light-1" data-x-click="tourPagesSidebar"
                    aria-label="Close filters panel">
                <i class="icon-cross text-10" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .whatsapp-float {
        position: fixed;
        right: 30px;
        bottom: 30px;
        z-index: 100;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
    }

    .whatsapp-float img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    @media (max-width: 767px) {
        .whatsapp-float {
            bottom: 20px;
            right: 20px;
            width: 54px;
            height: 54px;
        }
    }
</style>

<button class="toTopButton js-top-button" aria-label="Scroll back to top">
    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <g clip-path="url(#clip0_83_4004)">
            <path
                d="M17.8783 0H4.12177C3.59388 0 3.16602 0.42786 3.16602 0.955755C3.16602 1.48365 3.59388 1.91151 4.12177 1.91151H17.8783C18.4062 1.91151 18.834 1.48365 18.834 0.955755C18.834 0.42786 18.4062 0 17.8783 0Z"/>
            <path
                d="M11.6759 4.67546C11.3026 4.30219 10.6975 4.30219 10.3242 4.67546L6.04107 8.95863C5.66779 9.3319 5.66779 9.937 6.04107 10.3103C6.41434 10.6837 7.01955 10.6836 7.39272 10.3103L10.0444 7.6587V21.0443C10.0444 21.5722 10.4723 22 11.0002 22C11.5281 22 11.9559 21.5722 11.9559 21.0443V7.65859L14.6076 10.3102C14.7942 10.4969 15.0389 10.5901 15.2834 10.5901C15.528 10.5901 15.7726 10.4968 15.9593 10.3102C16.3325 9.9369 16.3325 9.3318 15.9593 8.95852L11.6759 4.67546Z"/>
        </g>
        <defs>
            <clipPath id="clip0_83_4004">
                <rect width="22" height="22" fill="white"/>
            </clipPath>
        </defs>
    </svg>
</button>

<main>
    @include('front.partials._header')

    @yield('content')

    @include('front.partials._footer')
</main>

<a href="https://wa.me/212666107312?text=Hello%20Authentic%20Morocco%20Adventures%2C%20I%E2%80%99d%20like%20more%20info!"
   class="whatsapp-float" target="_blank" aria-label="Chat on WhatsApp">
    <img src="{{ asset('assets/images/icon/whatsapp.png') }}" alt="WhatsApp Chat">
</a>

@include('front.partials._wishlist')

{{-- Scripts loaded async / deferred where possible --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
<script src="{{ asset('assets/js/vendors.min.js') }}" defer></script>
<script src="{{ asset('assets/js/main.min.js') }}" defer></script>
<script src="{{ asset('assets/js/favorites.js') }}" defer></script>
<script src="{{ asset('assets/js/slider-fix.js') }}" defer></script>
<script src="{{ asset('assets/js/homepage.min.js') }}"></script>

@stack('scripts')

<script>
    console.log('typeof jQuery:', typeof jQuery);
</script>
</body>
</html>

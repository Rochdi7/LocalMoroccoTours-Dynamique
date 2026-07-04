@extends('front.layouts.app2')

@section('title', 'All Locations')

@section('content')

    {{-- HERO SECTION --}}
    <section data-anim="fade" class="pageHeader -type-1">
        <div class="pageHeader__bg">
            <img src="{{ asset('assets/images/hero/tangier-morocco-coastline-night-lights.webp') }}"
                 alt="Panoramic night view of Tangier’s coastline and city lights in Morocco."
                 title="Tangier, Morocco at Night">
            <img src="{{ asset('assets/images/hero/1/shape.svg') }}" alt="Decorative shape">
        </div>

        <div class="container">
            <div class="row justify-center">
                <div class="col-12">
                    <div class="pageHeader__content text-center">
                        <h1 class="pageHeader__title">
                            Morocco
                        </h1>

                        <p class="pageHeader__text">
                            Explore travel guides, hidden gems, and vibrant experiences across Morocco.
                        </p>

                        {{-- VISUALLY HIDDEN TEXT FOR SEO --}}
                        <div class="visually-hidden">
                            Panoramic night view of Tangier’s coastline and city lights in Morocco.
                            Tangier’s glowing coastline seen from the medina hillside, where historic streets overlook the
                            modern port. This panoramic view shows Tangier, Morocco, at twilight. The medina’s colorful houses
                            cascade down the hillside toward the illuminated coastline and harbor. A striking contrast between
                            traditional Moroccan architecture and the city’s modern infrastructure.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LOCATIONS GRID --}}
    <section class="layout-pt-xl layout-pb-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row justify-between items-end y-gap-10">
                <div class="col-auto">
                    <h2 class="text-30">Trending Locations</h2>
                </div>
            </div>

            @foreach ($locations->chunk(6) as $chunk)
                <div class="grid -type-2 pt-40 sm:pt-20" id="locations-grid">
                    @foreach ($chunk as $index => $location)
                        @php
                            $media = $location->getFirstMedia('locations');
                            $imgUrl = $media?->getUrl() ?? asset('images/placeholder.png');
                            $alt = $media?->getCustomProperty('alt') ?? $location->name;
                            $title = $media?->getCustomProperty('title') ?? $location->name;
                            $caption = $media?->getCustomProperty('caption') ?? '';
                            $desc = $media?->getCustomProperty('description') ?? '';
                            $delay = $index + 1;
                        @endphp

                        <a href="{{ route('front.locations.show', $location->slug) }}"
                           data-anim-child="slide-up delay-{{ $delay }}"
                           class="featureCard -type-1 overflow-hidden rounded-12 px-30 py-30 -hover-image-scale"
                           title="{{ $title }}">
                            <div class="featureCard__image -hover-image-scale__image">
                                <img src="{{ $imgUrl }}" alt="{{ $alt }}"
                                     @if ($caption) data-caption="{{ $caption }}" @endif
                                     @if ($desc) data-description="{{ $desc }}" @endif
                                     class="w-100 h-100 object-cover">
                            </div>

                            <div class="featureCard__content">
                                <h4 class="text-white">
                                    {{ $location->name }}
                                </h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach

            {{-- Removed Load More button here --}}
        </div>
    </section>

    <div class="line mt-40 mb-40"></div>

    {{-- ABOUT MOROCCO SECTION --}}
    <section class="layout-pt-xl layout-pb-xl">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="text-30 md:text-24">What to know before visiting Morocco</h2>
                </div>
            </div>

            <div class="row y-gap-20 pt-30">
                <div class="col-lg-8">
                    <p>
                        Morocco is a vibrant country where ancient traditions blend seamlessly with modern life.
                        <br><br>
                        From the bustling souks of Marrakech and Fez to the windswept dunes of the Sahara Desert,
                        Morocco offers a captivating journey through diverse landscapes, rich history, and
                        unforgettable cultural experiences. Wander through labyrinthine medinas, admire stunning
                        Islamic architecture, and enjoy flavorful Moroccan cuisine infused with spices and local
                        ingredients.
                        <br><br>
                        Whether you're exploring coastal cities like Essaouira, hiking in the Atlas Mountains,
                        or visiting ancient kasbahs, Morocco promises memories that will last a lifetime.
                    </p>
                </div>

                <div class="col-lg-4">
                    <figure class="rounded-12 overflow-hidden">
                        <img src="{{ asset('assets/images/hero/medina-marrakech-square-sunset-morocco.webp') }}"
                             alt="Koutoubia Mosque rising over Jemaa el-Fnaa square at sunset in Marrakech, Morocco."
                             title="Marrakech Sunset View" class="w-100 h-auto">
                        <figcaption class="visually-hidden">
                            Vibrant evening colors over Marrakech’s famous square and Koutoubia Mosque.
                            This stunning sunset photograph captures the Koutoubia Mosque towering over the bustling Jemaa
                            el-Fnaa square in Marrakech, Morocco. The dramatic sky, warm lights, and crowds of people reflect
                            the vibrant energy of this historic Moroccan city.
                        </figcaption>
                    </figure>
                </div>
            </div>

            <div class="line mt-40 mb-40"></div>
            <style>
                .visually-hidden {
                    position: absolute !important;
                    width: 1px !important;
                    height: 1px !important;
                    padding: 0 !important;
                    margin: -1px !important;
                    overflow: hidden !important;
                    clip: rect(0, 0, 0, 0) !important;
                    white-space: nowrap !important;
                    border: 0 !important;
                }
            </style>
        </div>
    </section>

@endsection

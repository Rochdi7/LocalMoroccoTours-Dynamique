@extends('front.layouts.app')

@section('content')


    <section data-anim-wrap class="hero -type-8">
        <div class="hero-image-section">

            <figure class="your-image-container-class">
                <div data-anim-child="slide-up" class="hero__bg">
                    <img src="assets/images/hero/sahara-desert-luxury-camp-stargazing-morocco.webp"
                        alt="Magx of a luxury Berber camp in the Sahara Desert, Morocco, with tents illuminated under a dramatic, star-filled sky.">
                </div>
            </figure>

            <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ImageObject",
    "name": "Under the desert stars. There's nothing quite like the magic of a night in the Sahara.",
    "description": "This photo captures the heart of the Moroccan desert experience. After a day of exploring the dunes, the evening settles into a serene magic. Our camp becomes a haven of warmth and light, where guests gather for a traditional meal, share stories around the campfire, and then witness the breathtaking celestial show in a sky free from city lights. It is an unforgettable night of peace, wonder, and authentic Berber hospitality.",
    "contentUrl": "https://www.yourwebsite.com/assets/images/hero/sahara-desert-luxury-camp-stargazing-morocco.webp",
    "creditText": "Your Website or Company Name",
    "copyrightNotice": "© 2025 Your Company Name"
  }
  </script>

        </div>
        <div class="container">
            <div data-anim-child="slide-up delay-2" class="row justify-center">
                <div class="col-lg-8 col-md-10">
                    <div class="hero__content text-center">
                        <div class="hero__filter mb-60 md:mb-0 md:mt-30">
                            <div class="searchForm -type-1 shadow-1 rounded-200">
                                <div class="searchForm__form">
                                    <div class="searchFormItem js-select-control js-form-dd">
                                        <div class="searchFormItem__button" data-x-click="location">
                                            <div class="searchFormItem__icon size-50 rounded-full border-1 flex-center">
                                                <i class="text-20 icon-pin"></i>
                                            </div>
                                            <div class="searchFormItem__content">
                                                <h5>Where</h5>
                                                <div class="js-select-control-chosen">Search destinations</div>
                                            </div>
                                        </div>

                                        <div class="searchFormItemDropdown -location" data-x="location"
                                            data-x-toggle="is-active">
                                            <div class="searchFormItemDropdown__container">
                                                <div class="searchFormItemDropdown__list sroll-bar-1">

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Europe</span>
                                                            <span>Continent</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">France</span>
                                                            <span>Country</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">London</span>
                                                            <span>Destinations</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Asia</span>
                                                            <span>Continent</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">United States</span>
                                                            <span>Country</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Tokio</span>
                                                            <span>Destinations</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Africa</span>
                                                            <span>Continent</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">New Zealand</span>
                                                            <span>Country</span>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="searchFormItem js-select-control js-form-dd js-calendar">
                                        <div class="searchFormItem__button" data-x-click="calendar">
                                            <div class="searchFormItem__icon size-50 rounded-full border-1 flex-center">
                                                <i class="text-20 icon-calendar"></i>
                                            </div>
                                            <div class="searchFormItem__content">
                                                <h5>When</h5>
                                                <div>
                                                    <span class="js-first-date">Add dates</span>
                                                    <span class="js-last-date"></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="searchFormItemDropdown -calendar" data-x="calendar"
                                            data-x-toggle="is-active">
                                            <div class="searchFormItemDropdown__container">

                                                <div class="searchMenu-date -searchForm js-form-dd js-calendar-el">
                                                    <div class="searchMenu-date__field shadow-2" data-x-dd="searchMenu-date"
                                                        data-x-dd-toggle="-is-active">
                                                        <div class="bg-white rounded-4">
                                                            <div class="elCalendar js-calendar-el-calendar"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="searchFormItem js-select-control js-form-dd">
                                        <div class="searchFormItem__button" data-x-click="tour-type">
                                            <div class="searchFormItem__icon size-50 rounded-full border-1 flex-center">
                                                <i class="text-20 icon-flag"></i>
                                            </div>
                                            <div class="searchFormItem__content">
                                                <h5>Tour Type</h5>
                                                <div class="js-select-control-chosen">All tour</div>
                                            </div>
                                        </div>

                                        <div class="searchFormItemDropdown -tour-type" data-x="tour-type"
                                            data-x-toggle="is-active">
                                            <div class="searchFormItemDropdown__container">
                                                <div class="searchFormItemDropdown__list sroll-bar-1">

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">City Tour</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Hiking</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Food Tour</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Cultural Tours</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Museums Tours</span>
                                                        </button>
                                                    </div>

                                                    <div class="searchFormItemDropdown__item">
                                                        <button class="js-select-control-button">
                                                            <span class="js-select-control-choice">Beach Tours</span>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="searchForm__button">
                                    <button class="button -dark-1 bg-accent-2 size-60 rounded-200 text-white">
                                        <i class="icon-search text-16"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h1 class="hero__title text-white">
                                Find Next PlaceTo Visit
                            </h1>

                            <div class="hero__text text-white mt-10">
                                Discover amzaing places at exclusive deals.Eat, Shop, Visit<br class="lg:d-none">
                                interesting places around the world.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row justify-between items-end y-gap-10">
                <div class="col-auto">
                    <h2 class="text-30 md:text-24">Special Offers</h2>
                </div>
            </div>

            @if ($specialOffers->isNotEmpty())
                <div class="specialCardGrid row y-gap-30 md:y-gap-20 pt-40 sm:pt-20">
                    @foreach ($specialOffers as $offer)
                        <div data-anim-child="slide-up delay-{{ $loop->iteration }}" class="col-xl-4 col-lg-6 col-md-6">
                            <a href="{{ $offer->link ?? '#' }}" class="specialCard">
                                <div class="specialCard__image">
                                    <img src="{{ $offer->getFirstMediaUrl('special_offers') }}" alt="{{ $offer->title }}">
                                </div>

                                <div class="specialCard__content">
                                    <div class="specialCard__subtitle">{{ $offer->subtitle }}</div>
                                    <h3 class="specialCard__title">{!! $offer->title !!}</h3>
                                    <div class="specialCard__text">{{ $offer->text }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pt-40">
                    <p>No special offers are available at the moment. Please check back later.</p>
                </div>
            @endif

        </div>
    </section>

    <section class="layout-pt-xl layout-pb-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-end">
                <div class="col-auto">
                    <h2 class="text-30">Trending Locations</h2>
                </div>
                <div class="col-auto">
                    <a href="#" class="buttonArrow d-flex items-center">
                        <span>See all</span>
                        <i class="icon-arrow-top-right text-16 ml-10"></i>
                    </a>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="row y-gap-30 md:y-gap-20 pt-40 sm:pt-20">
                @foreach ($locations as $location)
                    <div class="w-1/5 lg:w-1/4 md:w-1/2">
                        <a href="{{ route('locations.show', $location->id) }}"
                            class="featureCard -type-7 -hover-image-scale">
                            <div class="featureCard__image ratio ratio-23:30 -hover-image-scale__image rounded-12">
                                @if ($location->hasMedia('locations'))
                                    <img src="{{ $location->getFirstMediaUrl('locations') }}" alt="{{ $location->name }}"
                                        class="img-ratio rounded-12">
                                @endif
                            </div>

                            <div class="mt-20">
                                <h4 class="text-18 fw-500">{{ $location->name }}</h4>
                                <div class="text-14 lh-13 mt-5">100+ Tours</div> {{-- optional: dynamic count --}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <!-- Popular Tours Section -->
    <section class="layout-pt-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-center y-gap-10">
                <div class="col-auto">
                    <h2 class="text-30">Find Popular Tours</h2>
                </div>
                <div class="col-auto">
                    <a href="{{ route('front.tours.index') }}" class="buttonArrow d-flex items-center">
                        <span>See all</span>
                        <i class="icon-arrow-top-right text-16 ml-10"></i>
                    </a>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="relative pt-40 sm:pt-20">
                <div class="overflow-hidden js-section-slider" data-gap="30"
                    data-slider-cols="xl-4 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider1-prev"
                    data-nav-next="js-slider1-next">

                    <div class="swiper-wrapper">
                        @foreach ($tours as $tour)
                            <div class="swiper-slide">
                                <div class="tourCard -type-1 d-block bg-white relative">
                                    <div class="tourCard__header">
                                        <div class="tourCard__image ratio ratio-28:20">
                                            <img src="{{ $tour->getFirstMediaUrl('tours') ?: asset('assets/images/default-image.png') }}"
                                                alt="{{ $tour->title }}" class="img-ratio rounded-12">
                                        </div>

                                        <button class="tourCard__favorite js-favorite-btn" data-id="{{ $tour->id }}"
                                            data-type="tour"
                                            style="position: absolute; bottom: -17px; right: 10px; width: 35px; height: 35px; border-radius: 50%; background: white; display: flex; justify-content: center; align-items: center; box-shadow: 0px 10px 40px rgba(0,0,0,0.05); z-index: 2;">
                                            <i class="icon-heart"></i>
                                        </button>

                                        @if ($tour->bestseller_flag)
                                            <div class="tourCard__bestseller"
                                                style="position: absolute; top: 10px; right: 10px; background: #ff5722; color: #fff; padding: 5px 8px; font-size: 12px; border-radius: 4px;">
                                                <i class="icon-fire mr-5"></i> Popular
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tourCard__content pt-10">
                                        <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                            <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                            {{ $tour->location->name ?? 'Unknown Location' }}
                                        </div>

                                        <h3 class="tourCard__title text-16 fw-500 mt-5">
                                            <a href="{{ route('front.tours.show', $tour->slug) }}" class="text-dark-1">
                                                <span>{{ Str::limit($tour->title, 50) }}</span>
                                            </a>
                                        </h3>

                                        <div class="tourCard__rating mt-5">
                                            <div class="d-flex items-center">
                                                <div class="d-flex x-gap-5 pr-10">
                                                    @php
                                                        $rating = $tour->avg_rating ?? 0;
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                    @endphp

                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="icon-star text-10 text-yellow-2"></i>
                                                    @endfor

                                                    @if ($halfStar)
                                                        <i class="icon-star-half text-10 text-yellow-2"></i>
                                                    @endif

                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="icon-star text-10 text-light-2"></i>
                                                    @endfor
                                                </div>

                                                <span class="text-dark-1 text-13">
                                                    {{ number_format($rating, 1) }} ({{ $tour->reviews_count }})
                                                </span>
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                            <div class="d-flex items-center">
                                                <i class="icon-clock text-16 mr-5"></i>
                                                {{ $tour->duration }}
                                            </div>

                                            <div>
                                                From
                                                <span class="text-16 fw-500">
                                                    ${{ number_format($tour->base_price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="navAbsolute">
                    <button class="navAbsolute__button bg-white js-slider1-prev">
                        <i class="icon-arrow-left text-14"></i>
                    </button>

                    <button class="navAbsolute__button bg-white js-slider1-next">
                        <i class="icon-arrow-right text-14"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <section class="layout-pt-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-center y-gap-10">
                <div class="col-auto">
                    <h2 class="text-30">Find Popular Activities</h2>
                </div>
                <div class="col-auto">
                    <a href="{{ route('front.activities.index') }}" class="buttonArrow d-flex items-center">
                        <span>See all</span>
                        <i class="icon-arrow-top-right text-16 ml-10"></i>
                    </a>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="relative pt-40 sm:pt-20">
                <div class="overflow-hidden js-section-slider" data-gap="30"
                    data-slider-cols="xl-4 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider2-prev"
                    data-nav-next="js-slider2-next">

                    <div class="swiper-wrapper">
                        @foreach ($activities as $activity)
                            <div class="swiper-slide">
                                <div class="tourCard -type-1 d-block bg-white relative">
                                    <div class="tourCard__header">
                                        <div class="tourCard__image ratio ratio-28:20">
                                            <img src="{{ $activity->getFirstMediaUrl('activities') ?: asset('assets/images/default-image.png') }}"
                                                alt="{{ $activity->title }}" class="img-ratio rounded-12">
                                        </div>

                                        <button class="tourCard__favorite js-favorite-btn" data-id="{{ $activity->id }}"
                                            data-type="activity"
                                            style="position: absolute; bottom: -17px; right: 10px; width: 35px; height: 35px; border-radius: 50%; background: white; display: flex; justify-content: center; align-items: center; box-shadow: 0px 10px 40px rgba(0,0,0,0.05); z-index: 2;">
                                            <i class="icon-heart"></i>
                                        </button>

                                        @if ($activity->bestseller_flag)
                                            <div class="tourCard__bestseller"
                                                style="position: absolute; top: 10px; right: 10px; background: #ff5722; color: #fff; padding: 5px 8px; font-size: 12px; border-radius: 4px;">
                                                <i class="icon-fire mr-5"></i> Popular
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tourCard__content pt-10">
                                        <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                            <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                            {{ $activity->location->name ?? 'Unknown Location' }}
                                        </div>

                                        <h3 class="tourCard__title text-16 fw-500 mt-5">
                                            <a href="{{ route('front.activities.show', $activity->slug) }}"
                                                class="text-dark-1">
                                                <span>{{ Str::limit($activity->title, 50) }}</span>
                                            </a>
                                        </h3>

                                        <div class="tourCard__rating mt-5">
                                            <div class="d-flex items-center">
                                                <div class="d-flex x-gap-5 pr-10">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="icon-star text-10 {{ $i <= round($activity->avg_rating) ? 'text-yellow-2' : 'text-light-2' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-dark-1 text-13">
                                                    {{ number_format($activity->avg_rating, 1) }}
                                                    ({{ $activity->reviews_count }})
                                                </span>
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                            <div class="d-flex items-center">
                                                <i class="icon-clock text-16 mr-5"></i>
                                                {{ $activity->duration }}
                                            </div>

                                            <div>
                                                From
                                                <span class="text-16 fw-500">
                                                    ${{ number_format($activity->base_price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="navAbsolute">
                    <button class="navAbsolute__button bg-white js-slider2-prev">
                        <i class="icon-arrow-left text-14"></i>
                    </button>

                    <button class="navAbsolute__button bg-white js-slider2-next">
                        <i class="icon-arrow-right text-14"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>



    <section class="layout-pt-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-center y-gap-10">
                <div class="col-auto">
                    <h2 class="text-30">Find Popular Trekking</h2>
                </div>
                <div class="col-auto">
                    <a href="{{ route('front.trekking.index') }}" class="buttonArrow d-flex items-center">
                        <span>See all</span>
                        <i class="icon-arrow-top-right text-16 ml-10"></i>
                    </a>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="relative pt-40 sm:pt-20">
                <div class="overflow-hidden js-section-slider" data-gap="30"
                    data-slider-cols="xl-4 lg-3 md-2 sm-1 base-1" data-nav-prev="js-slider3-prev"
                    data-nav-next="js-slider3-next">

                    <div class="swiper-wrapper">
                        @foreach ($trekking as $trek)
                            <div class="swiper-slide">
                                <div class="tourCard -type-1 d-block bg-white relative">
                                    <div class="tourCard__header">
                                        <div class="tourCard__image ratio ratio-28:20">
                                            <img src="{{ $trek->getFirstMediaUrl('trekking') ?: asset('assets/images/default-image.png') }}"
                                                alt="{{ $trek->title }}" class="img-ratio rounded-12">
                                        </div>

                                        <button class="tourCard__favorite js-favorite-btn" data-id="{{ $trek->id }}"
                                            data-type="trekking"
                                            style="position: absolute; bottom: -17px; right: 10px; width: 35px; height: 35px; border-radius: 50%; background: white; display: flex; justify-content: center; align-items: center; box-shadow: 0px 10px 40px rgba(0,0,0,0.05); z-index: 2;">
                                            <i class="icon-heart"></i>
                                        </button>

                                        @if ($trek->bestseller_flag)
                                            <div class="tourCard__bestseller"
                                                style="position: absolute; top: 10px; right: 10px; background: #ff5722; color: #fff; padding: 5px 8px; font-size: 12px; border-radius: 4px;">
                                                <i class="icon-fire mr-5"></i> Popular
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tourCard__content pt-10">
                                        <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                            <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                            {{ $trek->location->name ?? 'Unknown Location' }}
                                        </div>

                                        <h3 class="tourCard__title text-16 fw-500 mt-5">
                                            <a href="{{ route('front.trekking.show', $trek->slug) }}"
                                                class="text-dark-1">
                                                <span>{{ Str::limit($trek->title, 50) }}</span>
                                            </a>
                                        </h3>

                                        <div class="tourCard__rating mt-5">
                                            <div class="d-flex items-center">
                                                <div class="d-flex x-gap-5 pr-10">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="icon-star text-10 {{ $i <= round($trek->avg_rating) ? 'text-yellow-2' : 'text-light-2' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-dark-1 text-13">
                                                    {{ number_format($trek->avg_rating, 1) }} ({{ $trek->reviews_count }})
                                                </span>
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                            <div class="d-flex items-center">
                                                <i class="icon-clock text-16 mr-5"></i>
                                                {{ $trek->duration }}
                                            </div>

                                            <div>
                                                From
                                                <span class="text-16 fw-500">
                                                    ${{ number_format($trek->base_price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="navAbsolute">
                    <button class="navAbsolute__button bg-white js-slider3-prev">
                        <i class="icon-arrow-left text-14"></i>
                    </button>

                    <button class="navAbsolute__button bg-white js-slider3-next">
                        <i class="icon-arrow-right text-14"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <style>
        .js-favorite-btn.is-favorited {
            background-color: #ff4d4d;
            color: white;
        }

        .js-favorite-btn.is-favorited i {
            color: #ff4d4d;
        }
    </style>

    </style>


    <section data-anim="slide-up" class="cta -type-4 -style-2">
        <div class="container">
            <div class="cta__content">
                <div class="row justify-between">
                    <div class="col-xl-7 col-lg-8">
                        <h2 class="text-24 lh-13">
                            Keep on Planning
                        </h2>

                        <p class="mt-10">
                            What to do, where to eat & more trip inspo.
                        </p>

                        <button class="button -md -accent-1 bg-dark-1 text-white mt-10">
                            See More
                            <i class="icon-arrow-top-right ml-10"></i>
                        </button>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="cta__image">
                        <img src="img/cta/12/1.jpg" alt="image">
                        <img src="img/cta/12/shape.svg" alt="image">
                        <img src="img/cta/12/mobileShape.svg" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row">
                <div class="col-auto">
                    <h2 class="text-30 md:text-24">Why choose Tourz</h2>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="row md:x-gap-20 pt-40 sm:pt-20 mobile-css-slider -w-280">

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="img/icons/1/ticket.svg" alt="icon">
                        </div>

                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Ultimate flexibility</h3>
                        <p class="featureIcon__text mt-10">You&#39;re in control, with free cancellation and payment
                            options to satisfy any plan or budget.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="img/icons/1/hot-air-balloon.svg" alt="icon">
                        </div>

                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Memorable experiences</h3>
                        <p class="featureIcon__text mt-10">Browse and book tours and activities so incredible, you&#39;ll
                            want to tell your friends.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="img/icons/1/diamond.svg" alt="icon">
                        </div>

                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Quality at our core</h3>
                        <p class="featureIcon__text mt-10">High quality standards. Millions of reviews. A tourz company.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="featureIcon -type-1 pr-40 md:pr-0">
                        <div class="featureIcon__icon">
                            <img src="img/icons/1/medal.svg" alt="icon">
                        </div>

                        <h3 class="featureIcon__title text-18 fw-500 mt-30">Award-winning support</h3>
                        <p class="featureIcon__text mt-10">New price? New plan? No problem. We&#39;re here to help, 24/7.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="bg-accent-1-05">
        <section data-anim-wrap class="relative layout-pt-xl layout-pb-xl">
            <div data-anim-child="slide-up delay-1" class="sectionBg md:d-none">
                <img src="img/testimonials/1/1.png" alt="image">
            </div>

            <div data-anim-child="slide-up delay-3" class="container">
                <div class="row justify-center text-center">
                    <div class="col-auto">
                        <h2 class="text-30 md:text-24">Customer Reviews</h2>
                    </div>
                </div>

                <div class="row justify-center pt-60 md:pt-20">
                    <div class="col-xl-6 col-md-8 col-sm-10">
                        <div class="overflow-hidden js-section-slider" data-slider-cols="xl-1 lg-1 md-1 sm-1 base-1"
                            data-pagination="js-testimonials-pagination">
                            <div class="swiper-wrapper">

                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="img/testimonials/1/2.png" alt="image">

                                            <div class="testimonials__icon">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Great quality!</div>

                                        <div class="text-20 fw-500 mt-20">The tours in this website are great. I had been
                                            really enjoy with my family! The team is very professional and taking care of
                                            the customers. Will surely recommend to my freind to join this company!</div>

                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Brooklyn Simmons</div>
                                            <div class="lh-16">Web Developer</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="img/testimonials/1/2.png" alt="image">

                                            <div class="testimonials__icon">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Great quality!</div>

                                        <div class="text-20 fw-500 mt-20">The tours in this website are great. I had been
                                            really enjoy with my family! The team is very professional and taking care of
                                            the customers. Will surely recommend to my freind to join this company!</div>

                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Brooklyn Simmons</div>
                                            <div class="lh-16">Web Developer</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="img/testimonials/1/2.png" alt="image">

                                            <div class="testimonials__icon">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Great quality!</div>

                                        <div class="text-20 fw-500 mt-20">The tours in this website are great. I had been
                                            really enjoy with my family! The team is very professional and taking care of
                                            the customers. Will surely recommend to my freind to join this company!</div>

                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Brooklyn Simmons</div>
                                            <div class="lh-16">Web Developer</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="img/testimonials/1/2.png" alt="image">

                                            <div class="testimonials__icon">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Great quality!</div>

                                        <div class="text-20 fw-500 mt-20">The tours in this website are great. I had been
                                            really enjoy with my family! The team is very professional and taking care of
                                            the customers. Will surely recommend to my freind to join this company!</div>

                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Brooklyn Simmons</div>
                                            <div class="lh-16">Web Developer</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="testimonials -type-1 pt-10 text-center">
                                        <div class="testimonials__image size-100 rounded-full">
                                            <img src="img/testimonials/1/2.png" alt="image">

                                            <div class="testimonials__icon">
                                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3165 0.838867C12.1013 1.81846 10.9367 3.43478 9.77215 5.63887C8.65823 7.84295 8 10.2429 7.8481 12.8389H12.4557C12.4051 8.87152 13.6203 5.24703 16 1.91642L13.3165 0.838867ZM5.51899 0.838867C4.25316 1.81846 3.08861 3.43478 1.92405 5.63887C0.810126 7.84295 0.151899 10.2429 0 12.8389H4.60759C4.55696 8.87152 5.77215 5.19805 8.20253 1.91642L5.51899 0.838867Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="text-18 fw-500 text-accent-1 mt-60 md:mt-40">Great quality!</div>

                                        <div class="text-20 fw-500 mt-20">The tours in this website are great. I had been
                                            really enjoy with my family! The team is very professional and taking care of
                                            the customers. Will surely recommend to my freind to join this company!</div>

                                        <div class="mt-20 md:mt-40">
                                            <div class="lh-16 text-16 fw-500">Brooklyn Simmons</div>
                                            <div class="lh-16">Web Developer</div>
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

    </div>

    @if($posts->count())
    <section class="layout-pt-xl layout-pb-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row justify-between items-end y-gap-10">
                <div class="col-auto">
                    <h2 class="text-30 md:text-24">Travel Articles</h2>
                </div>
                <div class="col-auto">
                    <a href="{{ route('blog.index') }}" class="buttonArrow d-flex items-center">
                        <span>See all</span>
                        <i class="icon-arrow-top-right text-16 ml-10"></i>
                    </a>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="row y-gap-30 pt-40 sm:pt-20">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('blog.show', $post->slug) }}" class="blogCard -type-1">
                            <div class="blogCard__image ratio ratio-41:30">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                                    class="img-ratio rounded-12">
                                @if ($post->category)
                                    <div class="blogCard__badge">{{ $post->category->name }}</div>
                                @endif
                            </div>
                            <div class="blogCard__content mt-30">
                                <div class="blogCard__info text-14">
                                    <div class="lh-13">
                                        {{ $post->published_at ? $post->published_at->format('F d, Y') : 'N/A' }}
                                    </div>
                                    <div class="blogCard__line"></div>
                                    <div class="lh-13">By {{ $post->author->name ?? 'N/A' }}</div>
                                </div>
                                <h3 class="blogCard__title text-18 fw-500 mt-10">
                                    {{ $post->title }}
                                </h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection

@extends('front.layouts.app2')

@section('title', $location->name)

@section('content')
    <section class="layout-pt-xl layout-pb-xl">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up" class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <h2 class="text-30">Featured Trips in {{ $location->name }}</h2>
                </div>
            </div>

            <div class="row y-gap-30 pt-40 sm:pt-20">
                @forelse($tours as $tour)
                    @php
                        $media = $tour->getFirstMedia('tours');
                        $imgUrl = $media?->getUrl() ?? asset('images/placeholder.png');
                        $alt = $media?->getCustomProperty('alt') ?? $tour->title;
                        $title = $media?->getCustomProperty('title') ?? $tour->title;
                    @endphp

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="tourCard -type-3 -hover-image-scale position-relative" title="{{ $title }}">
                            <a href="{{ route('front.tours.show', $tour->slug) }}">
                                <div class="tourCard__image ratio ratio-41:45 rounded-12 -hover-image-scale__image">
                                    <img src="{{ $imgUrl }}" alt="{{ $alt }}" class="img-ratio rounded-12">
                                </div>

                                <div class="tourCard__wrap">
                                    <div class="tourCard__header d-flex justify-between items-center text-13 text-white">
                                        <div class="d-flex items-center">
                                            <i class="icon-clock text-16 mr-5"></i>
                                            {{ $tour->duration ?? 'Flexible duration' }}
                                        </div>
                                    </div>

                                    <div class="tourCard__content">
                                        <div>
                                            <div class="tourCard__location d-flex items-center text-13 text-white">
                                                <i class="icon-pin d-flex text-16 text-white mr-5"></i>
                                                {{ $tour->location?->name ?? $location->name }}
                                            </div>

                                            <h3 class="tourCard__title text-18 text-white fw-500 mt-5">
                                                <span>{{ $tour->title }}</span>
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

                                                    <span class="text-white text-13 ml-10">
                                                        {{ number_format($rating, 1) }}
                                                        ({{ $tour->reviews_count ?? 0 }})
                                                    </span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="text-right text-white">
                                            @if ($tour->base_price > 0)
                                                <div class="text-13 lh-14">From</div>
                                                <div class="text-18 fw-500">${{ number_format($tour->base_price, 2) }}</div>
                                            @else
                                                <div class="text-14 fw-500">Contact for price</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <button
                                class="tourCard__favorite js-favorite-btn {{ in_array($location->id, $favoriteLocationIds ?? []) ? 'is-favorited' : '' }}"
                                data-id="{{ $location->id }}" data-type="location">
                                <i
                                    class="icon-heart {{ in_array($location->id, $favoriteLocationIds ?? []) ? 'is-favorited-icon' : '' }}"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p>No tours found for this location.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <style>
            .tourCard__favorite {
                position: absolute;
                top: 15px;
                right: 15px;
                background: rgba(0, 0, 0, 0.5);
                border: none;
                padding: 8px;
                border-radius: 50%;
                cursor: pointer;
                z-index: 5;
            }

            .tourCard__favorite i {
                color: #fff;
                font-size: 18px;
                transition: color 0.3s;
            }

            .tourCard__favorite.is-favorited i,
            .tourCard__favorite i.is-favorited-icon {
                color: #EB662B;
            }

            .js-favorite-btn.is-favorited {
                background-color: #ff4d4d;
                color: white;
            }

            .js-favorite-btn.is-favorited i {
                color: #ff4d4d;
            }
        </style>
    </section>

    {{-- Load the favorites-locations JS --}}
    <script src="{{ asset('js/favorites-locations.js') }}"></script>
@endsection

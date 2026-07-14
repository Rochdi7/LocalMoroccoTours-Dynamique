@extends('front.layouts.app2')

@section('content')
    <section data-anim="fade" class="hero -type-1 -min">
        <div class="hero__bg">
            <img src="{{ asset('assets/images/hero/hassan-ii-mosque-casablanca-morocco-ocean-sunset.webp') }}"
                alt="Hassan II Mosque in Casablanca, Morocco, standing over the ocean at sunset with a pastel sky"
                title="The majestic Hassan II Mosque rises above the Atlantic waves in Casablanca, Morocco, glowing under a soft sunset sky.">

            <img src="{{ asset('assets/img/hero/1/shape.svg') }}" alt="decorative shape">
        </div>

        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="hero__content">
                        <h1 class="hero__title">
                            Discover Morocco’s Best Tours
                        </h1>

                        <p class="hero__text">
                            Explore breathtaking landscapes, vibrant cities, and rich culture. Find your perfect Moroccan
                            adventure from our diverse tour selection.
                        </p>

                        <form method="GET" action="{{ route('front.tours.index') }}">
                            <div class="mt-30">
                                <div class="searchForm -type-1 -col-2">
                                    <div class="searchForm__form">

                                        {{-- LOCATION DROPDOWN --}}
                                        <div class="searchFormItem js-select-control js-form-dd">
                                            <div class="searchFormItem__button" data-x-click="location">
                                                <div class="searchFormItem__icon size-50 rounded-12 border-1 flex-center">
                                                    <i class="text-20 icon-pin"></i>
                                                </div>
                                                <div class="searchFormItem__content">
                                                    <h5>Where</h5>
                                                    <div class="js-select-control-chosen">
                                                        {{ $locations->firstWhere('id', request('locations')[0] ?? null)?->name ?? 'Search locations' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="searchFormItemDropdown -location" data-x="location"
                                                data-x-toggle="is-active">
                                                <div class="searchFormItemDropdown__container">
                                                    <div class="searchFormItemDropdown__list scroll-bar-1">

                                                        @if (!empty($locations))
                                                            @foreach ($locations as $location)
                                                                {{-- Keep only main locations (no parent) --}}
                                                                @if (empty($location->parent))
                                                                    <div class="searchFormItemDropdown__item">
                                                                        <button type="button"
                                                                            class="js-location-select-button"
                                                                            data-id="{{ $location->id }}"
                                                                            data-name="{{ $location->name }}"
                                                                            data-target="tourLocationInput">
                                                                            <span
                                                                                class="js-select-control-choice">{{ $location->name }}</span>
                                                                            <span>Main Location</span>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- HIDDEN LOCATION INPUT --}}
                                        <input type="hidden" name="locations[]" id="tourLocationInput"
                                            value="{{ request('locations')[0] ?? '' }}">

                                        {{-- CUSTOM GROUP SIZE --}}
                                        <div class="searchFormItem js-form-dd">
                                            <div class="searchFormItem__button" data-x-click="group_size">
                                                <div class="searchFormItem__icon size-50 rounded-12 border-1 flex-center">
                                                    <i class="icon-teamwork text-20"></i>
                                                </div>
                                                <div class="searchFormItem__content">
                                                    <h5>Group Size</h5>
                                                    <div class="js-select-control-chosen">
                                                        {{ request('group_size') ?? 'Enter group size range' }}
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="searchFormItemDropdown -group_size" data-x="group_size"
                                                data-x-toggle="is-active">
                                                <div class="searchFormItemDropdown__container groupSizePanel">
                                                    <div class="searchFormItemDropdown__list scroll-bar-1">
                                                        <div class="groupSizePanel__body">
                                                            <label class="groupSizePanel__label">Custom Group Size</label>
                                                            <div class="groupSizePanel__row">
                                                                <div class="groupSizePanel__field">
                                                                    <span class="groupSizePanel__fieldLabel">Min</span>
                                                                    <input type="number" class="groupSizePanel__input"
                                                                        id="customMinGroupSize" placeholder="e.g. 1"
                                                                        min="1">
                                                                </div>
                                                                <div class="groupSizePanel__field">
                                                                    <span class="groupSizePanel__fieldLabel">Max</span>
                                                                    <input type="number" class="groupSizePanel__input"
                                                                        id="customMaxGroupSize" placeholder="e.g. 10"
                                                                        min="1">
                                                                </div>
                                                            </div>
                                                            <button type="button" id="applyCustomGroupSize"
                                                                class="groupSizePanel__apply button -sm -accent-1-dark bg-accent-1 text-white">
                                                                Apply
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <style>
                                            .searchForm.-type-1 .searchFormItemDropdown.-group_size .searchFormItemDropdown__container {
                                                width: 300px;
                                                max-width: calc(100vw - 14px);
                                                padding: 16px;
                                            }

                                            @media (max-width: 575px) {
                                                .searchForm.-type-1 .searchFormItemDropdown.-group_size .searchFormItemDropdown__container {
                                                    width: calc(100vw - 14px);
                                                }
                                            }

                                            .groupSizePanel__label {
                                                display: block;
                                                font-size: 14px;
                                                font-weight: 600;
                                                color: var(--color-third, #05073C);
                                                margin-bottom: 12px;
                                            }

                                            .groupSizePanel__row {
                                                display: flex;
                                                gap: 12px;
                                            }

                                            .groupSizePanel__field {
                                                flex: 1;
                                                display: flex;
                                                flex-direction: column;
                                                gap: 6px;
                                            }

                                            .groupSizePanel__fieldLabel {
                                                font-size: 12px;
                                                color: #717171;
                                            }

                                            .groupSizePanel__input {
                                                width: 100%;
                                                height: 44px;
                                                border-radius: 10px;
                                                border: 1px solid var(--Border, #E7E6E6) !important;
                                                padding: 0 14px;
                                                font-size: 14px;
                                                color: var(--color-third, #05073C);
                                                outline: none;
                                                transition: border-color 0.2s;
                                            }

                                            .groupSizePanel__input:focus {
                                                border-color: var(--color-accent-1) !important;
                                            }

                                            .groupSizePanel__apply {
                                                width: 100%;
                                                margin-top: 16px;
                                                border-radius: 10px;
                                            }
                                        </style>

                                        {{-- Hidden group_size input --}}
                                        <input type="hidden" name="group_size" id="groupSize"
                                            value="{{ request('group_size') }}">

                                    </div>

                                    <div class="searchForm__button">
                                        <button type="submit" class="button -dark-1 bg-accent-1 text-white">
                                            <i class="icon-search text-16 mr-10"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Handle location dropdown
                                document.querySelectorAll('.js-location-select-button').forEach(btn => {
                                    btn.addEventListener('click', function(e) {
                                        e.preventDefault();

                                        let id = btn.getAttribute('data-id');
                                        let name = btn.getAttribute('data-name');
                                        let targetId = btn.getAttribute('data-target');

                                        if (targetId) {
                                            document.getElementById(targetId).value = id;
                                            btn.closest('.searchFormItem').querySelector('.js-select-control-chosen')
                                                .textContent = name;
                                            btn.closest('[data-x]').classList.remove('is-active');
                                        }
                                    });
                                });

                                // Handle custom group size
                                const applyBtn = document.getElementById('applyCustomGroupSize');
                                if (applyBtn) {
                                    applyBtn.addEventListener('click', function() {
                                        let min = document.getElementById('customMinGroupSize').value;
                                        let max = document.getElementById('customMaxGroupSize').value;

                                        if (min === "" && max === "") return;

                                        let value = min && max ? `${min} - ${max}` : (min ? `${min}+` : `${max}+`);
                                        document.getElementById('groupSize').value = value;

                                        let chosen = document.querySelector('[data-x="group_size"]')
                                            .closest('.searchFormItem')
                                            .querySelector('.js-select-control-chosen');
                                        if (chosen) {
                                            chosen.textContent = value + ' people';
                                        }

                                        document.querySelector('[data-x="group_size"]').classList.remove('is-active');
                                    });
                                }

                                // Remove empty hidden inputs before submit
                                let form = document.querySelector('form');
                                if (form) {
                                    form.addEventListener('submit', function() {
                                        ['tourLocationInput', 'groupSize'].forEach(id => {
                                            let input = document.getElementById(id);
                                            if (input && input.value.trim() === "") {
                                                input.remove();
                                            }
                                        });
                                    });
                                }
                            });
                        </script>

                        <!-- hidden SEO text -->
                        <div style="display: none;">
                            The majestic Hassan II Mosque rises above the Atlantic waves in Casablanca, Morocco, glowing
                            under a soft sunset sky.
                        </div>
                        <div style="display: none;">
                            The Hassan II Mosque, one of the largest mosques in the world, stands gracefully along the
                            Atlantic coast in Casablanca, Morocco. Captured during sunset, the image highlights the mosque’s
                            intricate architecture, towering minaret, and the serene ocean waves beneath a pastel-hued sky.
                            A stunning symbol of Moroccan craftsmanship and culture, perfect for inspiring travelers to
                            explore Morocco’s architectural wonders.
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section data-anim-wrap class="layout-pt-md layout-pb-xl">
        <div class="container">
            <div class="row">
                <div data-anim-child="slide-up" class="col-xl-3 col-lg-4">
                    <div class="lg:d-none">
                        <div class="sidebar -type-1 overflow-hidden rounded-12">
                            <form method="GET" action="{{ route('front.tours.index') }}">

                                <div class="sidebar__content">
                                    <!-- Tour Type -->
                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500">Tour Type</h5>
                                        <div class="pt-15">
                                            <div class="d-flex flex-column y-gap-15">
                                                @php
                                                    $tourTypes = [
                                                        'multi_day' => 'Multi-Day Tour',
                                                        'day_trip' => 'Day Trip',
                                                    ];
                                                @endphp

                                                @foreach ($tourTypes as $typeKey => $typeLabel)
                                                    <div class="d-flex items-center">
                                                        <div class="form-checkbox">
                                                            <input type="radio" name="type"
                                                                value="{{ $typeKey }}"
                                                                {{ request('type') === $typeKey ? 'checked' : '' }}>
                                                            <div class="form-checkbox__mark">
                                                                <div class="form-checkbox__icon">
                                                                    <svg width="10" height="8" viewBox="0 0 10 8"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                            fill="white" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lh-11 ml-10">
                                                            {{ $typeLabel }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Filter price -->
                                    <div class="sidebar__item">
                                        <div class="accordion -simple-2 js-accordion">
                                            <div class="accordion__item js-accordion-item-active">
                                                <div class="accordion__button mb-10 d-flex items-center justify-between">
                                                    <h5 class="text-18 fw-500">Filter Price</h5>

                                                    <div class="accordion__icon flex-center">
                                                        <i class="icon-chevron-down"></i>
                                                        <i class="icon-chevron-down"></i>
                                                    </div>
                                                </div>

                                                <div class="accordion__content">
                                                    <div class="pt-15">
                                                        <div class="js-price-rangeSlider">
                                                            <div class="px-5">
                                                                <input type="hidden" name="price[0]"
                                                                    class="js-lower-input"
                                                                    value="{{ request('price.0', $minPrice) }}">
                                                                <input type="hidden" name="price[1]"
                                                                    class="js-upper-input"
                                                                    value="{{ request('price.1', $maxPrice) }}">

                                                                <div class="js-slider" data-min="{{ $minPrice }}"
                                                                    data-max="{{ $maxPrice }}"
                                                                    data-start-lower="{{ request('price.0', $minPrice) }}"
                                                                    data-start-upper="{{ request('price.1', $maxPrice) }}">
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-between mt-20">
                                                                <div>
                                                                    <span>Price:</span>
                                                                    <span
                                                                        class="fw-500 js-lower">{{ request('price.0', $minPrice) }}</span>
                                                                    <span> - </span>
                                                                    <span
                                                                        class="fw-500 js-upper">{{ request('price.1', $maxPrice) }}</span>
                                                                </div>
                                                                <div class="fw-500">
                                                                    Filter
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @php
                                        $durations = [
                                            '1 Day',
                                            '2 Days',
                                            '3 Days',
                                            '4 Days',
                                            '5 Days',
                                            '6 Days',
                                            '7 Days',
                                            '8 Days',
                                            '9 Days',
                                            '10 Days',
                                            '11 Days',
                                            '12 Days',
                                            '13 Days',
                                            '14 Days',
                                            '15 Days',
                                        ];

                                        $selectedDurations = request()->input('duration', []);
                                    @endphp

                                    <!-- Duration (Desktop Sidebar) -->
                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500">Duration</h5>
                                        <div class="pt-15">
                                            <div class="d-flex flex-column y-gap-15" id="duration-list-desktop">
                                                @foreach ($durations as $index => $duration)
                                                    <div
                                                        class="{{ $index >= 5 ? 'd-none duration-hidden-desktop' : '' }}">
                                                        <div class="d-flex items-center">
                                                            <div class="form-checkbox">
                                                                <input type="checkbox" name="duration[]"
                                                                    value="{{ $duration }}"
                                                                    {{ in_array($duration, $selectedDurations) ? 'checked' : '' }}>
                                                                <div class="form-checkbox__mark">
                                                                    <div class="form-checkbox__icon">
                                                                        <svg width="10" height="8"
                                                                            viewBox="0 0 10 8" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                                fill="white" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="lh-11 ml-10">{{ $duration }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if (count($durations) > 5)
                                                <button type="button" class="d-flex text-15 fw-500 text-accent-2 mt-15"
                                                    id="seeMoreDurationsDesktop">
                                                    See More
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Rating -->
                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500">Rating</h5>
                                        <div class="pt-15">
                                            <div class="d-flex flex-column y-gap-15">
                                                @foreach (range(5, 1) as $stars)
                                                    <div class="d-flex">
                                                        <div class="form-checkbox">
                                                            <input type="checkbox" name="ratings[]"
                                                                value="{{ $stars }}"
                                                                {{ in_array($stars, request('ratings', [])) ? 'checked' : '' }}>
                                                            <div class="form-checkbox__mark">
                                                                <div class="form-checkbox__icon">
                                                                    <svg width="10" height="8" viewBox="0 0 10 8"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                            fill="white" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex x-gap-5 ml-10">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="flex-center icon-star {{ $i <= $stars ? 'text-yellow-2' : 'text-light-6' }} text-13"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Specials -->
                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500">Specials</h5>
                                        <div class="pt-15">
                                            <div class="d-flex flex-column y-gap-15">
                                                @php
                                                    $specials = [
                                                        [
                                                            'key' => 'free_cancellation',
                                                            'label' => 'Free Cancellation',
                                                        ],
                                                        [
                                                            'key' => 'bestseller',
                                                            'label' => 'Bestseller',
                                                        ],
                                                    ];

                                                    $selectedSpecials = request('specials', []);
                                                @endphp


                                                @foreach ($specials as $special)
                                                    <div>
                                                        <div class="d-flex items-center">
                                                            <div class="form-checkbox">
                                                                <input type="checkbox" name="specials[]"
                                                                    value="{{ $special['key'] }}"
                                                                    {{ in_array($special['key'], $selectedSpecials) ? 'checked' : '' }}>
                                                                <div class="form-checkbox__mark">
                                                                    <div class="form-checkbox__icon">
                                                                        <svg width="10" height="8"
                                                                            viewBox="0 0 10 8" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                                fill="white" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="lh-11 ml-10">{{ $special['label'] }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit button -->
                                    <div class="mt-30 d-flex flex-column gap-10">
                                        <button type="submit"
                                            class="button -sm -accent-1-dark bg-accent-1 text-white w-100">
                                            Apply Filters
                                        </button>

                                        <a href="{{ route('front.tours.index') }}" style="margin-top: 10px;"
                                            class="button -sm -outline-accent-1 text-accent-1 w-100">
                                            Reset Filters
                                        </a>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>

                    <div class="accordion d-none mb-30 lg:d-flex js-accordion">
                        <div class="accordion__item col-12">
                            <button class="accordion__button button -dark-1 bg-light-1 px-25 py-10 border-1 rounded-12">
                                <i class="icon-sort-down mr-10 text-16"></i>
                                Filter
                            </button>

                            <div class="accordion__content">
                                <div class="pt-20">
                                    <div class="sidebar -type-1 overflow-hidden rounded-12">
                                        <div class="sidebar__header bg-accent-1">
                                            <div class="text-15 text-white fw-500">When are you traveling?</div>

                                            <div class="mt-10">
                                                <div class="searchForm -type-1 -col-1 -narrow">
                                                    <div class="searchForm__form">
                                                        <div
                                                            class="searchFormItem js-select-control js-form-dd js-calendar">
                                                            <div class="searchFormItem__button" data-x-click="calendar">
                                                                <div class="pl-calendar d-flex items-center">
                                                                    <i class="icon-calendar text-20 mr-15"></i>
                                                                    <div>
                                                                        <span class="js-first-date">Add dates</span>
                                                                        <span class="js-last-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="searchFormItemDropdown -calendar"
                                                                data-x="calendar" data-x-toggle="is-active">
                                                                <div class="searchFormItemDropdown__container">

                                                                    <div
                                                                        class="searchMenu-date -searchForm js-form-dd js-calendar-el">
                                                                        <div class="searchMenu-date__field shadow-2"
                                                                            data-x-dd="searchMenu-date"
                                                                            data-x-dd-toggle="-is-active">
                                                                            <div class="bg-white rounded-4">
                                                                                <div
                                                                                    class="elCalendar js-calendar-el-calendar">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form method="GET" action="{{ route('front.tours.index') }}">

                                            <div class="sidebar__content">
                                                <!-- Tour Type -->
                                                <div class="sidebar__item">
                                                    <h5 class="text-18 fw-500">Tour Type</h5>
                                                    <div class="pt-15">
                                                        <div class="d-flex flex-column y-gap-15">
                                                            @php
                                                                $tourTypes = [
                                                                    'multi_day' => 'Multi-Day Tour',
                                                                    'day_trip' => 'Day Trip',
                                                                ];
                                                            @endphp

                                                            @foreach ($tourTypes as $typeKey => $typeLabel)
                                                                <div class="d-flex items-center">
                                                                    <div class="form-checkbox">
                                                                        <input type="radio" name="type"
                                                                            value="{{ $typeKey }}"
                                                                            {{ request('type') === $typeKey ? 'checked' : '' }}>
                                                                        <div class="form-checkbox__mark">
                                                                            <div class="form-checkbox__icon">
                                                                                <svg width="10" height="8"
                                                                                    viewBox="0 0 10 8" fill="none"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                                        fill="white" />
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="lh-11 ml-10">
                                                                        {{ $typeLabel }}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tour Category -->
                                                <div class="sidebar__item">
                                                    <h5 class="text-18 fw-500">Tour Category</h5>
                                                    <div class="pt-15">
                                                        <div class="d-flex flex-column y-gap-15">
                                                            @foreach ($tourCategories as $index => $category)
                                                                <div
                                                                    class="tour-category-item {{ $index >= 5 ? 'd-none' : '' }}">
                                                                    <div class="d-flex items-center">
                                                                        <div class="form-checkbox">
                                                                            <input type="checkbox" name="categories[]"
                                                                                value="{{ $category->id }}"
                                                                                {{ in_array($category->id, request()->input('categories', [])) ? 'checked' : '' }}>
                                                                            <div class="form-checkbox__mark">
                                                                                <div class="form-checkbox__icon">
                                                                                    <svg width="10" height="8"
                                                                                        viewBox="0 0 10 8" fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path
                                                                                            d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                                            fill="white" />
                                                                                    </svg>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="lh-11 ml-10">
                                                                            {{ $category->name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @if (count($tourCategories) > 1)
                                                            <a href="#" id="seeMoreTourCategories"
                                                                class="d-flex text-15 fw-500 text-accent-2 mt-15">
                                                                See More
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Filter price -->
                                                <div class="sidebar__item">
                                                    <div class="accordion -simple-2 js-accordion">
                                                        <div class="accordion__item js-accordion-item-active">
                                                            <div
                                                                class="accordion__button mb-10 d-flex items-center justify-between">
                                                                <h5 class="text-18 fw-500">Filter Price</h5>

                                                                <div class="accordion__icon flex-center">
                                                                    <i class="icon-chevron-down"></i>
                                                                    <i class="icon-chevron-down"></i>
                                                                </div>
                                                            </div>

                                                            <div class="accordion__content">
                                                                <div class="pt-15">
                                                                    <div class="js-price-rangeSlider">
                                                                        <div class="px-5">
                                                                            <input type="hidden" name="price[0]"
                                                                                class="js-lower-input"
                                                                                value="{{ request('price.0', $minPrice) }}">
                                                                            <input type="hidden" name="price[1]"
                                                                                class="js-upper-input"
                                                                                value="{{ request('price.1', $maxPrice) }}">

                                                                            <div class="js-slider"
                                                                                data-min="{{ $minPrice }}"
                                                                                data-max="{{ $maxPrice }}"
                                                                                data-start-lower="{{ request('price.0', $minPrice) }}"
                                                                                data-start-upper="{{ request('price.1', $maxPrice) }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex justify-between mt-20">
                                                                            <div>
                                                                                <span>Price:</span>
                                                                                <span
                                                                                    class="fw-500 js-lower">{{ request('price.0', $minPrice) }}</span>
                                                                                <span> - </span>
                                                                                <span
                                                                                    class="fw-500 js-upper">{{ request('price.1', $maxPrice) }}</span>
                                                                            </div>
                                                                            <div class="fw-500">
                                                                                Filter
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- Duration (Mobile Sidebar) -->
                                                <div class="sidebar__item">
                                                    <h5 class="text-18 fw-500">Duration</h5>
                                                    <div class="pt-15">
                                                        <div class="d-flex flex-column y-gap-15"
                                                            id="duration-list-mobile">
                                                            @foreach ($durations as $index => $duration)
                                                                <div
                                                                    class="{{ $index >= 5 ? 'd-none duration-hidden-mobile' : '' }}">
                                                                    <div class="d-flex items-center">
                                                                        <div class="form-checkbox">
                                                                            <input type="checkbox" name="duration[]"
                                                                                value="{{ $duration }}"
                                                                                {{ in_array($duration, $selectedDurations) ? 'checked' : '' }}>
                                                                            <div class="form-checkbox__mark">
                                                                                <div class="form-checkbox__icon">
                                                                                    <svg width="10" height="8"
                                                                                        viewBox="0 0 10 8" fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path
                                                                                            d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                                            fill="white" />
                                                                                    </svg>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="lh-11 ml-10">{{ $duration }}</div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @if (count($durations) > 5)
                                                            <button type="button"
                                                                class="d-flex text-15 fw-500 text-accent-2 mt-15"
                                                                id="seeMoreDurationsMobile">
                                                                See More
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>

                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        let toggles = [{
                                                                buttonId: 'seeMoreDurationsDesktop',
                                                                hiddenClass: '.duration-hidden-desktop'
                                                            },
                                                            {
                                                                buttonId: 'seeMoreDurationsMobile',
                                                                hiddenClass: '.duration-hidden-mobile'
                                                            }
                                                        ];

                                                        toggles.forEach(function(toggle) {
                                                            let btn = document.getElementById(toggle.buttonId);
                                                            if (btn) {
                                                                btn.addEventListener('click', function(e) {
                                                                    e.preventDefault();

                                                                    document.querySelectorAll(toggle.hiddenClass).forEach(el => {
                                                                        el.classList.toggle('d-none');
                                                                    });

                                                                    btn.textContent =
                                                                        btn.textContent.trim() === 'See More' ? 'See Less' : 'See More';
                                                                });
                                                            }
                                                        });
                                                    });
                                                </script>

                                                <!-- Rating -->
                                                <div class="sidebar__item">
                                                    <h5 class="text-18 fw-500">Rating</h5>
                                                    <div class="pt-15">
                                                        <div class="d-flex flex-column y-gap-15">
                                                            @foreach (range(5, 1) as $stars)
                                                                <div class="d-flex">
                                                                    <div class="form-checkbox">
                                                                        <input type="checkbox" name="ratings[]"
                                                                            value="{{ $stars }}"
                                                                            {{ in_array($stars, request('ratings', [])) ? 'checked' : '' }}>
                                                                        <div class="form-checkbox__mark">
                                                                            <div class="form-checkbox__icon">
                                                                                <svg width="10" height="8"
                                                                                    viewBox="0 0 10 8" fill="none"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                                        fill="white" />
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex x-gap-5 ml-10">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i
                                                                                class="flex-center icon-star {{ $i <= $stars ? 'text-yellow-2' : 'text-light-6' }} text-13"></i>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Specials -->
                                                <div class="sidebar__item">
                                                    <h5 class="text-18 fw-500">Specials</h5>
                                                    <div class="pt-15">
                                                        <div class="d-flex flex-column y-gap-15">
                                                            @php
                                                                $specials = [
                                                                    [
                                                                        'key' => 'free_cancellation',
                                                                        'label' => 'Free Cancellation',
                                                                    ],
                                                                    [
                                                                        'key' => 'bestseller',
                                                                        'label' => 'Bestseller',
                                                                    ],
                                                                ];

                                                                $selectedSpecials = request('specials', []);
                                                            @endphp


                                                            @foreach ($specials as $special)
                                                                <div>
                                                                    <div class="d-flex items-center">
                                                                        <div class="form-checkbox">
                                                                            <input type="checkbox" name="specials[]"
                                                                                value="{{ $special['key'] }}"
                                                                                {{ in_array($special['key'], $selectedSpecials) ? 'checked' : '' }}>
                                                                            <div class="form-checkbox__mark">
                                                                                <div class="form-checkbox__icon">
                                                                                    <svg width="10" height="8"
                                                                                        viewBox="0 0 10 8" fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path
                                                                                            d="M9.29082 0.971021C9.01235 0.692189 8.56018 0.692365 8.28134 0.971021L3.73802 5.51452L1.71871 3.49523C1.43988 3.21639 0.987896 3.21639 0.709063 3.49523C0.430231 3.77406 0.430231 4.22604 0.709063 4.50487L3.23309 7.0289C3.37242 7.16823 3.55512 7.23807 3.73783 7.23807C3.92054 7.23807 4.10341 7.16841 4.24274 7.0289L9.29082 1.98065C9.56965 1.70201 9.56965 1.24984 9.29082 0.971021Z"
                                                                                            fill="white" />
                                                                                    </svg>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="lh-11 ml-10">{{ $special['label'] }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Submit button -->
                                                <div class="mt-30 d-flex flex-column gap-10">
                                                    <button type="submit"
                                                        class="button -sm -accent-1-dark bg-accent-1 text-white w-100">
                                                        Apply Filters
                                                    </button>

                                                    <a href="{{ route('front.tours.index') }}" style="margin-top: 10px;"
                                                        class="button -sm -outline-accent-1 text-accent-1 w-100">
                                                        Reset Filters
                                                    </a>
                                                </div>

                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div data-anim-child="slide-up delay-2" class="col-xl-9 col-lg-8">
                    <div class="row y-gap-5 justify-between">
                        <div class="col-auto">
                            <div>{{ $tours->total() }} results</div>
                        </div>
                    </div>


                    <div class="row y-gap-30 pt-30">
                        @foreach ($tours as $tour)
                            @php
                                $cover = $tour->getFirstMedia('cover');
                                $coverUrl = $cover?->getUrl() ?? asset('img/default-tour.jpg');

                                $alt = $cover?->getCustomProperty('alt') ?? $tour->title;
                                $title = $cover?->getCustomProperty('title') ?? $tour->title;
                                $caption = $cover?->getCustomProperty('caption') ?? '';
                                $desc = $cover?->getCustomProperty('description') ?? '';
                            @endphp

                            @php
                                $reviewsCount = (int) ($tour->reviews_count ?? 0);
                                $rating = $tour->avg_rating ?? 0;
                            @endphp

                            <div class="col-lg-4 col-sm-6">
                                <div class="tourCard -type-1 py-10 px-10 border-1 rounded-12 -hover-shadow bg-white relative">
                                    <div class="tourCard__header">
                                        <div class="tourCard__image ratio ratio-28:20">
                                            <img src="{{ $coverUrl }}" alt="{{ $alt }}"
                                                title="{{ $title }}" data-caption="{{ $caption }}"
                                                data-description="{{ $desc }}" class="img-ratio rounded-12"
                                                loading="lazy" width="560" height="400">
                                        </div>

                                        <button class="tourCard__favorite js-favorite-btn swiper-no-swiping"
                                            data-id="{{ $tour->id }}" data-type="tour"
                                            aria-label="Add {{ $tour->title }} to favorites">
                                            <i class="icon-heart"></i>
                                        </button>
                                    </div>

                                    <div class="tourCard__content px-10 pt-10">
                                        @if (!empty($tour->location?->name))
                                            <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                                <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                                {{ $tour->location->name }}
                                            </div>
                                        @endif

                                        <h3 class="tourCard__title text-16 fw-500 mt-5">
                                            <a href="{{ route('front.tours.show', $tour->slug) }}" class="text-dark-1">
                                                <span>{{ Str::limit($tour->title, 50) }}</span>
                                            </a>
                                        </h3>

                                        <div class="tourCard__rating d-flex items-center text-13 mt-5">
                                            @if ($reviewsCount > 0)
                                                <div class="d-flex x-gap-5">
                                                    @php
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                    @endphp

                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <div><i class="icon-star text-10 text-yellow-2"></i></div>
                                                    @endfor
                                                    @if ($halfStar)
                                                        <div><i class="icon-star-half text-10 text-yellow-2"></i></div>
                                                    @endif
                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <div><i class="icon-star text-10 text-light-2"></i></div>
                                                    @endfor
                                                </div>

                                                <span class="text-dark-1 ml-10">
                                                    {{ number_format($rating, 1) }} ({{ $reviewsCount }})
                                                </span>
                                            @else
                                                <span class="text-accent-1 fw-500">New tour</span>
                                            @endif
                                        </div>

                                        <div class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                            <div class="d-flex items-center">
                                                <i class="icon-clock text-16 mr-5"></i>
                                                {{ $tour->duration }}
                                            </div>

                                            <div>
                                                @if ($tour->base_price > 0)
                                                    From <span class="text-16 fw-500">${{ number_format($tour->base_price, 2) }}</span>
                                                @else
                                                    <span class="text-14 fw-500">Contact for price</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    @if ($tours->lastPage() > 1)
                        <div class="d-flex justify-center flex-column mt-60">
                            <div class="pagination justify-center">

                                {{-- Previous Page Button --}}
                                @if ($tours->currentPage() > 1)
                                    <a href="{{ $tours->previousPageUrl() }}"
                                        class="pagination__button button -accent-1 mr-15 -prev">
                                        <i class="icon-arrow-left text-15"></i>
                                    </a>
                                @endif

                                <div class="pagination__count">
                                    {{-- Always show page 1 --}}
                                    @if ($tours->currentPage() == 1)
                                        <span class="is-active">1</span>
                                    @else
                                        <a href="{{ $tours->url(1) }}">1</a>
                                    @endif

                                    @php
                                        $start = max(2, $tours->currentPage() - 1);
                                        $end = min($tours->lastPage() - 1, $tours->currentPage() + 1);
                                    @endphp

                                    {{-- Show dots if there is a gap after page 1 --}}
                                    @if ($start > 2)
                                        <span class="pagination__dots">...</span>
                                    @endif

                                    {{-- Loop middle pages --}}
                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $tours->currentPage())
                                            <span class="is-active">{{ $page }}</span>
                                        @else
                                            <a href="{{ $tours->url($page) }}">{{ $page }}</a>
                                        @endif
                                    @endfor

                                    {{-- Show dots if there is a gap before last page --}}
                                    @if ($end < $tours->lastPage() - 1)
                                        <span class="pagination__dots">...</span>
                                    @endif

                                    {{-- Always show last page if more than 1 page --}}
                                    @if ($tours->lastPage() > 1 && $tours->currentPage() != $tours->lastPage())
                                        <a href="{{ $tours->url($tours->lastPage()) }}">{{ $tours->lastPage() }}</a>
                                    @elseif ($tours->lastPage() > 1 && $tours->currentPage() == $tours->lastPage())
                                        <span class="is-active">{{ $tours->lastPage() }}</span>
                                    @endif
                                </div>

                                {{-- Next Page Button --}}
                                @if ($tours->hasMorePages())
                                    <a href="{{ $tours->nextPageUrl() }}"
                                        class="pagination__button button -accent-1 ml-15 -next">
                                        <i class="icon-arrow-right text-15"></i>
                                    </a>
                                @endif
                            </div>

                            {{-- Pagination Info --}}
                            <div class="text-14 text-center mt-20">
                                Showing results {{ $tours->firstItem() }}-{{ $tours->lastItem() }} of
                                {{ $tours->total() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let btn = document.getElementById('seeMoreTourCategories');
            if (btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('.tour-category-item.d-none').forEach(el => {
                        el.classList.remove('d-none');
                    });
                    btn.style.display = 'none';
                });
            }
        });
    </script>
@endsection

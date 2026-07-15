@extends('front.layouts.app2')

@section('content')
    <section data-anim="fade" class="hero -type-1 -min">
        <div class="hero__bg">
            <figure class="m-0">
                <img src="{{ asset('assets/images/hero/sahara-desert-camel-trek-caravan-merzouga-morocco.webp') }}"
                    alt="Line of travelers riding camels in a caravan across the orange Sahara dunes near Merzouga, Morocco"
                    title="A camel caravan carries travelers across the golden dunes of the Sahara at Merzouga, Morocco.">
                <figcaption class="visually-hidden">
                    A single-file caravan of camels carries travelers over the rippling orange sand of Erg Chebbi
                    near Merzouga against a clear blue sky — one of the signature desert activities offered by
                    Authentic Morocco Adventures.
                </figcaption>
            </figure>

            <img src="{{ asset('assets/img/hero/1/shape.svg') }}" alt="decorative shape">
        </div>

        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="hero__content">
                        <h1 class="hero__title">
                            Discover Morocco’s Best Activities
                        </h1>

                        <p class="hero__text">
                            Embark on thrilling adventures and cultural experiences across Morocco. Find the perfect
                            activity to make your journey unforgettable.
                        </p>

                        <form method="GET" action="{{ route('front.activities.index') }}">
                            <div class="mt-30">
                                <div class="searchForm -type-1 -col-2">
                                    <div class="searchForm__form">

                                        {{-- ACTIVITY CATEGORY DROPDOWN --}}
                                        <div class="searchFormItem js-select-control js-form-dd">
                                            <div class="searchFormItem__button" data-x-click="category">
                                                <div class="searchFormItem__icon size-50 rounded-12 border-1 flex-center">
                                                    <i class="text-20 icon-pin"></i>
                                                </div>
                                                <div class="searchFormItem__content">
                                                    <h5>Category</h5>
                                                    <div class="js-select-control-chosen">
                                                        {{ $activityCategories->firstWhere('id', request('categories')[0] ?? null)?->name ?? 'Search activity types' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="searchFormItemDropdown -location" data-x="category"
                                                data-x-toggle="is-active">
                                                <div class="searchFormItemDropdown__container">
                                                    <div class="searchFormItemDropdown__list scroll-bar-1">
                                                        @foreach ($activityCategories as $category)
                                                            <div class="searchFormItemDropdown__item">
                                                                <button type="button" class="js-select-control-button"
                                                                    data-id="{{ $category->id }}"
                                                                    data-name="{{ $category->name }}"
                                                                    data-target="activityCategoryInput">
                                                                    <span
                                                                        class="js-select-control-choice">{{ $category->name }}</span>
                                                                    <span>Activity Type</span>
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- HIDDEN CATEGORY INPUT --}}
                                        <input type="hidden" name="categories[]" id="activityCategoryInput"
                                            value="{{ request('categories')[0] ?? '' }}">

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
                                // Handle category dropdown
                                document.querySelectorAll('.js-select-control-button').forEach(btn => {
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
                                        ['activityCategoryInput', 'groupSize'].forEach(id => {
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
                            Camel caravan crossing Morocco’s Sahara Desert dunes at sunset under a vivid orange and purple
                            sky.
                        </div>
                        <div style="display: none;">
                            Experience a camel trek through the golden dunes of Merzouga in Morocco’s Sahara Desert. As the
                            sun sets, vibrant skies create unforgettable moments for adventure travelers seeking unique
                            desert activities and cultural immersion.
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
                            <form method="GET" action="{{ route('front.activities.index') }}">

                                <div class="sidebar__content">
                                    <!-- Tour type -->
                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500">Tour Type</h5>
                                        <div class="pt-15">
                                            <div class="d-flex flex-column y-gap-15">
                                                @foreach ($activityCategories as $index => $category)
                                                    <div class="activity-category-item {{ $index >= 5 ? 'd-none' : '' }}">
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
                                                            <div class="lh-11 ml-10">{{ $category->name }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if (count($activityCategories) > 5)
                                                <a href="#" id="seeMoreActivityCategories"
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
                                            '1 Hours',
                                            '1.5 Hours',
                                            '2 Hours',
                                            '2.5 Hours',
                                            '3 Hours',
                                            '3.5 Hours',
                                            '4 Hours',
                                            '5 Hours',
                                            '6 Hours',
                                            '8 Hours',
                                        ];

                                        $selectedDurations = request()->input('duration', []);
                                    @endphp

                                    <div class="sidebar__item">
                                        <h5 class="text-18 fw-500">Duration</h5>
                                        <div class="pt-15">
                                            <div class="d-flex flex-column y-gap-15" id="duration-list-desktop">
                                                @foreach ($durations as $index => $duration)
                                                    <div class="{{ $index >= 5 ? 'd-none duration-hidden' : '' }}">
                                                        <div class="d-flex items-center">
                                                            <div class="form-checkbox">
                                                                <input type="checkbox" name="duration[]"
                                                                    value="{{ $duration }}"
                                                                    {{ in_array($duration, request('duration', [])) ? 'checked' : '' }}>
                                                                <div class="form-checkbox__mark">
                                                                    <div class="form-checkbox__icon">
                                                                        <!-- your SVG here -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="lh-11 ml-10">{{ $duration }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if (count($durations) > 5)
                                                <a href="#" data-action="see-more-durations"
                                                    data-target="#duration-list-desktop"
                                                    class="d-flex text-15 fw-500 text-accent-2 mt-15">
                                                    See More
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {

                                            const durationSeeMoreButtons = document.querySelectorAll('[data-action="see-more-durations"]');

                                            durationSeeMoreButtons.forEach(button => {
                                                button.addEventListener('click', function(e) {
                                                    e.preventDefault();

                                                    const containerSelector = this.getAttribute('data-target');
                                                    const container = document.querySelector(containerSelector);

                                                    if (!container) return;

                                                    const hiddenItems = container.querySelectorAll('.duration-hidden');

                                                    hiddenItems.forEach(item => {
                                                        item.classList.toggle('d-none');
                                                    });

                                                    if (this.textContent.trim() === 'See More') {
                                                        this.textContent = 'See Less';
                                                    } else {
                                                        this.textContent = 'See More';
                                                    }
                                                });
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

                                        <a href="{{ route('front.activities.index') }}" style="margin-top: 10px;"
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

                                        <form method="GET" action="{{ route('front.activities.index') }}">

                                            <div class="sidebar__content">
                                                <!-- Tour type -->
                                                <div class="sidebar__item">
                                                    <h5 class="text-18 fw-500">Tour Type</h5>
                                                    <div class="pt-15">
                                                        <div class="d-flex flex-column y-gap-15">
                                                            @foreach ($activityCategories as $index => $category)
                                                                <div
                                                                    class="activity-category-item {{ $index >= 5 ? 'd-none' : '' }}">
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
                                                                        <div class="lh-11 ml-10">{{ $category->name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @if (count($activityCategories) > 5)
                                                            <a href="#" id="seeMoreActivityCategories"
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

                                                <div class="sidebar__item">
                                                    <h5 class="text-18 fw-500">Duration</h5>
                                                    <div class="pt-15">
                                                        <div class="d-flex flex-column y-gap-15"
                                                            id="duration-list-mobile">
                                                            @foreach ($durations as $index => $duration)
                                                                <div
                                                                    class="{{ $index >= 5 ? 'd-none duration-hidden' : '' }}">
                                                                    <div class="d-flex items-center">
                                                                        <div class="form-checkbox">
                                                                            <input type="checkbox" name="duration[]"
                                                                                value="{{ $duration }}"
                                                                                {{ in_array($duration, request('duration', [])) ? 'checked' : '' }}>
                                                                            <div class="form-checkbox__mark">
                                                                                <div class="form-checkbox__icon">
                                                                                    <!-- your SVG here -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="lh-11 ml-10">{{ $duration }}</div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @if (count($durations) > 5)
                                                            <a href="#" data-action="see-more-durations"
                                                                data-target="#duration-list-mobile"
                                                                class="d-flex text-15 fw-500 text-accent-2 mt-15">
                                                                See More
                                                            </a>
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

                                                    <a href="{{ route('front.activities.index') }}"
                                                        style="margin-top: 10px;"
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
                            <div>{{ $activities->total() }} results</div>
                        </div>
                    </div>


                    <div class="row y-gap-30 pt-30">
                        @foreach ($activities as $activity)
                            @php
                                $cover = $activity->getFirstMedia('cover');
                                $coverUrl = $cover?->getUrl() ?? asset('img/default-activity.jpg');

                                $alt = $cover?->getCustomProperty('alt') ?? $activity->title;
                                $title = $cover?->getCustomProperty('title') ?? $activity->title;
                                $caption = $cover?->getCustomProperty('caption') ?? '';
                                $desc = $cover?->getCustomProperty('description') ?? '';
                            @endphp

                            @php
                                $reviewsCount = (int) ($activity->reviews_count ?? 0);
                                $rating = $activity->avg_rating ?? 0;
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
                                            data-id="{{ $activity->id }}" data-type="activity"
                                            aria-label="Add {{ $activity->title }} to favorites">
                                            <i class="icon-heart"></i>
                                        </button>
                                    </div>

                                    <div class="tourCard__content px-10 pt-10">
                                        <div class="tourCard__location d-flex items-center text-13 text-light-2">
                                            <i class="icon-pin d-flex text-16 text-light-2 mr-5"></i>
                                            {{ $activity->location->name ?? 'Marrakech' }}
                                        </div>

                                        <h3 class="tourCard__title text-16 fw-500 mt-5">
                                            <a href="{{ route('front.activities.show', $activity->slug) }}" class="text-dark-1">
                                                <span>{{ Str::limit($activity->title, 50) }}</span>
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
                                                <span class="text-accent-1 fw-500">New activity</span>
                                            @endif
                                        </div>

                                        <div class="d-flex justify-between items-center border-1-top text-13 text-dark-1 pt-10 mt-10">
                                            <div class="d-flex items-center">
                                                <i class="icon-clock text-16 mr-5"></i>
                                                {{ $activity->duration }}
                                            </div>

                                            <div>
                                                @if ($activity->base_price > 0)
                                                    From <span class="text-16 fw-500">${{ number_format($activity->base_price, 2) }}</span>
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


                    @if ($activities->lastPage() > 1)
                        <div class="d-flex justify-center flex-column mt-60">
                            <div class="pagination justify-center">

                                {{-- Previous Page Button --}}
                                @if ($activities->currentPage() > 1)
                                    <a href="{{ $activities->previousPageUrl() }}"
                                        class="pagination__button button -accent-1 mr-15 -prev">
                                        <i class="icon-arrow-left text-15"></i>
                                    </a>
                                @endif

                                <div class="pagination__count">
                                    {{-- Always show page 1 --}}
                                    @if ($activities->currentPage() == 1)
                                        <span class="is-active">1</span>
                                    @else
                                        <a href="{{ $activities->url(1) }}">1</a>
                                    @endif

                                    @php
                                        $start = max(2, $activities->currentPage() - 1);
                                        $end = min($activities->lastPage() - 1, $activities->currentPage() + 1);
                                    @endphp

                                    {{-- Show dots if there is a gap after page 1 --}}
                                    @if ($start > 2)
                                        <span class="pagination__dots">...</span>
                                    @endif

                                    {{-- Loop middle pages --}}
                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $activities->currentPage())
                                            <span class="is-active">{{ $page }}</span>
                                        @else
                                            <a href="{{ $activities->url($page) }}">{{ $page }}</a>
                                        @endif
                                    @endfor

                                    {{-- Show dots if there is a gap before last page --}}
                                    @if ($end < $activities->lastPage() - 1)
                                        <span class="pagination__dots">...</span>
                                    @endif

                                    {{-- Always show last page if more than 1 page --}}
                                    @if ($activities->lastPage() > 1 && $activities->currentPage() != $activities->lastPage())
                                        <a
                                            href="{{ $activities->url($activities->lastPage()) }}">{{ $activities->lastPage() }}</a>
                                    @elseif ($activities->lastPage() > 1 && $activities->currentPage() == $activities->lastPage())
                                        <span class="is-active">{{ $activities->lastPage() }}</span>
                                    @endif
                                </div>

                                {{-- Next Page Button --}}
                                @if ($activities->hasMorePages())
                                    <a href="{{ $activities->nextPageUrl() }}"
                                        class="pagination__button button -accent-1 ml-15 -next">
                                        <i class="icon-arrow-right text-15"></i>
                                    </a>
                                @endif
                            </div>

                            {{-- Pagination Info --}}
                            <div class="text-14 text-center mt-20">
                                Showing results {{ $activities->firstItem() }}-{{ $activities->lastItem() }} of
                                {{ $activities->total() }}
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let btn = document.getElementById('seeMoreActivityCategories');
            if (btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('.activity-category-item.d-none').forEach(el => {
                        el.classList.remove('d-none');
                    });
                    btn.style.display = 'none';
                });
            }
        });
    </script>

@endsection

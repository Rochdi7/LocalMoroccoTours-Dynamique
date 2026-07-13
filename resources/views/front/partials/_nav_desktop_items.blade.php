{{-- Shared desktop mega-menu items. Used by _header and _header2.
     Data comes from the View composer in AppServiceProvider:
     $navMultiDayByCity, $navDayTripsByCity, $navActivities, $navTrekkings. --}}

{{-- ===== MOROCCO TOURS (multi-day) grouped by city ===== --}}
<div class="desktopNav__item megaNav__item">
    <a href="{{ route('front.tours.index', ['type' => 'multi_day']) }}">
        Morocco Tours <i class="icon-chevron-down"></i>
    </a>
    <ul class="megaFlyout">
        @forelse ($navMultiDayByCity as $city => $tours)
            @php $citySlug = \Illuminate\Support\Str::slug($city); @endphp
            <li class="megaFlyout__li -has-sub">
                <a href="{{ route('front.tours.index', ['type' => 'multi_day', 'location_slug' => $citySlug]) }}">
                    From {{ \Illuminate\Support\Str::before($city, ',') }}
                </a>
                <ul class="megaFlyout__sub">
                    <li class="megaFlyout__head">From {{ \Illuminate\Support\Str::before($city, ',') }}</li>
                    @foreach ($tours as $tour)
                        <li class="megaFlyout__li">
                            <a href="{{ route('front.tours.show', $tour->slug) }}">{{ $tour->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @empty
            <li class="megaFlyout__li">
                <a href="{{ route('front.tours.index') }}">All Tours</a>
            </li>
        @endforelse
    </ul>
</div>

{{-- ===== DAY TRIPS grouped by city ===== --}}
<div class="desktopNav__item megaNav__item">
    <a href="{{ route('front.tours.index', ['type' => 'day_trip']) }}">
        Day Trips <i class="icon-chevron-down"></i>
    </a>
    <ul class="megaFlyout">
        @forelse ($navDayTripsByCity as $city => $tours)
            @php $citySlug = \Illuminate\Support\Str::slug($city); @endphp
            <li class="megaFlyout__li -has-sub">
                <a href="{{ route('front.tours.index', ['type' => 'day_trip', 'location_slug' => $citySlug]) }}">
                    {{ \Illuminate\Support\Str::before($city, ',') }} excursions
                </a>
                <ul class="megaFlyout__sub">
                    <li class="megaFlyout__head">{{ \Illuminate\Support\Str::before($city, ',') }} excursions</li>
                    @foreach ($tours as $tour)
                        <li class="megaFlyout__li">
                            <a href="{{ route('front.tours.show', $tour->slug) }}">{{ $tour->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @empty
            <li class="megaFlyout__li">
                <a href="{{ route('front.tours.index', ['type' => 'day_trip']) }}">All Day Trips</a>
            </li>
        @endforelse
    </ul>
</div>

{{-- ===== ACTIVITIES (flat) ===== --}}
<div class="desktopNav__item megaNav__item -flip">
    <a href="{{ route('front.activities.index') }}">
        Activities <i class="icon-chevron-down"></i>
    </a>
    <ul class="megaFlyout -flat">
        @foreach ($navActivities as $activity)
            <li class="megaFlyout__li">
                <a href="{{ route('front.activities.show', $activity->slug) }}">{{ $activity->title }}</a>
            </li>
        @endforeach
    </ul>
</div>

{{-- ===== ATLAS & TOUBKAL (trekking, flat) ===== --}}
<div class="desktopNav__item megaNav__item -flip">
    <a href="{{ route('front.trekking.index') }}">
        Atlas & Toubkal <i class="icon-chevron-down"></i>
    </a>
    <ul class="megaFlyout -flat">
        @foreach ($navTrekkings as $trek)
            <li class="megaFlyout__li">
                <a href="{{ route('front.trekking.show', $trek->slug) }}">{{ $trek->title }}</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="desktopNav__item">
    <a href="{{ route('blog.index') }}">Blog</a>
</div>
<div class="desktopNav__item">
    <a href="{{ route('front.contact') }}">Contact</a>
</div>

{{-- Help & Info dropdown --}}
<div class="desktopNav__item">
    <a href="#">
        Help & Info <i class="icon-chevron-down"></i>
    </a>
    <div class="desktopNavSubnav">
        <div class="desktopNavSubnav__content">
            <div class="desktopNavSubnav__item">
                <a href="{{ route('front.about') }}">About</a>
            </div>
            <div class="desktopNavSubnav__item">
                <a href="{{ route('front.help-center') }}">Help Center</a>
            </div>
            <div class="desktopNavSubnav__item">
                <a href="{{ route('front.terms') }}">Terms & Conditions</a>
            </div>
        </div>
    </div>
</div>

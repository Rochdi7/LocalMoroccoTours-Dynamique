@php
    $raw = trim($frame ?? '');
    $src = null;

    if (preg_match('/<iframe[^>]*src=["\']([^"\']+)["\']/i', $raw, $matches)) {
        $src = $matches[1];
    } elseif (preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', $raw)) {
        [$lat, $lng] = array_map('trim', explode(',', $raw));
        $src = "https://maps.google.com/maps?q={$lat},{$lng}&z=12&output=embed";
    }
@endphp

@if ($src)
    <div class="mapTourSingle__content rounded-12 js-map-tour">
        <iframe src="{{ $src }}" style="width: 100%; height: 100%; border: 0;" allowfullscreen loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
@endif

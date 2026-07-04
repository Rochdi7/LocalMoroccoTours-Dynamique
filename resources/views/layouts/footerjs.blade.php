<!-- Required Js -->
<script src="{{ URL::asset('build/js/plugins/popper.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/i18next.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/i18nextHttpBackend.min.js') }}"></script>
<script src="{{ URL::asset('build/js/icon/custom-font.js') }}"></script>
<script src="{{ URL::asset('build/js/script.js') }}"></script>
<script src="{{ URL::asset('build/js/theme.js') }}"></script>
<script src="{{ URL::asset('build/js/multi-lang.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/feather.min.js') }}"></script>

@php
    // env() auto-casts the strings "true"/"false" to real booleans, so normalize
    // everything back to plain 'true'/'false' strings before comparing below.
    $normalizeBool = function ($value, $default) {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        return $value === null || $value === '' ? $default : (string) $value;
    };

    $darkLayout = $normalizeBool(env('APP_DARK_LAYOUT'), 'false');
    $darkNavbar = $normalizeBool(env('APP_DARK_NAVBAR'), 'false');
    $boxContainer = $normalizeBool(env('APP_BOX_CONTAINER'), 'false');
    $captionShow = $normalizeBool(env('APP_CAPTION_SHOW'), 'true');
    $rtlLayout = $normalizeBool(env('APP_RTL_LAYOUT'), 'false');
    $presetTheme = $normalizeBool(env('APP_PRESET_THEME'), '');
@endphp

@if ($darkLayout === 'default')
<script>
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        dark_layout = 'true';
    } else {
        dark_layout = 'false';
    }
    layout_change_default();
    if (dark_layout == 'true') {
        layout_change('dark');
    } else {
        layout_change('light');
    }
</script>
@elseif ($darkLayout === 'true')
    <script>
        layout_change('dark');
    </script>
@else
    <script>
        layout_change('light');
    </script>
@endif


@if ($darkNavbar === 'true')
    <script>
        layout_sidebar_change('dark');
    </script>
@else
    <script>
        layout_sidebar_change('light');
    </script>
@endif

@if ($boxContainer === 'true')
    <script>
        change_box_container('true');
    </script>
@else
    <script>
        change_box_container('false');
    </script>
@endif

@if ($captionShow === 'true')
    <script>
        layout_caption_change('true');
    </script>
@else
    <script>
        layout_caption_change('false');
    </script>
@endif

@if ($rtlLayout === 'true')
    <script>
        layout_rtl_change('true');
    </script>
@else
    <script>
        layout_rtl_change('false');
    </script>
@endif

@if ($presetTheme !== '')
    <script>
        preset_change("{{ $presetTheme }}");
    </script>
@endif

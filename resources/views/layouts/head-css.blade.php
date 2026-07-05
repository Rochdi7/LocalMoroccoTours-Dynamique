<script>
    // Apply a saved manual dark/light choice before CSS paints, so there's no flash
    // of the wrong theme while footerjs.blade.php's script (loaded at the bottom) runs.
    (function () {
        try {
            var saved = localStorage.getItem('pc_dark_layout');
            if (saved === 'dark' || saved === 'light') {
                document.documentElement.setAttribute('data-pc-theme', saved);
                // <body> doesn't exist yet at this point in <head>; theme.js corrects
                // it on DOMContentLoaded via footerjs.blade.php using the same saved value.
            }
        } catch (e) {}
    })();
</script>

<!-- [Google Font : Public Sans] icon -->
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

 <!-- [phosphor Icons] https://phosphoricons.com/ -->
<link rel="stylesheet" href="{{ URL::asset('build/fonts/phosphor/duotone/style.css') }}" />
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="{{ URL::asset('build/fonts/tabler-icons.min.css') }}">
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="{{ URL::asset('build/fonts/feather.css') }}">
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="{{ URL::asset('build/fonts/fontawesome.css') }}">
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="{{ URL::asset('build/fonts/material.css') }}">
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{ URL::asset('build/css/style.css') }}" id="main-style-link">
<link rel="stylesheet" href="{{ URL::asset('build/css/style-preset.css') }}">

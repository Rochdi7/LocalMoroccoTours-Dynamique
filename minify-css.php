<?php

require __DIR__ . '/vendor/autoload.php';

use MatthiasMullie\Minify;

/**
 * Minify CSS files
 */
$cssFiles = [
    'public/assets/css/vendors.css',
    'public/assets/css/main.css',
];

foreach ($cssFiles as $file) {
    $minifier = new Minify\CSS($file);

    $minifiedPath = str_replace('.css', '.min.css', $file);
    $minifier->minify($minifiedPath);

    echo "Minified CSS: $file → $minifiedPath\n";
}

/**
 * Minify JS files
 */
$jsFiles = [
    'public/assets/js/vendors.js',
    'public/assets/js/main.js',
    'public/assets/js/favorites-trekking.js',
    'public/assets/js/favorites-activities.js',
    'public/assets/js/favorites-tours.js',
    'public/assets/js/homepage.js',
];

foreach ($jsFiles as $file) {
    $minifier = new Minify\JS($file);

    $minifiedPath = str_replace('.js', '.min.js', $file);
    $minifier->minify($minifiedPath);

    echo "Minified JS: $file → $minifiedPath\n";
}

echo "✅ All minification done!\n";

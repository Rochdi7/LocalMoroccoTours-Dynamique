<?php

require __DIR__ . '/vendor/autoload.php';

use MatthiasMullie\Minify;

/**
 * Minify JS files
 */
$jsFiles = [
    'public/assets/js/vendors.js',
    'public/assets/js/main.js',
    'public/assets/js/favorites-trekking.js',
    'public/assets/js/favorites-activities.js',
    'public/assets/js/favorites-tours.js',
    'public/assets/js/favorites.js',
    'public/assets/js/homepage.js',
];

foreach ($jsFiles as $file) {
    $minifier = new Minify\JS($file);
    $minifiedPath = str_replace('.js', '.min.js', $file);
    $minifier->minify($minifiedPath);
    echo "Minified JS: $file → $minifiedPath\n";
}

echo "✅ JS minification done!\n";

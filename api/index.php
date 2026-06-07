<?php

// Force error display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fix for Vercel: Create storage directories in /tmp
$storagePaths = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/logs',
];

foreach ($storagePaths as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

// Override environment variables
putenv("VIEW_COMPILED_PATH=/tmp/storage/framework/views");
putenv("LOG_CHANNEL=stderr");
putenv("APP_DEBUG=true");
putenv("APP_ENV=production");

// Load the application
require __DIR__ . '/../public/index.php';

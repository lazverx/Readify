<?php

// Prepare /tmp/storage directories for Vercel serverless environment
$storage = '/tmp/storage';
foreach ([
    $storage . '/framework/views',
    $storage . '/framework/cache',
    $storage . '/framework/cache/data',
    $storage . '/framework/sessions',
    $storage . '/logs',
] as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0755, true);
    }
}

// Forward request to Laravel entry point
require __DIR__ . '/../public/index.php';

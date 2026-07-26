<?php

// Root Front-Controller Router for Wasmer / PHPIX / Built-in Web Server
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

// Serve static assets from /public directory directly if they exist
$publicFilePath = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($publicFilePath) && !is_dir($publicFilePath)) {
    // Set appropriate MIME type if needed
    $ext = pathinfo($publicFilePath, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf',
    ];

    if (isset($mimeTypes[$ext])) {
        header("Content-Type: {$mimeTypes[$ext]}");
    }

    readfile($publicFilePath);
    exit;
}

require __DIR__ . '/public/index.php';

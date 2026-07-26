<?php

// Front-controller router script for PHP built-in web server and Wasmer PHPIX.
// If the requested resource is a static file that exists in /public, serve it directly.
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$filePath = __DIR__ . $uri;

if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false; // Serve static file directly
}

require_once __DIR__ . '/index.php';

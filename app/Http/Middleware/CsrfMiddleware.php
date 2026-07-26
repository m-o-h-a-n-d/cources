<?php

namespace App\Http\Middleware;

use Core\MiddlewareInterface;
use RuntimeException;

class CsrfMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Generate token if not exists
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Validate token on state-changing HTTP methods
        if (in_array(strtoupper($method), ['POST', 'PUT', 'DELETE', 'PATCH'], true)) {
            $token = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

            if (!$token || !hash_equals($_SESSION['_csrf_token'], $token)) {
                http_response_code(403);
                die('403 Forbidden: Invalid or missing CSRF token.');
            }
        }
    }
}

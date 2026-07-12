<?php

namespace App\Http\Middleware;

use Core\MiddlewareInterface;

class AdminMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        if (
            !isset($_SESSION['auth']) ||
            $_SESSION['auth']['role'] !== 'admin'
        ) {
            header('Location: /admin/login');
            exit;
        }
    }
}
<?php

namespace App\Http\Middleware;

class AdminMiddleware
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
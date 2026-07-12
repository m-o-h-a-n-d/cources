<?php

namespace App\Http\Middleware;

use Core\MiddlewareInterface;


class StudentMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        if (
            !isset($_SESSION['auth']) ||
            $_SESSION['auth']['role'] !== 'student'
        ) {
            header('Location: /student/login');
            exit;
        }
    }
}
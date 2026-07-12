<?php

namespace App\Http\Middleware;

class StudentMiddleware
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
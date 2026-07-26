<?php

namespace App\Http\Controllers;

class FrontendController
{
    public function adminDashboard()
    {
        $this->requireAuth('admin');
        return view('admin/dashboard');
    }

    public function landing(){
        return view('landing');
        }

    private function requireAuth(string $role): void
    {
        $currentRole = $_SESSION['auth']['role'] ?? null;
        if ($currentRole === $role) {
            return;
        }

        $target = $role === 'admin' ? '/admin/login' : '/student/login';
        header('Location: ' . $target);
        exit;
    }
}

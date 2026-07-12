<?php

namespace App\Http\Controllers;

use App\Model\Student;

class AuthController
{
    public function studentLoginForm()
    {
        if ($this->isAuthenticatedAs('student')) {
            header('Location: /student');
            exit;
        }

        return view('auth/student-login');
    }

    public function adminLoginForm()
    {
        if ($this->isAuthenticatedAs('admin')) {
            header('Location: /admin');
            exit;
        }

        return view('auth/admin-login');
    }

    public function studentLogin()
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            header('Location: /student/login?error=1');
            exit;
        }

        $user = Student::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            header('Location: /student/login?error=1');
            exit;
        }

        $_SESSION['auth'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => 'student',
        ];

        header('Location: /student');
        exit;
    }

    public function adminLogin()
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $admin = require base_path('config/admin.php');

        if (
            $email !== $admin['email'] ||
            !password_verify($password, $admin['password'])
        ) {
            header('Location: /admin/login?error=1');
            exit;
        }

        $_SESSION['auth'] = [
            'email' => $admin['email'],
            'role' => 'admin',
        ];

        header('Location: /admin');
        exit;
    }

    public function logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: /student/login');
        exit;
    }

    private function isAuthenticatedAs(string $role): bool
    {
        return isset($_SESSION['auth'])
            && $_SESSION['auth']['role'] === $role;
    }
}
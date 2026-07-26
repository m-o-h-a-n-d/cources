<?php

namespace App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Legacy AuthController (Commented Out)
|--------------------------------------------------------------------------
|
| This file has been commented out as requested. Authenticaton has been
| upgraded to JWT with Single Active Device Session support in JwtAuthController.
|

use App\Model\Student;
use App\Http\Requests\LoginRequest;

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
        $request = new LoginRequest();

        if ($request->fails()) {
            $_SESSION['errors'] = $request->errors();
            header('Location: /student/login?error=1');
            exit;
        }

        $email = trim($request->input('email'));
        $password = trim($request->input('password'));

        $user = Student::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            header('Location: /student/login?error=1');
            exit;
        }

        session_regenerate_id(true);

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
        $request = new LoginRequest();

        if ($request->fails()) {
            $_SESSION['errors'] = $request->errors();
            header('Location: /admin/login?error=1');
            exit;
        }

        $email = trim($request->input('email'));
        $password = trim($request->input('password'));

        $admin = require base_path('config/admin.php');

        if (
            $email !== $admin['email'] ||
            !password_verify($password, $admin['password'])
        ) {
            header('Location: /admin/login?error=1');
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['auth'] = [
            'email' => $admin['email'],
            'role' => 'admin',
        ];

        header('Location: /admin');
        exit;
    }

    public function logout()
    {
        $isAdmin = isset($_SESSION['auth']) && $_SESSION['auth']['role'] === 'admin';
        $isStudent = isset($_SESSION['auth']) && $_SESSION['auth']['role'] === 'student';

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

        if ($isAdmin) {
            header('Location: /admin/login');
        } elseif ($isStudent) {
            header('Location: /student/login');
        } else {
            header('Location: /');
        }

        exit;
    }

    private function isAuthenticatedAs(string $role): bool
    {
        return isset($_SESSION['auth'])
            && $_SESSION['auth']['role'] === $role;
    }
}
*/
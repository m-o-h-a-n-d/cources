<?php

namespace App\Http\Controllers;

class FrontendController
{
    public function landing()
    {
        return view('landing');
    }

    public function login()
    {
        header('Location: /student/login');
        exit;
    }

    public function studentDashboard()
    {
        $this->requireAuth('student');
        return view('dashboard/student');
    }

    public function courses()
    {
        $this->requireAuth('student');
        return view('courses/index');
    }

    public function courseDetails()
    {
        $this->requireAuth('student');
        return view('courses/details');
    }

    public function profile()
    {
        $this->requireAuth('student');
        return view('profile/index');
    }

    public function myCourses()
    {
        $this->requireAuth('student');
        return view('my-courses/index');
    }

    public function adminDashboard()
    {
        $this->requireAuth('admin');
        return view('admin/dashboard');
    }

    public function studentsManagement()
    {
        $this->requireAuth('admin');
        return view('admin/students');
    }

    public function coursesManagement()
    {
        $this->requireAuth('admin');
        return view('admin/courses');
    }

    public function departmentsManagement()
    {
        $this->requireAuth('admin');
        return view('admin/departments');
    }

    public function registrationsManagement()
    {
        $this->requireAuth('admin');
        return view('admin/registrations');
    }

    public function emptyState()
    {
        return view('states/empty');
    }

    public function loadingState()
    {
        return view('states/loading');
    }

    public function toastState()
    {
        return view('states/toasts');
    }

    public function modalState()
    {
        return view('states/modals');
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

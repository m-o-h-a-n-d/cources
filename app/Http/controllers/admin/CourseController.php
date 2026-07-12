<?php 

namespace App\Http\Controllers\Admin;

use App\Model\Department;
use App\Services\CourseServices;

class CourseController
{
    public function __construct(protected CourseServices $courseServices)
    {
    }

    public function index()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $courses = $this->courseServices->getAllCourses();
        $departments = Department::all();

        return view('admin/courses', compact('courses', 'departments'));
    }

    public function store()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'department_id' => (int) ($_POST['department_id'] ?? 0),
        ];

        if (empty($data['name']) || empty($data['department_id'])) {
            header('Location: /admin/courses?error=required');
            exit;
        }

        $this->courseServices->createCourse($data);

        header('Location: /admin/courses?success=created');
        exit;
    }

    public function delete()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $courseId = (int) ($_POST['id'] ?? 0);
        if ($courseId <= 0) {
            header('Location: /admin/courses?error=delete');
            exit;
        }

        $this->courseServices->deleteCourse($courseId);

        header('Location: /admin/courses?success=deleted');
        exit;
    }

    public function update()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $courseId = (int) ($_POST['id'] ?? 0);
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'department_id' => (int) ($_POST['department_id'] ?? 0),
        ];

        if ($courseId <= 0 || empty($data['name']) || empty($data['department_id'])) {
            header('Location: /admin/courses?error=required');
            exit;
        }

        $this->courseServices->updateCourse($courseId, $data);

        header('Location: /admin/courses?success=updated');
        exit;
    }

    private function isAdminAuthenticated(): bool
    {
        return isset($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin';
    }
}
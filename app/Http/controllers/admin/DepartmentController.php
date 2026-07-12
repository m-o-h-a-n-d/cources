<?php  

namespace App\Http\Controllers\Admin;

use App\Services\DepartmentServices;

class DepartmentController{

    public function __construct(protected DepartmentServices $departmentServices)
    {
        // Constructor logic if needed
    }

    public function index()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $departments = $this->departmentServices->getAllDepartments();

        return view('admin/departments', compact('departments'));
    }

    public function store()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $payload = [
            'name' => trim($_POST['name'] ?? ''),
        ];

        $requiredFields = ['name'];
        foreach ($requiredFields as $field) {
            if (empty($payload[$field])) {
                header('Location: /admin/departments?error=required');
                exit;
            }
        }

        $this->departmentServices->createDepartment($payload);

        header('Location: /admin/departments?success=created');
        exit;
    }

    public function update()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $departmentId = (int) ($_POST['id'] ?? 0);
        $payload = [
            'name' => trim($_POST['name'] ?? ''),
        ];

        $requiredFields = ['name'];
        foreach ($requiredFields as $field) {
            if (empty($payload[$field])) {
                header('Location: /admin/departments?error=required');
                exit;
            }
        }

        $this->departmentServices->updateDepartment($departmentId, $payload);

        header('Location: /admin/departments?success=updated');
        exit;
    }


    public function delete()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $departmentId = (int) ($_POST['id'] ?? 0);

        $this->departmentServices->deleteDepartment($departmentId);

        header('Location: /admin/departments?success=deleted');
        exit;
    }

    private function isAdminAuthenticated(): bool
    {
        return isset($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin';
    }
}
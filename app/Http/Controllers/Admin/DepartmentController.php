<?php  

namespace App\Http\Controllers\Admin;

use App\Services\DepartmentServices;
use App\Http\Requests\DepartmentRequest;

class DepartmentController
{
    public function __construct(protected DepartmentServices $departmentServices)
    {
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
        $request = new DepartmentRequest();

        // Strict Abort: If validation fails, abort immediately before DB calls
        if ($request->fails()) {
            session_flash('errors', $request->errors());
            header('Location: /admin/departments');
            exit;
        }

        $payload = [
            'name' => trim($request->input('name')),
        ];

        $this->departmentServices->createDepartment($payload);

        session_flash('success', 'تم إضافة القسم بنجاح.');
        header('Location: /admin/departments');
        exit;
    }

    public function update()
    {
        $request = new DepartmentRequest();

        // Strict Abort: If validation fails, abort immediately before DB calls
        if ($request->fails()) {
            session_flash('errors', $request->errors());
            header('Location: /admin/departments');
            exit;
        }

        $departmentId = (int) $request->input('id');
        $payload = [
            'name' => trim($request->input('name')),
        ];

        $this->departmentServices->updateDepartment($departmentId, $payload);

        session_flash('success', 'تم تعديل اسم القسم بنجاح.');
        header('Location: /admin/departments');
        exit;
    }

    public function delete()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $departmentId = (int) ($_POST['id'] ?? 0);

        if ($departmentId <= 0) {
            session_flash('error', 'تعذر حذف القسم.');
            header('Location: /admin/departments');
            exit;
        }

        $this->departmentServices->deleteDepartment($departmentId);

        session_flash('success', 'تم حذف القسم بنجاح.');
        header('Location: /admin/departments');
        exit;
    }

    private function isAdminAuthenticated(): bool
    {
        return isset($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin';
    }
}
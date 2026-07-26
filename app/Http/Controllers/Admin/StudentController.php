<?php  

namespace App\Http\Controllers\Admin; 

use App\Model\Department;
use App\Services\StudentServices;
use App\Utility\ImageManager;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;

class StudentController
{
    private $studentService;

    public function __construct(StudentServices $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $data = $this->studentService->getAllStudents();
        $departments = Department::all();

        return view('admin/students', compact('data', 'departments'));
    }

    public function store()
    {
        $request = new StudentStoreRequest();

        // Strict Abort: If validation fails, abort immediately before DB calls
        if ($request->fails()) {
            session_flash('errors', $request->errors());
            header('Location: /admin/students');
            exit;
        }

        if (empty($_FILES['image']) || empty($_FILES['image']['tmp_name'])) {
            session_flash('error', 'يرجى رفع صورة الطالب.');
            header('Location: /admin/students');
            exit;
        }

        $payload = [
            'student_id'   => trim($request->input('student_id')),
            'full_name'    => trim($request->input('full_name')),
            'email'        => trim($request->input('email')),
            'password'     => password_hash(trim($request->input('password')), PASSWORD_DEFAULT),
            'age'          => (int) $request->input('age'),
            'gender'       => trim($request->input('gender')),
            'phone'        => trim($request->input('phone')),
            'parent_phone' => trim($request->input('parent_phone')),
            'address'      => trim($request->input('address')),
            'dep_id'       => (int) $request->input('dep_id'),
        ];

        $payload['image'] = ImageManager::uploadImage($_FILES['image'], 'students');

        $this->studentService->createStudent($payload);
        session_flash('success', 'تمت إضافة الطالب بنجاح.');
        header('Location: /admin/students');
        exit;
    }

    public function delete()
    {
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $studentId = (int) ($_POST['student_id'] ?? 0);
        if ($studentId <= 0) {
            session_flash('error', 'عذراً، متعذر حذف الطالب.');
            header('Location: /admin/students');
            exit;
        }

        $this->studentService->deleteStudent($studentId);
        session_flash('success', 'تم حذف الطالب بنجاح.');
        header('Location: /admin/students');
        exit;
    }

    public function update()
    {
        $request = new StudentUpdateRequest();

        // Strict Abort: If validation fails, abort immediately before DB calls
        if ($request->fails()) {
            session_flash('errors', $request->errors());
            header('Location: /admin/students');
            exit;
        }

        $studentId = (int) $request->input('record_id');

        $payload = [
            'student_id'    => trim($request->input('student_id')),
            'full_name'     => trim($request->input('full_name')),
            'email'         => trim($request->input('email')),
            'age'           => (int) $request->input('age'),
            'gender'        => trim($request->input('gender')),
            'phone'         => trim($request->input('phone')),
            'parent_phone'  => trim($request->input('parent_phone')),
            'address'       => trim($request->input('address')),
            'dep_id'        => (int) $request->input('dep_id'),
            'current_image' => trim($request->input('current_image')),
        ];

        if (! empty($_FILES['image']) && ! empty($_FILES['image']['tmp_name'])) {
            $payload['image'] = $_FILES['image'];
        }

        if (!empty($_POST['password'])) {
            $payload['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $this->studentService->updateStudent($studentId, $payload);
        session_flash('success', 'تم تعديل بيانات الطالب بنجاح.');
        header('Location: /admin/students');
        exit;
    }

    private function isAdminAuthenticated(): bool
    {
        return isset($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin';
    }
}
<?php  

namespace App\Http\Controllers\Admin; 

use App\Model\Department;
use App\Services\StudentServices;
use App\Utility\ImageManager;

class StudentController{

    private $studentService;

    public function __construct(StudentServices $studentService)
    {
        $this->studentService = $studentService;
    }
    public function index(){
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $data = $this->studentService->getAllStudents();
        $departments = Department::all();

        return view('admin/students', compact('data', 'departments'));

    }

    public function store(){
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

       $payload = [
            'student_id' => trim($_POST['student_id'] ?? ''),
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'age' => (int) ($_POST['age'] ?? 0),
            'gender' => trim($_POST['gender'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'parent_phone' => trim($_POST['parent_phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'dep_id' => (int) ($_POST['dep_id'] ?? 0),
        ];
      
        $requiredFields = ['student_id', 'full_name', 'email', 'password', 'age', 'gender', 'phone', 'parent_phone', 'address', 'dep_id'];
        foreach ($requiredFields as $field) {
            if (empty($payload[$field])) {
                header('Location: /admin/students?error=required');
                exit;
            }
        }

        if (empty($_FILES['image']) || empty($_FILES['image']['tmp_name'])) {
            header('Location: /admin/students?error=image');
            exit;
        }

        $payload['image'] = ImageManager::uploadImage($_FILES['image'], 'students');

        $payload['password'] = password_hash(
            $payload['password'],
            PASSWORD_DEFAULT
        );


        $this->studentService->createStudent($payload);
        header('Location: /admin/students?success=1');
        exit;
    }

    public function delete(){
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $studentId = (int) ($_POST['student_id'] ?? 0);
        if ($studentId <= 0) {
            header('Location: /admin/students?error=delete');
            exit;
        }

        $this->studentService->deleteStudent($studentId);
        header('Location: /admin/students?deleted=1');
        exit;
    }

    public function update(){
        if (! $this->isAdminAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $studentId = (int) ($_POST['record_id'] ?? 0);
        if ($studentId <= 0) {
            header('Location: /admin/students?error=update');
            exit;
        }

                $payload = [
            'student_id' => trim($_POST['student_id'] ?? ''),
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'age' => (int) ($_POST['age'] ?? 0),
            'gender' => trim($_POST['gender'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'parent_phone' => trim($_POST['parent_phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'dep_id' => (int) ($_POST['dep_id'] ?? 0),
            'current_image' => trim($_POST['current_image'] ?? ''),
        ];

        if (! empty($_FILES['image']) && ! empty($_FILES['image']['tmp_name'])) {
            $payload['image'] = $_FILES['image'];
        }
        if (!empty($_POST['password'])) {
            $payload['password'] = password_hash(
                $_POST['password'],
                PASSWORD_DEFAULT
        );
}

        $this->studentService->updateStudent($studentId, $payload);
        header('Location: /admin/students?updated=1');
        exit;
    }

    private function isAdminAuthenticated(): bool
    {
        return isset($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin';
    }

}
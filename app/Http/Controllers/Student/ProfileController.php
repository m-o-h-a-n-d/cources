<?php



namespace App\Http\Controllers\Student;

use App\Model\Student;

class ProfileController
{
    public function index()
    {
    $auth = $_SESSION['auth'] ?? null; 

    $student = Student::find($auth['id'] ?? null);


    if (!$student) {
        return view('profile/index', ['error' => 'Student not found']);
    }

    return view('profile/index', compact('student'));


    }


}
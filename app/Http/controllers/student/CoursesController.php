<?php  

namespace App\Http\Controllers\Student; 

use App\Model\Student;


class CoursesController 
{
    public function index()
    {

        $studentId = $_SESSION['auth']['id'] ?? null;
        $student = Student::find($studentId);


        if (!$student) {
            header('Location: /login');
            exit;
        }
        $courses = \App\Model\Course::getCoursesDepartment($studentId);
        return view('courses/index', compact('courses'));
    }
}


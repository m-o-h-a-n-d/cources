<?php 


namespace App\Http\Controllers\Student;

use App\Model\MyCourse;


class MyCoursesController
{
    public function index()
    {
        $student = $_SESSION['auth'];

        
        $courses = MyCourse::getStudentCourses(
            $student['id']
        );

        return view(
            'my-courses/index',
            compact('courses')
        );


        
    }
}
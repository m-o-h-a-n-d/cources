<?php

namespace App\Http\Controllers\Student;

use App\Services\StudentCoursesServices;
use App\Model\StudentCourses;

class StudentCoursesController
{
    public function __construct(
        private StudentCoursesServices $service
    ) {
    }

    public function index()
    {
        $studentId = $_SESSION['auth']['id'];

        $courses = StudentCourses::getCoursesDepartment(
            $studentId
        );

        return view(
            'courses/index',
            compact('courses')
        );
    }

    public function store()
    {
        $studentId = $_SESSION['auth']['id'];
        $courseId = (int) $_POST['course_id'];

        
        $this->service->enroll(
            $studentId,
            $courseId
        );

        $_SESSION['success'] =
            'Course enrolled successfully 🎉';

        header('Location: /student/courses');
        exit;
    }
}
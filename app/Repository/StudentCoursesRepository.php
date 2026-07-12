<?php  

namespace App\Repository;

use App\Model\StudentCourses;
use Core\Model;

class StudentCoursesRepository extends Model
{

    public function enroll(int $studentId, int $courseId): void
    {
        StudentCourses::create([
            'student_id' => $studentId,
            'course_id' => $courseId,
        ]);


    }

}
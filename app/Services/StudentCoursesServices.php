<?php  
namespace App\Services;

use App\Repository\StudentCoursesRepository;

class StudentCoursesServices
{
    public function __construct(
        private StudentCoursesRepository $repository
    ) {
    }

    public function enroll(
    int $studentId,
    int $courseId
): void
{
    

    $this->repository
        ->enroll(
            $studentId,
            $courseId
        );
}
}
<?php  


namespace App\Services;
use App\Repository\CourseRepository;

class CourseServices{

    public function __construct(protected   CourseRepository $courseRepository)
    {    }

    public function getAllCourses(){

        return $this->courseRepository->getAllCourses();
    }

    public function createCourse(array $data){

        $this->courseRepository->createCourse($data);
    }

    public function deleteCourse($courseId){

        $this->courseRepository->deleteCourse($courseId);
    }

    public function updateCourse($courseId, array $data){

        $this->courseRepository->updateCourse($courseId, $data);
    }
}
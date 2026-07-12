<?php  


namespace App\Services;
use App\Repository\CourseScheduleRepository;

class CourseScheduleServices{

    public function __construct(protected   CourseScheduleRepository $courseScheduleRepository)
    {    }

    public function getAllCourseSchedules(){

        return $this->courseScheduleRepository->getAllCourseSchedules();
    }

    public function createCourseSchedule(array $data){

        $this->courseScheduleRepository->createCourseSchedule($data);
    }

    public function deleteCourseSchedule($courseScheduleId){

        $this->courseScheduleRepository->deleteCourseSchedule($courseScheduleId);
    }

    public function updateCourseSchedule($courseScheduleId, array $data){

        $this->courseScheduleRepository->updateCourseSchedule($courseScheduleId, $data);
    }
}
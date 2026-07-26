<?php  


namespace  App\Repository;  


use App\Model\CourseSchedule;

class CourseScheduleRepository {

    public function getAllCourseSchedules()
    {
        // Logic to retrieve all course schedules from the database
        return CourseSchedule::allWithCourses();
    }

    public function createCourseSchedule($data)
    {
        // Logic to create a new course schedule in the database
        CourseSchedule::create($data);
    }

    public function deleteCourseSchedule($courseScheduleId)
    {
        // Logic to delete a course schedule from the database
        CourseSchedule::delete($courseScheduleId);
    }

    public function updateCourseSchedule($courseScheduleId, $data)
    {
        // Logic to update a course schedule in the database
        CourseSchedule::update($data, $courseScheduleId);
    }
}
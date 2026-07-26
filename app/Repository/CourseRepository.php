<?php  

namespace App\Repository; 

use App\Model\Course;

class CourseRepository {

    public function getAllCourses()
    {
        // Logic to retrieve all courses from the database
        return Course::allWithDepartment();
    }

    

    public function createCourse($data)
    {
        // Logic to create a new course in the database
        Course::create($data);
    }

    public function deleteCourse($courseId)
    {
        // Logic to delete a course from the database
        Course::delete($courseId);
    }

    public function updateCourse($courseId, $data)
    {
        // Logic to update a course in the database
        Course::update($data, $courseId);
    }
}
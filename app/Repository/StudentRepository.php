<?php  

namespace App\Repository;
use App\Model\Student;
use App\Utility\ImageManager;


class StudentRepository{

    public function getAllStudents()
    {

        return Student::allWithDepartment();
    }

    public function createStudent($data)
    {
        Student::create($data);
    }

    public function deleteStudent($studentId)
    {
        $student = Student::find($studentId);

        if ($student) {
            // Delete the student's image

            if (!empty($student["image"])) {
                ImageManager::deleteImage('students/' . $student["image"]);
            }

            // Delete the student record from the database
            Student::delete($studentId);
        }
    }


    protected   function findStudentById($studentId)
    {
        return Student::find($studentId);
    }


    public function updateStudent($studentId, $data)
    {
        $student = self::findStudentById($studentId);

        if ($student) {
            // If a new image is provided, replace the old one
            if (!empty($data['image'])) {
                if (!empty($data['current_image'])) {
                    ImageManager::deleteImage('students/' . $data['current_image']);
                }

                $data['image'] = ImageManager::uploadImage($data['image'], 'students');
            } else {
                // If no new image is provided, keep the old image
                unset($data['image']);
            }

            unset($data['current_image']);

            Student::update($data, $studentId);
        }
    }







}
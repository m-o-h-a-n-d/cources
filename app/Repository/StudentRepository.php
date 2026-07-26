<?php  

namespace App\Repository;

use App\Model\Student;
use App\Utility\ImageManager;

class StudentRepository implements StudentRepositoryInterface
{
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
            if (!empty($student["image"])) {
                ImageManager::deleteImage('students/' . $student["image"]);
            }

            Student::delete($studentId);
        }
    }

    protected function findStudentById($studentId)
    {
        return Student::find($studentId);
    }

    public function updateStudent($studentId, $data)
    {
        $student = $this->findStudentById($studentId);

        if ($student) {
            if (!empty($data['image']) && is_array($data['image']) && !empty($data['image']['tmp_name'])) {
                if (!empty($data['current_image'])) {
                    ImageManager::deleteImage('students/' . $data['current_image']);
                }

                $data['image'] = ImageManager::uploadImage($data['image'], 'students');
            } else {
                unset($data['image']);
            }

            unset($data['current_image']);

            Student::update($data, $studentId);
        }
    }
}
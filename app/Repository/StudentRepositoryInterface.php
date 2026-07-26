<?php  

namespace App\Repository;

interface StudentRepositoryInterface
{
    public function getAllStudents();

    public function createStudent($data);

    public function deleteStudent($studentId);

    public function updateStudent($studentId, $data);
}

<?php  

namespace App\Services;
use App\Repository\StudentRepository;



class StudentServices{


    public function __construct(protected   StudentRepository $studentRepository)
    {    }

    public function getAllStudents(){

        return $this->studentRepository->getAllStudents();
    }

    public function createStudent(array $data){

        $this->studentRepository->createStudent($data);
    }

    public function deleteStudent($studentId){

        $this->studentRepository->deleteStudent($studentId);
    }

    public function updateStudent($studentId, array $data){

        $this->studentRepository->updateStudent($studentId, $data);
    }

}
<?php  

namespace App\Services;

use App\Repository\DepartmentRepository;

class DepartmentServices
{
    // Service methods for department operations

    public function __construct(protected DepartmentRepository $departmentRepository)
    {
    }

    public function getAllDepartments()
    {
        return $this->departmentRepository->getAllDepartments();
    }

    public function createDepartment(array $data)
    {
        $this->departmentRepository->createDepartment($data);
    }

    public function deleteDepartment($departmentId)
    {
        $this->departmentRepository->deleteDepartment($departmentId);
    }

    public function updateDepartment($departmentId, array $data)
    {
        $this->departmentRepository->updateDepartment($departmentId, $data);
    }
}
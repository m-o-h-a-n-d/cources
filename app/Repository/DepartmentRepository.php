<?php  


namespace App\Repository;
use App\Model\Department;

class DepartmentRepository{

    public function getAllDepartments()
    {
        return Department::all();
    }

    public function createDepartment($data)
    {
        Department::create($data);
    }

    public function deleteDepartment($departmentId)
    {
        Department::delete($departmentId);
    }

    public function updateDepartment($departmentId, $data)
    {
        Department::update($data, $departmentId);
    }
}
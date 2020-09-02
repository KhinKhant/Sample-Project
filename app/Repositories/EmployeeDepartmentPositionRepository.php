<?php

namespace App\Repositories;
use App\Emp_Dep_Position;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;

class EmployeeDepartmentPositionRepository implements EmployeeDepartmentPositionRepositoryInterface
{
    public function saveEmployeeDep($employeeId, $pos_id, $dep_id)
    {
        $emp_dep_pos= new Emp_Dep_Position();
        $emp_dep_pos->employee_id=$employeeId;
        $emp_dep_pos->department_id=$pos_id;
        $emp_dep_pos->position_id=$dep_id;
        $emp_dep_pos->save();
    }
    // public function updateEmployeeDep($employeeId, $pos_id, $dep_id)
    // {
    //     $emp_dep_pos= new 
    // }
}
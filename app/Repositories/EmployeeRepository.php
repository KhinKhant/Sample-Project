<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Employee;
use Illuminate\Support\Facades\DB;
//use Your Model

/**
 * Class EmployeeRepository.
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function saveEmployee($request)
    {
        $employee = new Employee();
        $employee->employee_name = $request['employee_name'];
        $employee->email= $request['email'];
        $employee->dob = $request['dob'];
        $employee->password=$request['password'];
        $employee->gender= $request['gender'];
        try
        {
            $employee->save();
            return true;

        }catch(Exception $e)
        {
            return false;
        }
    }
    public function checkEmployee($request)
    {
        $employeeId = $request->id;
        $employee = DB::table('employees')
                    ->leftJoin('emp__dep__positions', 'employees.id', '=', 'emp__dep__positions.employee_id')
                    ->where('employees.id',$employeeId)
                    ->get();
        return $employee;
    }
     public function updateEmployee($request)
     {
        $employee = DB::table('employees')
        ->where('id', $request->id)
        ->update(['employee_name' => $request['employee_name'], 
            'email' => $request['email'],
            'dob' => $request['dob'],
            'password'=> $request['password'],
            'gender' => $request['gender']
        ]);
     }
}
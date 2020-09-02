<?php

namespace App\Repositories\Logics;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
use Illuminate\Support\Facades\Log;
use\App\Employee;

class EmployeeRegistrationLogic
{
    
    public function __construct(EmployeeDepartmentPositionRepositoryInterface $employeeRepo) //create contruct() to use interface 
    {       
        $this->employeeRepo = $employeeRepo;
       
    }
    public function savePrepareData($request)
    {
        if($request->position_id)
            {

                $pos_id=$request->position_id;

            }
            else
            {
                 $pos_id =1;
            }
            if ($request->department_id)
             {

                $dep_id=$request->department_id;

            }
            else
            {
                 $dep_id = 1;
            }
            $employeeId = Employee::max('id');
            $this->employeeRepo->saveEmployeeDep($employeeId, $pos_id, $dep_id);
            Log::info($employeeId);
            //return true;
    }
    public function updatePrepareData($request)
    {
    
            if($request->position_id) {
                $pos_id=$request->position_id;
            } else {
                $pos_id=1;  //default position 1
            }

            if ($request->department_id) {
                $poss_id=$request->department_id;
            } else {
                $poss_id=1; //default position 1
            }

            $employeeId = Employee::max('id');
            Log::info($employeeId);
            $this->empDepRepo->updateEmployeeDep($employeeId, $pos_id, $poss_id);
            return true;
    }
}

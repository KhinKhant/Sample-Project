<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRegistrationValidationRequest;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Logics\EmployeeRegistrationLogic;

class EmployeeRegistrationController extends Controller
{
    public function __construct(EmployeeRepositoryInterface $employeeRepo, EmployeeRegistrationLogic $employeeLogic)
    {       
        $this->employeeRepo = $employeeRepo;
        $this->employeeLogic = $employeeLogic;
        //$this->employeeUpdateLogic = $employeeUpdateLogic;
    }

    public function save(EmployeeRegistrationValidationRequest $request)
    {
        $this->employeeRepo->saveEmployee($request);
        $this->employeeLogic->savePrepareData($request);
    }
    public function update(EmployeeRegistrationValidationRequest $request)
    {
        $employee= $this->employeeRepo->checkEmployee($request);
        
        if($employee->isEmpty())
        {
            return response()->json(['message'=>"Data is not found"],200);
        }else{
            $this->employeeRepo->updateEmployee($request);
        }       
    
    }
}
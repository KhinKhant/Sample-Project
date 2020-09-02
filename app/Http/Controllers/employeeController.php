<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Emp_Dep_Position;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\EmployeesExport; 

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config; //for constant variable declar

use App\Http\Requests; //Declare for validation
use App\Http\Requests\EmployeeRequest; //Declare for validation


//use Illuminate\Support\Facades\Artisan; //for cache clear

 /**
  * Description: index, store, show, update, destroy, forceDelete, search, fileExport
  * @author Khin Yadanar Khant
  * @date 26/08/2020
  */

class employeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Khin Yadanar Khant
     * @date 28/08/2020
     * @return $employees={id, employee_name, email, password, dob, gender}
     */
    public function index()
    {  
        $perPage = Config::get('constants.per_page');
        $employees = Employee::with('departments', 'positions')->withTrashed()->paginate($perPage);
        return response($employees, 200);

        /*define variable in another way
         $limit= (int)env('limit');
         $employees =Employee::with('departments','positions')->paginate($limit);

         $limit= (int)env('limit');
         $employees =Employee::paginate($limit); //delete for softDelete() 
       
         return $employees;
        */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @author Khin Yadanar Khant
     * @date 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(EmployeeRequest $request) //Change Request to EmployeeRequest for validation
    {
        /*data validationg by using validate() function
        $request->validate([
                            'employee_name' => 'required|unique:posts|max:255',
                            'email' => 'required',
                            'dob' => 'required',
                            'password'=> 'required',
                            'gender'=>'required'
        ]);
        */

        try
        {
            $employee = new Employee();
            $employee->employee_name = $request['employee_name'];
            $employee->email= $request['email'];
            $employee->dob = $request['dob'];
            $employee->password=$request['password'];
            $employee->gender= $request['gender'];
            $employee->save();

            $lasttemp_id=Employee::max('id');

            if($request->position_id)
            {

                $pos_id=$request->position_id;

            }
            else
            {
                 $pos_id = Config::get('constants.default_position');
            }
            if ($request->department_id)
             {

                $dep_id=$request->department_id;

            }
            else
            {

                 $dep_id = Config::get('constants.default_department');
            }

            $emp_dep_position=new Emp_Dep_Position();
            $emp_dep_position->employee_id=$lasttemp_id;
            $emp_dep_position->department_id=$dep_id;
            $emp_dep_position->position_id=$pos_id;
            $emp_dep_position->save();

            
            Mail::raw('Your registration process is finish.', function($message)
            {              
                $message->subject('Save Successful')->from('lonlon.blah@gmail.com')->to('pwintyamone588@gmail.com');
               
            });

            return response()->json([

                'message'=>'Success Employee Registration'

            ],200);

            }catch(QueryException $e)
            {
                return response()->json([$message=>$e->getMessage()]);
            }
        }

     

    /**
     * Display detail employee informations associated with id
     * @author Khin Yadanar Khant
     * @date 27/08/2020
     * @param  int  $id
     * @return $employee={id, employee_name, email, password, dob, gender} 
     */
    public function show($id)
    {
       $employee=Employee::withTrashed()->whereId($id)->with('departments','positions')->first();
       return $employee;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @author Khin Yadanar Khant
     * @date 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $employee=Employee::whereId($id)->firstOrFail();
            $employee->employee_name=$request->employee_name;
            $employee->email=$request->email;
            $employee->dob=$request->dob;
            $employee->password=$request->password;
            $employee->gender=$request->gender;
            $employee->update();

            /*
              $data= $request->all();
              $email=$data->email;*/

            //$email= $request['email'];
            //$email=$request->email;
            if($request->position_id)
            {
                $pos_id=$request->position_id;
            }else
            {
                $pos_id = Config::get('constants.default_position'); //default position value:1
           
            }
            
            if ($request->department_id) //request department id
            {
                $poss_id=$request->department_id;

            }
            else
            {
                $poss_id=Config::get('constants.default_department'); // default department value:1
            }       
            $emp_dep_position=Emp_Dep_Position::where('employee_id',$id)->first();
    
            if($emp_dep_position)
            {
                if($request->department_id)
                {
                    $emp_dep_position->department_id=$request->department_id;
                }
                if ($request->position_id)
                {
                    $emp_dep_position->position_id=$pos_id;           
                }
                $emp_dep_position->update();
            }  

            return response()->json([

                'message'=>"Update Successfull"

            ]);

        }catch(QueryException $e)
        {
            //return response()->json([('status')=>'NG', 'message'=> "error"],200);
            return response()->json([$message=>$e->getMessage()]);
        }      
    }

    /**
     * Remove the specified resource from storage.
     * @author Khin Yadanar Khant
     * @date 26/08/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      //display only deleted time
    public function destroy($id)
    {
       try
       {
            $employee=Employee::whereId($id)->firstOrFail();
            $employee->delete();
        
            $emp_dep_position=Emp_Dep_Position::where('employee_id',$id)->first();
    
            if($emp_dep_position)
            {
                $emp_dep_position->delete();
            }
            return response()->json([

                'message'=>"Delete Successful"

            ]);

        }catch(QueryException $e)
        {
            return response()->json([

                $message=>$e->getMessage()

            ]);

        
        }
    }


    /**
     * Completely delete data
     * @author Khin Yadanar Khant
     * @date 26/08/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        try
        {
            $emp_dep_position=Emp_Dep_Position::withTrashed()->where('id',$id)->forceDelete();
            $employee= Employee::withTrashed()->find($id);
            $employee->forceDelete();
       
            return response()->json([

                'message'=>"Completely Delete Successful"
            ]);

        }catch(QueryException $e)
        {
            return response()->json([

            $message=>$e->getMessage()

            ]);
        }
    }

    /**
     * Retrive data associated with id or name
     * @author Khin Yadanar Khant
     * @date 27/08/2020
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return $employee={id, employee_name, email, password, dob, gender}
     */


    public function search(Request $request)
    {
        // Artisan::call('cache:clear'); //for cache clear
        // Artisan::call('config:cache'); //for cache clear

       /*Retrive data associated with id and name
        $empid = $request['id'];
        $empname = $request['employee_name'];

        $search=Employee::where('id', $empid)->orWhere('employee_name', $empname)->get();
        return $search;
        */

        $search_data=[];
       
        if($request->id)
        {
            $search_id = ['id', $request->id];
            array_push($search_data, $search_id);
        }

         if($request->employee_name)
        {
            $search_name=['employee_name','like',$request->employee_name.'%'];
            array_push($search_data, $search_name);
        }
      
        $perPage = Config::get('constants.per_page');
        $employees=Employee::with('departments','positions')->withTrashed()->where($search_data)->paginate($perPage);
        return response()->json($employees,200);
   

    }

    /**
     * Excel download 
     * @author Khin Yadanar Khant
     * @date 28/08/2020
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return Downloading excel with id, employee_name, email, password, dob, gender
     */

    public function fileExport(Request $request)  
    { 
        $data=[];
        if($request->id)
        {         
            $emp_id=['employees.id',$request->id];
            array_push($data, $emp_id);
        }
        if($request->employee_name)
        {
            $emp_name=['employees.employee_name','like',$request->employee_name.'%'];
            array_push($data, $emp_name);
            
        }
        return Excel::download(new EmployeesExport($data), 'EmployeeList.xlsx');
    }

}


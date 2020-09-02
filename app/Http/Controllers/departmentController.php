<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;//Declare for validation
use App\Http\Requests\DepartmentRequest; //Declare for validation

 /**
  * Description: index, store, show, update, destroy, forceDelete
  * @author Khin Yadanar Khant
  * @date 26/08/2020
  */
class departmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Khin Yadanar Khant
     * @date 28/08/2020
     * @return $departments={id, department_name}
     */
    
    public function index()
    {
       /* $limit= (int)env('limit');
        $departments =Department::paginate($limit);
        //$departments =Department::with('position','employee')->paginate($limit);
        return $departments;
        */
        $perPage = Config::get('constants.per_page');
        $departments = Department::withTrashed()->paginate($perPage);
        return response($departments, 200);

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
    public function store(DepartmentRequest $request)
    {
        try
        {
            $department = new Department();   
            $department->department_name = $request['department_name'];
            $department->save();

            return response()->json([

                'message'=>'Save Successful'

            ],200);
        }catch(QueryException $e)
        {
            return response()->json([
            $message=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display detail department informations associated with id
     * @author Khin Yadanar Khant
     * @date 27/08/2020
     * @param  int  $id
     * @return $departments={id, department_name}
     */

    public function show($id)
    {
        $department=Department::withTrashed()->whereId($id)->first(); 
        return $department;
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
        $department=Department::whereId($id)->firstOrFail();
        $department->department_name=$request->department_name;
        $department->update();
        return "Successfully Update";
    }

     /**
     * Remove the specified resource from storage
     * @author Khin Yadanar Khant
     * @date 26/08/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //only deleted time
    public function destroy($id)
    {
        $department=Department::whereId($id)->firstOrFail(); 
        $department->delete(); 
        return true;
    }

     /**
     * Completely delete data
     * @author Khin Yadanar Khant
     * @date 26/08/2020
     * @param  int  $id
     * @return Completely delete 
     */

    public function forceDelete($id)
    {   
        try
        {
            $department= Department::withTrashed()->find($id);
            $department->forceDelete();
       
            // $department=Department::withTrashed()->whereId($id)->firstOrFail(); 
            // $department->forceDelete(); 
                   
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
}
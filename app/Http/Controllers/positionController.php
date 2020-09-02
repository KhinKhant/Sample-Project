<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use Illuminate\Support\Facades\Config;
use App\Http\Requests;//Declare for validation
use App\Http\Requests\PositionRequest; //Declare for validation


/**
  * Description: index, store, show, update, destroy, forceDelete
  * @author Khin Yadanar Khant
  * @date 26/08/2020
  */
class positionController extends Controller
{
     
     /**
     * Display a listing of the resource.
     * @author Khin Yadanar Khant
     * @date 28/08/2020
     * @return $positions={id, position_name, position_rank}
     */
    public function index()
    {
        // $limit= (int)env('limit');
        // $positions =Position::paginate($limit);
        // $positions =Position::with('department','employee')->paginate($limit);
        // return $positions;

        $perPage = Config::get('constants.per_page');
        $positions = Position::withTrashed()->paginate($perPage);
        return response($positions, 200);

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
    public function store(PositionRequest $request)
    {
        try{
                $position = new Position();
                $position->position_name = $request['position_name'];
                $position->position_rank = $request['position_rank'];
                $position->save();

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
     * @return  $positions={id, position_name, position_rank}
     */

    public function show($id)
    {
        $position=Position::withTrashed()->whereId($id)->first();
        return $position;
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
        $position=Position::whereId($id)->firstOrFail();
        $position->position_name=$request->position_name;
        $position->position_rank=$request->position_rank;
        $position->update();
        return "Update Successfully";
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
         $position=Position::withTrashed()->whereId($id);
         $position->delete();
         return "Soft Delete Successful";
    }

    /**
     * Completely delete specified resource from storage
     * @author Khin Yadanar Khant
     * @date 26/08/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        //$emp_dep_position=Emp_Dep_Position::where('position_id',$id)->forceDelete();
       
       try
       {
            //$position= Positon::withTrashed()->find($id);
            $position=Position::withTrashed()->whereId($id)->firstOrFail(); 
            $position->forceDelete();
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

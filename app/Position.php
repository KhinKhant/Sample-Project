<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
  * Description: department, employee
  * @author Khin Yadanar Khant
  * @date 27/08/2020
  */
class Position extends Model
{
	use SoftDeletes;
      
    public function department()
    {

        return $this->belongsToMany('App\Department', 'emp__dep__positions', 'employee_id', 'department_id');
    }

  public function employee(){

        return $this->belongsToMany('App\Employee', 'emp__dep__positions', 'employee_id', 'position_id');
    }
}

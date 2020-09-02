<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Department;
use Position;

/**
  * Description: employee, position
  * @author Khin Yadanar Khant
  * @date 27/08/2020
  */
class Employee extends Model
{
    use SoftDeletes; 

    public $fillable=['employee_name', 'email', 'dob', 'password', 'gender'];

    
    public function positions()
    {
        return $this->belongsToMany('App\Position','emp__dep__positions','employee_id','position_id');
    }

  	public function departments()
  	{
        return $this->belongsToMany('App\Department','emp__dep__positions','employee_id','department_id');
    }

}
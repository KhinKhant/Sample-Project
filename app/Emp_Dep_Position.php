<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
  * @author Khin Yadanar Khant
  * @date 27/08/2020
  */
class Emp_Dep_Position extends Model
{
    use SoftDeletes;
    public $fillable=['employee_id', 'department_id', 'position_id'];

   }

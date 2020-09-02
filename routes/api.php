<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request)
{
    return $request->user();
});

//Department
Route::apiResource('departments', 'departmentController');
Route::delete('departments/forceDelete/{id}', 'departmentController@forceDelete');

//Position
Route::apiResource('positions', 'positionController');
Route::delete('positions/forceDelete/{id}', 'positionController@forceDelete');

//Employee
Route::apiResource('employees', 'employeeController');
Route::delete('employees/forceDelete/{id}', 'employeeController@forceDelete');
Route::POST('/employees/search', 'employeeController@search');
Route::get('/employee-export', 'employeeController@fileExport')->name('fileExport'); //to run->localhost:8000/api/employee-export?id=10

//Department_Position
Route::apiResource('department_positions', 'depPositionController');






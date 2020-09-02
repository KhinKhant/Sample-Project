<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //change false to true for validation
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'employee_name' => 'required|max:100',
            'email' => 'required|email|unique:employees',
            'dob' => 'required|date_format:Y-m-d',
            'password' => 'required',
            'gender'=>'required'
        ];
    }
}

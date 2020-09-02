<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PositionRegistrationValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'position_name' => 'required|max:100',
            'position_rank' => 'required'
        ];
    }
    // public function messages()
    // {     
    //     return [
    //         'position_name.required' => "Position name is required!",
    //         'position_rank.required' => "Position rank must be required!",
    //           ];
    // }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                      => 'exists:admins,id',
            'first_last_name'         => 'required|min:2|regex:/^[a-zA-Z_\p{L}\s.,]+$/u',
            'email' => 'required|email|regex:/^[a-zA-Z0-9_]+@gmail\.com$/i',
            'phone_number' => 'required|numeric|digits:10',
            'date_birth' => 'required|date|before_or_equal:today',
            'status'                  => 'required|numeric',
            'id_permission'           => 'required|exists:quyens,id'
        ];
    }

    public function messages()
    {
        return [
            'exists'            => ':attribute does not exist!',
            'required'          => ':attribute cannot be left blank!',
            'regex' => ':attribute contains invalid characters!',
            'email' => ':attribute must be a valid email address!',
            'numeric' => ':attribute must be a number!',
            'date'              => ':attribute must be date format!',
            'date' => ':attribute must be a valid date!',
            'before_or_equal' => ':attribute must be a date before or equal to today!',
            'min'               => ':attribute must have at least :min characters',
        ];
    }

    public function attributes()
    {
        return [
            'id'                      => 'Staff',
            'first_last_name'         => 'First and last name',
            'email'                   => 'Email',
            'phone_number'            => 'Phone number',
            'date_birth'              => 'Date of birth',
            'status'                  => 'Status',
            'id_permission'           => 'Permission',
        ];
    }
}

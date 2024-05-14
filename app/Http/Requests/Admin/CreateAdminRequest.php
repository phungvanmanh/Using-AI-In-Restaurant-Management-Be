<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_last_name'         => 'required|min:2|regex:/^[a-zA-Z_\p{L}\s.,]+$/u',
            'email' => 'required|email|regex:/^[a-zA-Z0-9_]+@gmail\.com$/i',
            'phone_number' => 'required|numeric|digits:10',
            'date_birth' => 'required|date|before_or_equal:today',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'status'                  => 'required|numeric',
            'id_permission'           => 'required|exists:quyens,id'
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute cannot be left blank!',
            'regex' => ':attribute contains invalid characters!',
            'min' => ':attribute must be at least :min characters long!',
            'regex' => ':attribute must contain at least one uppercase letter, one lowercase letter, one digit, and one special character!',
            'email' => ':attribute must be a valid email address!',
            'numeric' => ':attribute must be a number!',
            'date'              => ':attribute must be date format!',
            'date' => ':attribute must be a valid date!',
            'before_or_equal' => ':attribute must be a date before or equal to today!',
            'email.regex' => ':attribute must be an email address of @gmail.com!'

        ];
    }

    public function attributes()
    {
        return [
            'first_last_name'         => 'First and last name',
            'email'                   => 'Email',
            'phone_number'            => 'Phone number',
            'date_birth'              => 'Date of birth',
            'password'                => 'Password',
            'status'                  => 'Status',
            'id_permission'           => 'Permission',
        ];
    }
}

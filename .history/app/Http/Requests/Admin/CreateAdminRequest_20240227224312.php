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
            'first_last_name'         => 'required|min:4',
            'email'                   => 'required|email',
            'phone_number'            => 'required|numeric',
            'date_birth'              => 'required|date',
            'password'                => 'required',
            'status'                  => 'required|numeric',
            'id_permission'           => 'required|exists:quyens,id'
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute cannot be left blank!',
            'regex'             => ':attribute Malformed!',
            'email'             => ':attribute Must be a valid email address!',
            'numeric'           => ':attribute must be a number!',
            'date'              => ':attribute must be date format!',
            'min'               => ':attribute phải có ít nhất :min ký tự',
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

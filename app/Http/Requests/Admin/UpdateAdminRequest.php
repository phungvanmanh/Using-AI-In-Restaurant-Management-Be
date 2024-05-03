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
            'first_last_name'         => 'required|min:4',
            'email'                   => 'required|email',
            'phone_number'            => 'required|numeric',
            'date_birth'              => 'required|date',
            'status'                  => 'required|numeric',
            'id_permission'           => 'required|exists:quyens,id'
        ];
    }

    public function messages()
    {
        return [
            'exists'            => ':attribute does not exist!',
            'required'          => ':attribute cannot be left blank!',
            'regex'             => ':attribute Malformed!',
            'email'             => ':attribute Must be a valid email address!',
            'numeric'           => ':attribute must be a number!',
            'date'              => ':attribute must be date format!',
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

<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class CheckLogin extends FormRequest
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

    public function rules()
    {
        return [
            'email'     => "required|exists:admins,email",
            'password'  => "required",
        ];
    }

    public function messages()
    {
        return [
            'exists'            => ':attribute is not registered!',
            'required'          => ':attribute cannot be left blank!',
        ];
    }

    public function attributes()
    {
        return [
            'email'             => 'Email',
            'password'          => 'Password',
        ];
    }
}

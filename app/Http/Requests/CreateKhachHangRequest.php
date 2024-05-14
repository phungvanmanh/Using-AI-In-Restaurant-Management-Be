<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateKhachHangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_khach_hang' => 'required|min:2|regex:/^[a-zA-Z_\p{L}\s.,]+$/u',
            'email' => 'required|email|regex:/^[a-zA-Z0-9_]+@gmail\.com$/i',
            'so_dien_thoai' => 'required|numeric|digits:10',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute cannot be empty!',
            'min' => ':attribute must contain at least :min characters!',
            'regex' => ':attribute contains invalid characters!',
            'email' => ':attribute must be a valid email address!',
            'numeric' => ':attribute must be a number!',
            'digits' => ':attribute must contain exactly :digits digits!',
            'email.regex' => ':attribute must be an email address of @gmail.com!'
        ];
    }

    public function attributes()
    {
        return [
            'ten_khach_hang' => 'Tên Khách Hàng',
            'email' => 'Email',
            'so_dien_thoai' => 'Số điện thoại',
        ];
    }
}

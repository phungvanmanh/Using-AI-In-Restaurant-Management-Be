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
            'required'          => ':attribute không được để trống',
            'regex'             => ':attribute không đúng định dạng',
            'email'             => ':attribute phải là một địa chỉ email hợp lệ',
            'numeric'           => ':attribute phải là số',
            'date'              => ':attribute phải là định dạng ngày tháng',
            'min'               => ':attribute phải có ít nhất :min ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'first_last_name'         => 'Họ và tên',
            'email'             => 'Email',
            'phone_number'     => 'Số điện thoại',
            'date_birth'         => 'Ngày sinh',
            'password'          => 'Mật khẩu',
            'status'        => 'Tình trạng',
            'id_permission'          => 'Quyền',
        ];
    }
}

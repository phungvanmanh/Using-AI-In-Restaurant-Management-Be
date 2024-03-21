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
            'id'                => 'exists:admins,id',
            'ho_va_ten'         => 'required|min:4',
            'email'             => 'required|email',
            'so_dien_thoai'     => 'required|numeric',
            'ngay_sinh'         => 'required|date',
            'id_quyen'          => 'required|exists:quyens,id'
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
            'exists'            => ':attribute không tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'id'                => 'Nhân Viên',
            'ho_va_ten'         => 'Họ và tên',
            'email'             => 'Email',
            'so_dien_thoai'     => 'Số điện thoại',
            'ngay_sinh'         => 'Ngày sinh',
            'id_quyen'          => 'Quyền',
        ];
    }
}

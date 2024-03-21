<?php

namespace App\Http\Requests\NhanVien;

use Illuminate\Foundation\Http\FormRequest;

class CreateStaffRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ho_ten'         => 'required|min:4',
            'so_dien_thoai'     => 'required|numeric',
            // 'ngay_sinh'         => 'required|date',
            // 'email'             => 'required|email',
            // 'ma_nv'             => 'required|min:4',
            'status'            => 'required|numeric',
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
            'ho_ten'         => 'Họ và tên',
            'so_dien_thoai'     => 'Số điện thoại',
            // 'ngay_sinh'         => 'Ngày sinh',
            // 'email'             => 'Email',
            // 'ma_nv'        => 'Mã Nhân viên',
            'status'            => 'Status',
        ];
    }
}

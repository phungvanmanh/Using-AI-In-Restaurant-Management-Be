<?php

namespace App\Http\Requests\NhanVien;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                => 'exists:nhan_viens,id',
            'ho_ten'         => 'required|min:4',
            'so_dien_thoai'     => 'required|numeric',
            'ngay_sinh'         => 'required|date',
            'email'             => 'required|email',
            'ma_nv'             => 'required',
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
            'ho_ten'         => 'Họ và tên',
            'email'             => 'Email',
            'so_dien_thoai'     => 'Số điện thoại',
            'ngay_sinh'         => 'Ngày sinh',
            'ma_nv'             => 'Mã nhân viên',
        ];
    }
}

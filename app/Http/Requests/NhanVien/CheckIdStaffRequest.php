<?php

namespace App\Http\Requests\NhanVien;

use Illuminate\Foundation\Http\FormRequest;

class CheckIdStaffRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'         => 'exists:nhan_viens,id',
        ];
    }

    public function messages()
    {
        return [
            'exists'            => ':attribute không tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'id'         => 'Nhân Viên',
        ];
    }
}

<?php

namespace App\Http\Requests\KhachHang;

use Illuminate\Foundation\Http\FormRequest;

class CheckIdKhachHangRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'         => 'exists:khach_hangs,id',
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
            'id'         => 'Khách hàng',
        ];
    }
}

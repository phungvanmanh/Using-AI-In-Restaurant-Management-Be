<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckidChuyenMucBaiViet extends FormRequest
{
    public function rules()
    {
        return [
            'id'         => 'exists:chuyen_muc_bai_viets,id',
        ];
    }

    public function messages()
    {
        return [
            'exists'            => ':attribute does not exist!',
        ];
    }

    public function attributes()
    {
        return [
            'id'         => 'ten_chuyen_muc',
        ];
    }
}

<?php

namespace App\Http\Requests\DanhMuc;

use Illuminate\Foundation\Http\FormRequest;

class CheckIdDanhMucRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'         => 'exists:danh_mucs,id',
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
            'id'         => 'Category',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckidNhaCungCapRequest extends FormRequest

{
    public function rules()
    {
        return [
            'id'         => 'exists:nha_cung_caps,id',
        ];
    }

    public function messages()
    {
        return [
            'exists'      => ':attribute does not exist!',
        ];
    }

    public function attributes()
    {
        return [
            'id'          => 'NhaCungCap',
        ];
    }
}


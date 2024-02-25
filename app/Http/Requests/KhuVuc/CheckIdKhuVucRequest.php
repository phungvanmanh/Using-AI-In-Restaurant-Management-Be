<?php

namespace App\Http\Requests\KhuVuc;

use Illuminate\Foundation\Http\FormRequest;

class CheckIdKhuVucRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'         => 'exists:khu_vucs,id',
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
            'id'         => 'Area',
        ];
    }
}

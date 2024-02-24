<?php

namespace App\Http\Requests\Quyen;

use Illuminate\Foundation\Http\FormRequest;

class CheckIdQuyenRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'         => 'exists:quyens,id',
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
            'id'         => 'Quyền',
        ];
    }
}

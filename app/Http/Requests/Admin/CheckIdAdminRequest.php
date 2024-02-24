<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CheckIdAdminRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'         => 'exists:admins,id',
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

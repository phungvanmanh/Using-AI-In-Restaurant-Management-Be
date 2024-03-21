<?php

namespace App\Http\Requests\Quyen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuyenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                      => 'exists:quyens,id',
            'name_permission'         => 'required|min:4',
            'status'                  => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute cannot be left blank!',
            'min'               => ':attribute must have at least :min characters!',
            'exists'            => ':attribute does not exist!',
            'numeric'           => ':attribute must be a number!',
        ];
    }

    public function attributes()
    {
        return [
            'id'                      => 'Permission',
            'name_permission'         => 'Name permission',
            'status'                  => 'Status',
        ];
    }
}

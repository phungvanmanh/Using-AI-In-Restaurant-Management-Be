<?php

namespace App\Http\Requests\Quyen;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuyenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_permission'         => 'required|min:4',
            'status'                  => 'required|numeric',
            'amount'                  => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute cannot be left blank!',
            'min'               => ':attribute must have at least :min characters!',
            'numeric'           => ':attribute must be a number!',
        ];
    }

    public function attributes()
    {
        return [
            'name_permission'         => 'Name Permission',
            'status'                  => 'Status',
            'amount'                  => 'Amount',
        ];
    }
}

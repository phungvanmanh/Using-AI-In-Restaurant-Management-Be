<?php

namespace App\Http\Requests\Ban;

use Illuminate\Foundation\Http\FormRequest;

class CreateBanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_area'         => 'required|min:4',
            'slug_area'         => 'required|min:4',
            'status'            => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute cannot be left blank!',
            'min'               => ':attribute must have at least :min character!',
            'numeric'           => ':attribute must be a number!',
        ];
    }

    public function attributes()
    {
        return [
            'name_area'         => 'Name area',
            'slug_area'         => 'Slug area',
            'status'            => 'Status',
        ];
    }
}

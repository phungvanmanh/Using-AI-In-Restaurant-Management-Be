<?php

namespace App\Http\Requests\KhuVuc;

use Illuminate\Foundation\Http\FormRequest;

class CreateKhuVucRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_category'         => 'required|min:4',
            'slug_category'         => 'required|min:4',
            'status'                => 'required|numeric',
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
            'name_category'         => 'Name category',
            'slug_category'         => 'Slug category',
            'status'                => 'Status',
        ]
    }
}

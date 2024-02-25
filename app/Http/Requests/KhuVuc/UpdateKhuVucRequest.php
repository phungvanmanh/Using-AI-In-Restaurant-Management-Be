<?php

namespace App\Http\Requests\KhuVuc;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKhuVucRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                    => 'exists:khu_vucs,id',
            'name_area'             => 'required|min:4',
            'slug_area'             => 'required|min:4',
            'status'                => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'exists'            => ':attribute does not exist!',
            'required'          => ':attribute cannot be left blank',
            'min'               => ':attribute must have at least :min character',
            'numeric'           => ':attribute must be a number',
        ];
    }

    public function attributes()
    {
        return [
            'id'                    => 'Area',
            'name_area'             => 'Name area',
            'slug_area'             => 'Slug area',
            'status'                => 'Status',
        ];
    }
}

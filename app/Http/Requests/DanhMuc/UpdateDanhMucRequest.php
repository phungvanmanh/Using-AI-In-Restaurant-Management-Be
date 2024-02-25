<?php

namespace App\Http\Requests\DanhMuc;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDanhMucRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                    => 'exists:danh_mucs,id',
            'name_category'         => 'required|min:4',
            'slug_category'         => 'required|min:4',
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
            'id'                    => 'Category',
            'name_category'         => 'Name category',
            'slug_category'         => 'Slug category',
            'status'                => 'Status',
        ];
    }
}

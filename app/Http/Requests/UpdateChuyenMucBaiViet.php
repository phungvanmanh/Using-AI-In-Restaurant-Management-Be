<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChuyenMucBaiViet extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_chuyen_muc'        => 'required|min:2|regex:/^[a-zA-Z_\p{L}\s.,]+$/u',
            'slug_chuyen_muc'       =>  'required|between:4,50|unique:chuyen_muc_bai_viets,slug_chuyen_muc,' .$this->id,
            'tinh_trang'            =>  'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ten_chuyen_muc.required'   => 'Category name is required.',
            'ten_chuyen_muc.between'    => 'Category name must be between 2 and 50 characters.',
            'ten_chuyen_muc.regex'      => 'Category name cannot contain special characters.',
            'slug_chuyen_muc.required'  => 'Category slug is required.',
            'slug_chuyen_muc.between'   => 'Category slug must be between 2 and 50 characters.',
            'slug_chuyen_muc.unique'    => 'Category slug already exists.',
            'tinh_trang.required'       => 'Status is required.',
            'tinh_trang.boolean'        => 'Invalid selection for status.',

        ];
    }
}

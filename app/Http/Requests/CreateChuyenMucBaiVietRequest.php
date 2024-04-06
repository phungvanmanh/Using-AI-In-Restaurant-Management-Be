<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChuyenMucBaiVietRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_chuyen_muc'        =>  'required|between:5,50',
            'slug_chuyen_muc'       =>  'required|between:4,50|unique:chuyen_muc_bai_viets,slug_chuyen_muc',
            'tinh_trang'            =>  'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ten_chuyen_muc.required'   => 'Category name is required.',
            'ten_chuyen_muc.between'    => 'Category name must be between 5 and 50 characters.',
            'slug_chuyen_muc.required'  => 'Category slug is required.',
            'slug_chuyen_muc.between'   => 'Category slug must be between 4 and 50 characters.',
            'slug_chuyen_muc.unique'    => 'Category slug already exists.',
            'tinh_trang.*'              => 'Invalid selection for status.',
        ];
    }
}

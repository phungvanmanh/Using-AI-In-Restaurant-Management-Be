<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createNguyenLieu extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'ten_nguyen_lieu'       =>'required|min:2|max:30',
            'slug_nguyen_lieu'      =>'required|min:2|unique:nguyen_lieus,slug_nguyen_lieu',
            'gia'                   =>'required|numeric|min:0',
            'don_vi_tinh'                   =>'required|min:1',
            'tinh_trang'            =>'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'ten_nguyen_lieu.required' => 'Name of Ingredient is required.',
            'ten_nguyen_lieu.min' => 'Name of Ingredient must be at least 5 characters.',
            'ten_nguyen_lieu.max' => 'Name of Ingredient can be maximum 30 characters.',
            'slug_nguyen_lieu.' => 'Ingredient Slug already exists!',
            'gia.' => 'Price must be at least 0đ.',
            'don_vi_tinh.' => 'Unit is required.',
            'don_vi_tinh.min' => 'Unit must be at least 1 character.',
            'tinh_trang.*' => 'Please select the status as required!',

        ];
    }
}

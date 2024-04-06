<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBaiVietRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tieu_de_bai_viet' => 'required|unique:bai_viet1s,tieu_de_bai_viet',
            'slug_bai_viet' => 'required',
            'hinh_anh_bai_viet' => 'required',
            'mo_ta_ngan_bai_viet' => 'required',
            'mo_ta_chi_tiet_bai_viet' => 'required',
            'id_chuyen_muc_bai_viet' => 'required',
            'tinh_trang' => 'required'
        ];
    }
    
    public function messages()
    {
        return [
            'tieu_de_bai_viet.required' => 'You have not entered the article title.',
            'tieu_de_bai_viet.unique' => 'The article title already exists in the database.',
            'slug_bai_viet.required' => 'You have not entered the article slug.',
            'hinh_anh_bai_viet.required' => 'You have not selected the article image.',
            'mo_ta_ngan_bai_viet.required' => 'You have not entered the short description of the article.',
            'mo_ta_chi_tiet_bai_viet.required' => 'You have not entered the detailed description of the article.',
            'id_chuyen_muc_bai_viet.required' => 'You have not selected the category of the article.',
            'tinh_trang.required' => 'You have not selected the status.'
            
        ];
    }
    
}

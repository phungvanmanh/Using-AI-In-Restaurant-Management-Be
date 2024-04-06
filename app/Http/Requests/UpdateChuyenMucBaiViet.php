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
            'ten_chuyen_muc'        =>  'required|between:5,50',
            'slug_chuyen_muc'       =>  'required|between:4,50|unique:chuyen_muc_bai_viets,slug_chuyen_muc,' .$this->id,
            'tinh_trang'            =>  'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ten_chuyen_muc.required'        =>  'Tên chuyên mục yêu cầu phải nhập',
            'ten_chuyen_muc.between'         =>  'Tên chuyên mục phải từ 5 đến 50 ký tự',
            'slug_chuyen_muc.required'       =>  'Slug chuyên mục yêu cầu phải nhập',
            'slug_chuyen_muc.between'        =>  'Slug chuyên mục phải từ 4 đến 50 ký tự',
            'slug_chuyen_muc.unique'         =>  'Slug chuyên mục đã tồn tại',
            'tinh_trang.*'                   =>  'Tình trạng chọn không chính xác',
        ];
    }
}

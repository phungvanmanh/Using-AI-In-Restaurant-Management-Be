<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNhaCungCap extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ma_so_thue'            => 'required|integer|digits_between:1,9|regex:/^[0-9]+$/|unique:nha_cung_caps,ma_so_thue',
            'ten_cong_ty'           => 'required|between:2,20',
            'ten_nguoi_dai_dien'    => 'required',
            // 'so_dien_thoai'         => 'required|digits:10|regex:/^[0-9]{10}$/',
            'email'                 => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/|unique:nha_cung_caps,email',
            'dia_chi'               => 'required',
            'ten_goi_nho'           => 'required',
            'tinh_trang'            => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ma_so_thue.required'           => 'Tax ID is required!',
            'ma_so_thue.integer'            => 'Tax ID must be an integer!',
            'ma_so_thue.digits_between'     => 'Tax ID must be less than 10 digits!',
            'ma_so_thue.regex'              => 'Tax ID must be a positive integer with no special characters or spaces!',
            'ma_so_thue.unique'             => 'Tax ID already exists in the system!',
            'ten_cong_ty.required'          => 'Company name is required!',
            'ten_cong_ty.between'           => 'Company name must be between 2 and 20 characters!',
            'ten_nguoi_dai_dien.required'   => 'Representative name is required!',
            'so_dien_thoai.required'        => 'Phone number is required!',
            // 'so_dien_thoai.digits'          => 'Phone number must be exactly 10 digits!',
            // 'so_dien_thoai.regex'           => 'Phone number must be exactly 10 digits with no special characters or spaces!',
            'email.required'                => 'Email is required!',
            'email.email'                   => 'Email must be in the correct format!',
            'email.regex'                   => 'Email must be a valid @gmail.com address with no special characters or spaces!',
            'email.unique'                  => 'Email already exists!',
            'dia_chi.required'              => 'Address is required!',
            'ten_goi_nho.required'          => 'Nickname is required!',
            'tinh_trang.required'           => 'Status is required!',
            'tinh_trang.boolean'            => 'Invalid selection for status!',
        ];
    }


}

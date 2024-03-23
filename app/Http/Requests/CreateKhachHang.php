<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateKhachHang extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    return [
        'ten_khach_hang' => 'required|min:3', // ít nhất 3 ký tự (lớn hơn 2)
        'so_dien_thoai'  => [
            'required',
            'digits:10',
            Rule::unique('khach_hangs')->ignore($this->id), // Điều này giả sử bạn đang sử dụng Eloquent ORM và tên bảng trong cơ sở dữ liệu là 'ten_bang_trong_database'
        ],
        'email'          => 'required|email:rfc,dns', // email đúng định dạng
    ];
}
    
public function messages()
{
    return [
        'required'      => ':attribute không được để trống!',
        'min'           => ':attribute phải có ít nhất :min ký tự!',
        'digits'        => ':attribute phải có :digits chữ số!',
        'email'         => ':attribute không đúng định dạng!',
        'unique'        => ':attribute số điện thoại đã đăng kí!',
    ];
}
    
    
    public function attributes()
    {
        return [
            'ten_khach_hang'     => 'Khách hàng',
            'so_dien_thoai'  => 'Số điện thoại',
            'email'          => 'Email',
        ];
    }
    
}

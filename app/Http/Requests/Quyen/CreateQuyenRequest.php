<?php

namespace App\Http\Requests\Quyen;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuyenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_quyen'         => 'required|min:4',
            'tinh_trang'        => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute không được để trống',
            'min'               => ':attribute phải có ít nhất :min ký tự',
            'numeric'           => ':attribute phải là số',
        ];
    }

    public function attributes()
    {
        return [
            'ten_quyen'         => 'Tên quyền',
            'tinh_trang'        => 'Tình trạng',
        ];
    }
}

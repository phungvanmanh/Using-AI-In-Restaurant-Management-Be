<?php

namespace App\Http\Requests\Quyen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuyenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                => 'exists:quyens,id',
            'ten_quyen'         => 'required|min:4',
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute không được để trống',
            'min'               => ':attribute phải có ít nhất :min ký tự',
            'exists'            => ':attribute không tồn tại',
        ];
    }

    public function attributes()
    {
        return [
            'id'                => 'Quyền',
            'ten_quyen'         => 'Tên quyền',
        ];
    }
}

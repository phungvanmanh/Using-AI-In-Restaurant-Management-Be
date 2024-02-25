<?php
namespace App\Http\Requests\MonAn;

use Illuminate\Foundation\Http\FormRequest;

class createMonAnRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'food_name'    => 'required|min:2',
            'price'        => 'required|min:2',
            'id_category'  => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required'       => ':attribute không được để trống',
            'min'            => ':attribute phải có ít nhất :min ký tự',
            'numeric'        => ':attribute phải là số',
        ];
    }

    public function attributes()
    {
        return [
            'food_name'     => 'Tên món ăn',
            'price'         => 'Giá',
            'id_category'   => 'Danh mục ID',
        ];
    }
}

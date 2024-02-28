<?php

namespace App\Http\Requests\Ban;

use Illuminate\Foundation\Http\FormRequest;

class CheckIdBanRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id'         => 'exists:bans,id',
        ];
    }

    public function messages()
    {
        return [
            'exists'      => ':attribute does not exist!',
        ];
    }

    public function attributes()
    {
        return [
            'id'         => 'Table',
        ];
    }
}

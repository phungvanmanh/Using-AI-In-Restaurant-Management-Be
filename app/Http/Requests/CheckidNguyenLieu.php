<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckidNguyenLieu extends FormRequest
{ public function rules()
    {
        return [
            'id'         => 'exists:nguyen_lieus,id',
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
            'id'          => 'NguyenLieu',
        ];
    }
}

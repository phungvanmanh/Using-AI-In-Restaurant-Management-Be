<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMaGiamGiaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ma_giam_gia' => 'required|string',
            'id_mon' => 'required|integer',
            'phan_tram_giam' => 'required|numeric',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'status' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'ma_giam_gia.required' => 'Discount code cannot be empty.',
            'id_mon.required' => 'Course ID cannot be empty.',
            'phan_tram_giam.required' => 'Discount percentage cannot be empty.',
            'ngay_bat_dau.required' => 'Start date cannot be empty.',
            'ngay_ket_thuc.required' => 'End date cannot be empty.',
            'ngay_ket_thuc.after' => 'End date must be later than start date.',
            'status.required' => 'Status cannot be empty.',
        ];
    }

}

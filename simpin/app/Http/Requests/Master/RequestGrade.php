<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class RequestGrade extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode' => 'required',
            'grade_name' => 'required',
            'simp_pokok' => 'required',
            'simp_wajib' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'kode.required' => 'Kode Harus Diisi',
            'grade_name.required' => 'Nama Grade Harus Diisi',
            'simp_pokok.required' => 'Simpanan Pokok Harus Diisi',
            'simp_wajib.required' => 'Simpanan Wajib Harus Diisi',
        ];
    }
}

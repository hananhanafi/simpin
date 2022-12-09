<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class RequestDepartemen extends FormRequest
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
            'departemen' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'kode.required' => 'Kode Harus Diisi',
            'departemen.required' => 'Nama Departemen Harus Diisi',
        ];
    }
}

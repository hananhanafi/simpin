<?php

namespace App\Http\Requests\Data;

use Illuminate\Foundation\Http\FormRequest;

class RequestAnggota extends FormRequest
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
            'no_anggota' => 'required',
            'nama' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'no_anggota.required' => 'Nomor Anggota Harus Diisi',
            'nama.required' => 'Nama Anggota Harus Diisi',
        ];
    }
}

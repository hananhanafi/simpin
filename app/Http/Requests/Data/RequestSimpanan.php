<?php

namespace App\Http\Requests\Data;

use Illuminate\Foundation\Http\FormRequest;

class RequestSimpanan extends FormRequest
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
            'saldo_minimal' => 'required',
            'no_anggota' => 'required',
            'nama' => 'required',
            'produk_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'saldo_minimal.required' => 'Saldo Minimal Harus Di Isi',
            'no_anggota.required' => 'Data Anggota Harus Di Pilih',
            'nama.required' => 'Nama Harus Di Isi',
            'produk_id.required' => 'Jenis Simpanan Harus Di Pilih',
        ];
    }
}

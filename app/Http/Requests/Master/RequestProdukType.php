<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class RequestProdukType extends FormRequest
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
            'nama' => 'required',
            'tipe_produk' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'kode.required' => 'Kode Produk Harus Di Isi',
            'nama.required' => 'Nama Tipe Produk Harus Di Isi',
            'tipe_produk.required' => 'Tipe Produk Harus Di Isi',
        ];
    }
}

<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class RequestProduk extends FormRequest
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
            'nama_produk' => 'required',
            'tipe_produk' => 'required',
            'admin_fee' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'kode.required' => 'Kode Produk Harus Di Isi',
            'nama_produk.required' => 'Nama Produk Harus Di Isi',
            'tipe_produk.required' => 'Tipe Produk Harus Di Isi',
            'admin_fee.required' => 'Admin Fee Harus Di Isi',
        ];
    }
}

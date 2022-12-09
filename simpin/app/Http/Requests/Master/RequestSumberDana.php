<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class RequestSumberDana extends FormRequest
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
            'sumber_dana' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'kode.required' => 'Kode Profit Harus Di Isi',
            'sumber_dana.required' => 'Sumber Dana Harus Di Isi',
        ];
    }
}

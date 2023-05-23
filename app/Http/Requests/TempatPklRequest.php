<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TempatPklRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $rules = [
            'name'      => 'required',
            'alamat'    => 'required',
            'telepon'   => 'required|numeric',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nama Tempat PKL Wajib Diisi',
            'alamat.required'     => 'Alamat Wajib Diisi',
            'telepon.required'     => 'Nomor Telepon Wajib Diisi',
            'telepon.numeric'     => 'Nomor Telepon Harus Berupa Angka',
        ];
    }
}

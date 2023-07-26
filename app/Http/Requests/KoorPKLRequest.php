<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KoorPklRequest extends FormRequest
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
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email',
            'nomor_induk'       => 'required|min:8|unique:users,nomor_induk',
            'wa'                => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama Koordinator PKL Wajib Diisi',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'nomor_induk.required'  => 'NIP Wajib Diisi',
            'nomor_induk.unique'    => 'NIP Sudah Ada',
            'wa.required'           => 'No WhatsApp Wajib Diisi',
            'email.unique'          => 'Email Sudah Digunakan',
            'nomor_induk.min'       => 'Nomor Induk Minimal Terdiri Dari 8 Angka'
        ];
    }
}

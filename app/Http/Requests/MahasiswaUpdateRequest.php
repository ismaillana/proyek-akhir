<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class MahasiswaUpdateRequest extends FormRequest
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
            'email'             => 'required|email|unique:users,email,'  . $this->mahasiswa->user->id,
            'nomor_induk'       => 'required|min:8|unique:users,nomor_induk,' . $this->mahasiswa->user->id,
            'wa'                => 'required',
            'angkatan'          => 'required',
            'program_studi_id'  => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama Mahasiswa Wajib Diisi',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'nomor_induk.required'  => 'NIM Wajib Diisi',
            'nomor_induk.unique'    => 'NIM Sudah Ada',
            'wa.required'           => 'No WhatsApp Wajib Diisi',
            'angkatan.required'     => 'Tahun Angkatan Wajib Diisi',
            'program_studi_id.required' => 'Program Studi Wajib Diisi',
            'email.unique'          => 'Email Sudah Digunakan',
            'nomor_induk.min'       => 'Nomor Induk Minimal Terdiri Dari 8 Angka'
        ];
    }
}

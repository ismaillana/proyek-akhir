<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumniUpdateRequest extends FormRequest
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
            // 'email'             => 'required|email',
            // 'nomor_induk'       => 'required',

            // 'email'             => 'required|email|unique:users,email,',
           
            // 'nomor_induk'       => 'required|unique:users,nomor_induk,',
            'wa'                => 'required',
            'angkatan'          => 'required',
            'jurusan_id'        => 'required',
            'program_studi_id'  => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama Mahasiswa Wajib Diisi',
            // 'email.required'        => 'Email Wajib Diisi',
            // 'email.email'           => 'Format Email Harus Sesuai',
            // 'nomor_induk.required'  => 'NIM Wajib Diisi',
            // 'nomor_induk.unique'    => 'NIM Sudah Ada',
            'wa.required'           => 'No WhatsApp Wajib Diisi',
            'angkatan.required'     => 'Tahun Angkatan Wajib Diisi',
            'jurusan_id.required'   => 'Jurusan Wajib Diisi',
            'program_studi_id.required' => 'Program Studi Wajib Diisi',
            // 'email.unique' => 'Email Sudah Digunakan'

        ];
    }
}

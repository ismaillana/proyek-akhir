<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengantarPklRequest extends FormRequest
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
            'nama_mahasiswa'    => 'required',
            'nama_perusahaan'   => 'required',
            'alamat'            => 'required',
            'mulai'             => 'required',
            'selesai'           => 'required',
            'telepon'           => 'numeric',
            'kepada'            => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'nama_mahasiswa.required'   => 'Nama Mahasiswa Wajib Diisi',
            'nama_perusahaan.required'  => 'Nama Perusahaan Wajib Diisi',
            'alamat.required'           => 'Alamat Lengkap Wajib Diisi',
            'mulai.required'            => 'Tanggal dan Waktu Mulai Wajib Diisi',
            'selesai.required'          => 'Tanggal dan Waktu Selesai Wajib Diisi',
            'telepon.numeric'           => 'Nomor Telepon Harus Berupa Angka',
            'kepada.required'           => 'Dokumen Wajib Diisi',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispensasiRequest extends FormRequest
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
            'kegiatan'          => 'required',
            'nama_tempat'       => 'required',
            'tgl_mulai'         => 'required',
            'tgl_selesai'       => 'required|after_or_equal:tgl_mulai',
            'dokumen'           => 'required|mimes:pdf'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'nama_mahasiswa.required'   => 'Nama Mahasiswa Wajib Diisi',
            'kegiatan.required'         => 'Nama Kegiatan Wajib Diisi',
            'nama_tempat.required'      => 'Tempat Kegiatan Wajib Diisi',
            'tgl_mulai.required'        => 'Tanggal dan Waktu Mulai Wajib Diisi',
            'tgl_selesai.required'      => 'Tanggal dan Waktu Selesai Wajib Diisi',
            'dokumen.required'          => 'Dokumen Wajib Diisi',
            'dokumen.mimes'             => 'Dokumen yang diupload harus berupa pdf',
            'tgl_selesai.after_or_equal'   => 'Pilih Tanggal Setelah Atau Sama Dengan Tanggal Mulai!',
        ];
    }
}

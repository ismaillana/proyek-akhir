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
            'tempat_pkl_id'     => 'required',
            'tgl_mulai'         => 'required',
            'tgl_selesai'       => 'required',
            'name'              => 'required_if:tempat_pkl_id,perusahaan_lainnya',
            'alamat'            => 'required_if:tempat_pkl_id,perusahaan_lainnya',
            'telepon'           => 'required_if:tempat_pkl_id,perusahaan_lainnya',
            'tujuan_surat'            => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'nama_mahasiswa.required'   => 'Nama Mahasiswa Wajib Diisi',
            'tgl_mulai.required'        => 'Tanggal dan Waktu Mulai Wajib Diisi',
            'tgl_selesai.required'      => 'Tanggal dan Waktu Selesai Wajib Diisi',
            'tempat_pkl_id.required'    => 'Tempat PKL Wajib Diisi',
            'name.required_if'          => 'Nama Perusahaan Wajib Diisi',
            'alamat.required_if'        => 'Alamat Lengkap Wajib Diisi',
            'telepon.required_if'       => 'Nomor Telepon Wajib Diisi',
            'tujuan_surat.required'     => 'Tujuan Surat Wajib Diisi',
        ];
    }
}

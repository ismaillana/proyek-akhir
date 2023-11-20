<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
            'date_time_awal'    => 'required|after_or_equal:' . Carbon::now()->toDateString(), // Hanya menerima tanggal hari ini atau setelahnya',
            'date_time_akhir'   => 'required|after_or_equal:date_time_awal',
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
            'date_time_awal.required'   => 'Tanggal dan Waktu Mulai Wajib Diisi',
            'date_time_akhir.required'  => 'Tanggal dan Waktu Selesai Wajib Diisi',
            'dokumen.required'          => 'Dokumen Wajib Diisi',
            'dokumen.mimes'             => 'Dokumen yang diupload harus berupa pdf',
            'date_time_akhir.after_or_equal'   => 'Pilih Tanggal Setelah Atau Sama Dengan Tanggal Mulai!',
            'date_time_awal.after_or_equal'   => 'Pilih Tanggal Hari Ini Atau Selanjutnya!',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifikasiIjazahRequest extends FormRequest
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
            'nama'            => 'required',
            'nim'             => 'required|numeric',
            'no_ijazah'       => 'required',
            'tahun_lulus'     => 'required|numeric',
            'dokumen'         => 'required|mimes:doc,docx,pdf'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'nama.required'         => 'Nama Mahasiswa Wajib Diisi',
            'nim.required'          => 'NIM Wajib Diisi',
            'nim.numeric'           => 'NIM Harus Berupa Angka',
            'no_ijazah.required'    => 'Nomor Ijazah Wajib Diisi',
            'tahun_lulus.required'  => 'Tahun Lulus Wajib Diisi',
            'tahun_lulus.numeric'   => 'Tahun Lulus Harus Berupa Angka',
            'dokumen.required'      => 'Dokumen Wajib Diisi',
            'dokumen.mimes'         => 'Dokumen yang diupload harus berupa doc/docx/pdf',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LegalisirRequest extends FormRequest
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
            'jenis_legalisir'           => 'required',
            'no_ijazah'                 => 'required',
            'keperluan'                 => 'required',
            'pekerjaan_terakhir'        => 'required',
            'nama_tempat'               => 'required',
            'dokumen'                   => 'required|mimes:pdf'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'jenis_legalisir.required'      => 'Jenis Dokumen Wajib Diisi',
            'keperluan.required'            => 'Keperluan Wajib Diisi',
            'pekerjaan_terakhir.required'   => 'Pekerjaan Terakhir Wajib Diisi',
            'nama_tempat.required'          => 'Tempat Pekerjaan Terakhir Wajib Diisi',
            'dokumen.required'              => 'Dokumen Wajib Diisi',
            'dokumen.mimes'                 => 'Dokumen yang diupload harus berupa pdf',
            'no_ijazah.required'            => 'Nomor Ijazah Wajib Diisi',
        ];
    }
}

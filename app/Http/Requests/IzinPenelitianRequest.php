<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IzinPenelitianRequest extends FormRequest
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
            'nama_tempat'           => 'required',
            'alamat_penelitian'     => 'required',
            'tujuan_surat'          => 'required',
            'perihal'               => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'nama_tempat.required'       => 'Nama Tempat/Instansi Wajib Diisi',
            'alamat_penelitian.required' => 'Alamat Lengkap Wajib Diisi',
            'tujuan_surat.required'      => 'Tujuan Surat Wajib Diisi',
            'perihal.required'           => 'Perihal Wajib Diisi Wajib Diisi',
        ];
    }
}

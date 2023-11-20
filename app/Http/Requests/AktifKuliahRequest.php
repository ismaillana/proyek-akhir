<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AktifKuliahRequest extends FormRequest
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
            'keperluan'          => 'required',
            'status_data'        => 'required',
            'orang_tua'          => 'required_if:status_data,Update Data',
            'pekerjaan'          => 'required_if:status_data,Update Data',
            'semester'           => 'required_if:status_data,Update Data',
            'tahun_ajaran'       => 'required_if:status_data,Update Data',
            'tempat_lahir'       => 'required_if:status_data,Update Data',
            'tanggal_lahir'       => 'required_if:status_data,Update Data',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'keperluan.required'     => 'Keperluan Wajib Diisi',
            'status_data.required'   => 'Pilih Status Data',
            'orang_tua.required_if'  => 'Nama Orang Tua Wajib Diisi',
            'pekerjaan.required_if'  => 'Pekerjaan Orang Tua Wajib Diisi',
            'semester.required_if'   => 'Semester Wajib Diisi',
            'tahun_ajaran.required_if'   => 'Tahun Ajaran Wajib Diisi',
            'tempat_lahir.required_if'   => 'Tempat Lahir Wajib Diisi',
            'tanggal_lahir.required_if'   => 'Tanggal Lahir Wajib Diisi',
        ];
    }
}

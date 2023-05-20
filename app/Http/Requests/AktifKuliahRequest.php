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
            'semester'           => 'required',
            'tanggal_lahir'      => 'required',
            'tempat_lahir'       => 'required',
            'tahun_ajaran'       => 'required',
            'orang_tua'          => 'required',
            'pekerjaan'          => 'required',
            'keperluan'          => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'semester.required'      => 'Semester Wajib Diisi',
            'tanggal_lahir.required' => 'Tanggal Lahir Wajib Diisi',
            'tempat_lahir.required'  => 'Tempat Lahir Wajib Diisi',
            'tahun_ajaran.required'  => 'Tahun Ajaran Wajib Diisi Wajib Diisi',
            'orang_tua.required'     => 'Nama Orang Tua Wajib Diisi Wajib Diisi',
            'pekerjaan.required'     => 'Pekerjaan Orang Tua Wajib Diisi',
            'keperluan.required'     => 'Keperluan Wajib Diisi Wajib Diisi',
        ];
    }
}

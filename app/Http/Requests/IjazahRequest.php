<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IjazahRequest extends FormRequest
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
            'mahasiswa_id'  => 'required',
            'no_ijazah'     => 'required',
            'tahun_lulus' => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'mahasiswa_id.required'       => 'Nama Alumni Wajib Diisi',
            'no_ijazah.required'          => 'Nomor Ijazah Wajib Diisi',
            'tahun_lulus.required'        => 'Tahun Lulusan Wajib Diisi'
        ];
    }
}

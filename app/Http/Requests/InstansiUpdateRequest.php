<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstansiUpdateRequest extends FormRequest
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
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email,'. $this->instansi->user->id,
            'wa'                => 'required',
            'alamat'            => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama Instansi Wajib Diisi',
            'email.required'        => 'Email Wajib Diisi',
            'email.email'           => 'Format Email Harus Sesuai',
            'wa.required'           => 'No WhatsApp Wajib Diisi',
            'alamat.required'     => 'Alamat Wajib Diisi',
            'email.unique' => 'Email Sudah Digunakan'

        ];
    }
}

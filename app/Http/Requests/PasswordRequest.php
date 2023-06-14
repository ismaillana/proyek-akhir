<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'password'              => 'required|min:3',
            'password_confirmation' => 'required|min:3|same:password'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'password.required'             => 'Password Wajib Diisi',
            'password.min'                  => 'Password minimal 3 huruf/angka',
            'password_confirmation.required'=> 'Konfirmasi Password Wajib Diisi',
            'password_confirmation.min'     => 'Konfirmasi Password minimal 3 huruf/angka',
            'password_confirmation.same'    => 'Data Password dan Konfirmasi Password Harus Sama',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KonfirmasiPklRequest extends FormRequest
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
            'status' =>  'required',
            // 'image' =>  'required_if'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'status.required' => 'Status Wajib Diisi',
            // 'image.required_if' => 'Gambar Wajib Diisi'
        ];
    }
}

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
            'keperluan'          => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'keperluan.required'     => 'Keperluan Wajib Diisi',
        ];
    }
}

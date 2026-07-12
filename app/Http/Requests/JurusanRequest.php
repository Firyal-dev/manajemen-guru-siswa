<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Validation rules for Department (Jurusan) creation.
class JurusanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Abbreviation (unique, max 10 chars) and full name.
    public function rules(): array
    {
        return [
            'singkatan' => ['required', 'string', 'max:10', 'unique:jurusans,singkatan'],
            'kepanjangan' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'singkatan.unique' => 'Singkatan ini sudah terdaftar',
        ];
    }
}

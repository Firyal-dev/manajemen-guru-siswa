<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Validation rules for Department (Jurusan) creation & update. Schema mirrors management-nilai.
class JurusanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Name (unique) and academic-year length (in years).
    public function rules(): array
    {
        $jurusanId = $this->route('jurusan')?->id;

        return [
            'nama' => ['required', 'string', 'max:255', Rule::unique('jurusans', 'nama')->ignore($jurusanId)],
            'panjang_tahun_ajaran' => ['required', 'integer', 'min:1', 'max:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.unique' => 'Nama jurusan ini sudah terdaftar',
            'panjang_tahun_ajaran.integer' => 'Panjang tahun ajaran harus berupa angka',
        ];
    }
}

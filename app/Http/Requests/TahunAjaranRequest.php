<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

// Validation rules for academic year.
class TahunAjaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tahun_mulai' => [
                'required', 'integer', 'digits:4', 'min:2000', 'max:2100',
                \Illuminate\Validation\Rule::unique('tahun_ajarans')->ignore($this->route('ta'))
            ],
            'tahun_selesai' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2100', 'gt:tahun_mulai', 'different:tahun_mulai'],
            'aktif' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'tahun_selesai.gt' => 'Tahun akhir harus lebih besar dari tahun awal.',
            'tahun_selesai.different' => 'Tahun awal dan tahun akhir tidak boleh sama.'
        ];
    }
}

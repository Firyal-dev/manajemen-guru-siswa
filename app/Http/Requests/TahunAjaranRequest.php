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

    // Start/end year (4 digits, end > start), optional active flag.
    public function rules(): array
    {
        return [
            'tahun_mulai' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2100'],
            'tahun_selesai' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2100', 'gt:tahun_mulai'],
            'aktif' => ['boolean'],
        ];
    }
}

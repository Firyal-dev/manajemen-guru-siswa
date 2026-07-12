<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Validation rules for Teacher (Guru) create/update.
class GuruRequest extends FormRequest
{
    // All authenticated users can submit.
    public function authorize(): bool
    {
        return true;
    }

    // Name, NIP (unique), religion, gender; optional photo (jpg/png, max 2MB).
    public function rules(): array
    {
        $guruId = $this->route('guru')?->id;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', Rule::unique('gurus', 'nip')->ignore($guruId)],
            'agama' => ['required', 'string', 'max:50'],
            'kelamin' => ['required', 'in:laki_laki,perempuan'],
            'url_foto' => ['nullable', 'image', 'mimes:jpg,png', 'max:2048'],
        ];
    }

    // Indonesian validation error messages.
    public function messages(): array
    {
        return [
            'nip.unique' => 'NIP ini sudah terdaftar',
            'url_foto.image' => 'File harus berupa gambar',
            'url_foto.max' => 'Ukuran foto maksimal 2MB',
        ];
    }
}

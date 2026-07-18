<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MapelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mapelId = $this->route('mapel')?->id;

        return [
            'nama_mapel' => ['required', 'string', 'max:255', Rule::unique('mapels', 'nama_mapel')->ignore($mapelId)],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_mapel.required' => 'Nama mapel wajib diisi.',
            'nama_mapel.unique' => 'Mapel ini sudah terdaftar.',
        ];
    }
}

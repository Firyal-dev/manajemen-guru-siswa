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
            'jurusan_id' => ['nullable', 'exists:jurusans,id'],
            'kelompok' => ['required', Rule::in(['Umum', 'Kejuruan'])],
            'is_not_pai' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Normalisasi & aturan silang:
     * - jurusan_id terisi  => mapel kejuruan  => kelompok = 'Kejuruan'
     * - jurusan_id kosong  => mapel umum      => kelompok = 'Umum'
     * kelompok diturunkan otomatis dari jurusan_id agar data selalu konsisten.
     */
    protected function prepareForValidation(): void
    {
        $jurusanId = $this->input('jurusan_id') ?: null;

        $this->merge([
            'jurusan_id' => $jurusanId,
            'kelompok' => $jurusanId ? 'Kejuruan' : 'Umum',
        ]);
    }

    public function messages(): array
    {
        return [
            'nama_mapel.required' => 'Nama mapel wajib diisi.',
            'nama_mapel.unique' => 'Mapel ini sudah terdaftar.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
        ];
    }
}

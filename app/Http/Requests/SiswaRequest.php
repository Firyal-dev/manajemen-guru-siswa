<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $siswaId = $this->route('siswa')?->id;

        return [
            'nama'       => ['required', 'string', 'max:255'],
            'nis'        => ['required', 'string', Rule::unique('siswas', 'nis')->ignore($siswaId)],
            'nisn'       => ['required', 'string', Rule::unique('siswas', 'nisn')->ignore($siswaId)],
            'agama'      => ['required', 'string', 'max:50'],
            'kelamin'    => ['required', 'in:laki_laki,perempuan'],
            'rombel_id'  => ['nullable', 'exists:rombels,id'],
            'url_foto'   => ['nullable', 'image', 'mimes:jpg,png', 'max:2048', 'dimensions:min_width=100,min_height=100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nis.unique'  => 'NIS ini sudah terdaftar.',
            'nisn.unique' => 'NISN ini sudah terdaftar.',
            'rombel_id.exists' => 'Kelas/Rombel tidak ditemukan.',
            'url_foto.image' => 'File harus berupa gambar.',
            'url_foto.mimes' => 'Foto harus berformat JPG atau PNG.',
            'url_foto.max' => 'Ukuran foto maksimal 2MB.',
            'url_foto.dimensions' => 'Foto minimal berukuran 100x100 piksel.',
        ];
    }
}

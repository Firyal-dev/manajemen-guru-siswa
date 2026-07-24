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
            'nis'        => ['required', 'string', 'max:17', Rule::unique('siswas', 'nis')->ignore($siswaId)],
            'nisn'       => [
                'required', 
                'numeric', 
                function ($attribute, $value, $fail) {
                    $length = strlen((string)$value);
                    if ($length !== 10 && $length !== 16) {
                        $fail('Input harus berupa 10 digit (format NISN) atau 16 digit (format NIK).');
                    }
                    // Verifikasi format NIK (16 digit) sesuai standar Dukcapil
                    if ($length === 16) {
                        $tgl = (int) substr($value, 6, 2);
                        $bln = (int) substr($value, 8, 2);
                        
                        // Validasi bulan lahir (maks 12)
                        if ($bln < 1 || $bln > 12) {
                            $fail('Format NIK tidak valid: Kode bulan lahir salah.');
                        }
                        // Validasi tanggal lahir (perempuan +40, jadi maks 71, laki-laki maks 31)
                        if ($tgl < 1 || ($tgl > 31 && $tgl < 41) || $tgl > 71) {
                            $fail('Format NIK tidak valid: Kode tanggal lahir salah.');
                        }
                    }
                },
                Rule::unique('siswas', 'nisn')->ignore($siswaId)
            ],
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
            'nis.max'     => 'NIS maksimal 17 karakter.',
            'nisn.unique' => 'NISN/NIK ini sudah terdaftar.',
            'nisn.numeric'=> 'NISN/NIK harus murni berupa angka.',
            'rombel_id.exists' => 'Kelas/Rombel tidak ditemukan.',
            'url_foto.image' => 'File harus berupa gambar.',
            'url_foto.mimes' => 'Foto harus berformat JPG atau PNG.',
            'url_foto.max' => 'Ukuran foto maksimal 2MB.',
            'url_foto.dimensions' => 'Foto minimal berukuran 100x100 piksel.',
        ];
    }
}

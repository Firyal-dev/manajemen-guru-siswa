<?php

namespace App\Http\Requests;

use App\Models\Jurusan;
use App\Models\Rombel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

// Validation rules for combined grade + study group creation, with duplicate check.
class KelasRombelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Department, grade level, and array of study groups.
    public function rules(): array
    {
        return [
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'tingkat' => ['required', 'string', 'in:X,XI,XII,XIII'],
            'rombels' => ['required', 'array', 'min:1'],
            'rombels.*.tingkat' => ['required', 'integer', 'min:1', 'distinct:strict'],
            'rombels.*.tahun_ajaran_id' => ['required', 'exists:tahun_ajarans,id'],
        ];
    }

    // Flash first error to session on validation failure.
    protected function failedValidation(Validator $validator): void
    {
        $errorMessage = $validator->errors()->first();

        session()->flash(
            'error',
            $errorMessage ?: 'Gagal menambahkan kelas & rombel. Periksa kembali data yang dimasukkan.'
        );

        throw new ValidationException($validator);
    }

    // Custom after-validation hook: reject duplicate study group numbers.
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $jurusanId = $this->input('jurusan_id');
            $kelasTingkat = $this->input('tingkat');
            $rombels = $this->input('rombels', []);

            if (! $jurusanId || ! $kelasTingkat || empty($rombels)) {
                return;
            }

            $submittedTingkat = collect($rombels)
                ->pluck('tingkat')
                ->filter(fn ($value) => $value !== null && $value !== '')
                ->map(fn ($value) => (int) $value)
                ->values()
                ->all();

            if ($submittedTingkat === []) {
                return;
            }

            $jurusan = Jurusan::find($jurusanId);
            $jurusanLabel = $jurusan?->singkatan ?? 'jurusan yang dipilih';

            $existingRombels = Rombel::query()
                ->whereHas('kelas', function ($query) use ($jurusanId, $kelasTingkat) {
                    $query->where('jurusan_id', $jurusanId)
                        ->where('tingkat', $kelasTingkat);
                })
                ->whereIn('tingkat', $submittedTingkat)
                ->pluck('tingkat')
                ->map(fn ($value) => (int) $value)
                ->all();

            foreach ($rombels as $index => $rombel) {
                $rombelTingkat = (int) ($rombel['tingkat'] ?? 0);

                if ($rombelTingkat > 0 && in_array($rombelTingkat, $existingRombels, true)) {
                    $validator->errors()->add(
                        "rombels.{$index}.tingkat",
                        "Rombel {$rombelTingkat} untuk kelas {$kelasTingkat} {$jurusanLabel} sudah tersedia. Gunakan nomor rombel lain."
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'jurusan_id.required' => 'Jurusan harus dipilih',
            'tingkat.required' => 'Tingkat harus dipilih',
            'tingkat.in' => 'Tingkat tidak valid',
            'rombels.required' => 'Minimal harus ada satu rombel sebelum menyimpan data.',
            'rombels.min' => 'Minimal harus ada satu rombel sebelum menyimpan data.',
            'rombels.*.tingkat.required' => 'Nomor rombel harus diisi',
        ];
    }
}

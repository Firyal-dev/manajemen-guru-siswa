<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Student (Siswa) — personal data, NIS/NISN, assigned to a study group.
#[Fillable(['rombel_id', 'nama', 'nis', 'nisn', 'agama', 'kelamin'])]
class Siswa extends Model
{
    use HasFactory;

    // Cast gender field to Gender enum.
    protected function casts(): array
    {
        return [
            "kelamin" => Gender::class,
        ];
    }

    // Each student belongs to one study group.
    public function rombel(): BelongsTo
    {
        return $this->belongsTo(Rombel::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Study group (Rombel / Rombongan Belajar) — a specific class group within a grade.
#[Fillable(['kelas_id', 'tahun_ajaran_id', 'tingkat'])]
class Rombel extends Model
{
    use HasFactory;

    // A study group belongs to a grade/class.
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    // A study group has many students.
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    // Homeroom teachers via wali_kelas pivot (a rombel can have multiple teachers).
    public function guru(): BelongsToMany
    {
        return $this->belongsToMany(Guru::class, 'wali_kelas');
    }

    // The academic year this study group is active in.
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}

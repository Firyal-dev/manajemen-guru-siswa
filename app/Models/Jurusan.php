<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Department/Major (Jurusan) — e.g. Rekayasa Perangkat Lunak. Schema mirrors management-nilai for sync.
#[Fillable(['nama', 'panjang_tahun_ajaran'])]
class Jurusan extends Model
{
    use HasFactory;

    // A department has many classes (grades).
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }

    // A department has many vocational subjects (mapel kejuruan).
    public function mapels(): HasMany
    {
        return $this->hasMany(Mapel::class);
    }
}

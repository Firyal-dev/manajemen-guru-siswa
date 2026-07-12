<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Department/Major (Jurusan) — e.g. RPL (Rekayasa Perangkat Lunak).
#[Fillable(['singkatan', 'kepanjangan'])]
class Jurusan extends Model
{
    use HasFactory;

    // A department has many classes (grades).
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }
}

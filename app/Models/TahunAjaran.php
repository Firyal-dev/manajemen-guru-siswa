<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Academic year (Tahun Ajaran) — e.g. 2024/2025, with active flag.
#[Fillable(['tahun_mulai', 'tahun_selesai', 'aktif'])]
class TahunAjaran extends Model
{
    use HasFactory;

    // An academic year has many study groups.
    public function rombel(): HasMany
    {
        return $this->hasMany(Rombel::class);
    }

    // Deactivate all years, then activate the one with the given ID.
    public static function active(int $id): self
    {
        static::query()->update(['aktif' => false]);
        $tahunAjaran = static::findOrFail($id);
        $tahunAjaran->update(['aktif' => true]);

        return $tahunAjaran;
    }
}

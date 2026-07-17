<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Study group (Rombel / Rombongan Belajar) — a specific class group within a grade.
#[Fillable(['kelas_id', 'tahun_ajaran_id', 'tingkat', 'kurikulum_id'])]
class Rombel extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('active_tahun_ajaran', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $activeTa = TahunAjaran::where('aktif', true)->first();
            if ($activeTa) {
                $builder->where('tahun_ajaran_id', $activeTa->id);
            }
        });
    }

    // A study group belongs to a grade/class.
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    // A study group has many students (via history table).
    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'riwayat_kelas_siswas')
                    ->withPivot(['tahun_ajaran_id', 'status', 'tanggal_masuk'])
                    ->withTimestamps();
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

    public function kurikulum(): BelongsTo
    {
        return $this->belongsTo(Kurikulum::class);
    }
}

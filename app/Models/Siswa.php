<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['url_foto', 'nama', 'nis', 'nisn', 'agama', 'kelamin', 'status', 'alasan_hapus'])]
class Siswa extends Model
{
    use HasFactory;
    const CREATED_AT = 'tanggal_waktu';
    const UPDATED_AT = null;

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('siswas.status', '1');
        });
    }

    protected function casts(): array
    {
        return [
            "kelamin" => Gender::class,
        ];
    }
    
    // A student has a history of classes (Riwayat Kelas)
    public function riwayatKelas(): HasMany
    {
        return $this->hasMany(RiwayatKelasSiswa::class);
    }

    // Custom method to get the currently active Rombel for the student
    public function rombelAktif()
    {
        // Use request() attributes for caching to prevent stale cache in Octane/Long-running processes
        $req = request();
        if (! $req->attributes->has('active_ta_id')) {
            $activeTa = TahunAjaran::where('aktif', true)->first();
            $req->attributes->set('active_ta_id', $activeTa ? $activeTa->id : -1);
        }
        
        $activeTaId = $req->attributes->get('active_ta_id');
        
        if ($activeTaId === -1) return null;

        $riwayat = $this->riwayatKelas
            ->where('tahun_ajaran_id', $activeTaId)
            ->where('status', 'aktif')
            ->first();

        return $riwayat ? $riwayat->rombel : null;
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;

        return $query->where(function (Builder $q) use ($search) {
            $q->whereLike('nama', "%{$search}%", caseSensitive: false)
              ->orWhereLike('nis', "%{$search}%", caseSensitive: false)
              ->orWhereLike('nisn', "%{$search}%", caseSensitive: false);
        });
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $query->when($filters['agama'] ?? null, function (Builder $q, $agama) {
            $q->where('agama', $agama);
        });

        $query->when($filters['kelamin'] ?? null, function (Builder $q, $kelamin) {
            $q->where('kelamin', $kelamin);
        });

        return $query;
    }
}

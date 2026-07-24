<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['url_foto','nama', 'nis', 'nisn', 'agama', 'kelamin', 'status', 'alasan_hapus'])]
class Siswa extends Model
{
    use HasFactory;
    const CREATED_AT = 'tanggal_waktu';
    const UPDATED_AT = null;

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->whereIn('siswas.status', ['1', 'aktif']);
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
        // Jika sudah diload (eager loaded), gunakan data dari relasi di memori
        if ($this->relationLoaded('rombelAktifRelation')) {
            return $this->rombelAktifRelation;
        }

        // Fallback untuk old behavior (akan memakan memori jika tidak eager loaded)
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

    public function riwayatKelasAktif(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(RiwayatKelasSiswa::class)
            ->where('status', 'aktif')
            ->where('tahun_ajaran_id', function ($query) {
                $query->select('id')->from('tahun_ajarans')->where('aktif', true)->limit(1);
            });
    }

    public function rombelAktifRelation(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            Rombel::class,
            RiwayatKelasSiswa::class,
            'siswa_id', // Foreign key on riwayat_kelas_siswas table
            'id', // Foreign key on rombels table
            'id', // Local key on siswas table
            'rombel_id' // Local key on riwayat_kelas_siswas table
        )->where('riwayat_kelas_siswas.status', 'aktif')
         ->where('riwayat_kelas_siswas.tahun_ajaran_id', function ($query) {
             $query->select('id')->from('tahun_ajarans')->where('aktif', true)->limit(1);
         });
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;

        return $query->where(function (Builder $q) use ($search) {
            if (is_numeric($search)) {
                // Gunakan pencarian Prefix LIKE "123%" agar MySQL menggunakan index BTREE
                $q->where('nis', 'like', "{$search}%")
                  ->orWhere('nisn', 'like', "{$search}%");
            } else {
                $q->whereLike('nama', "%{$search}%", caseSensitive: false);
            }
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

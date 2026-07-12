<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['rombel_id', 'nama', 'nis', 'nisn', 'agama', 'kelamin', 'status', 'alasan_hapus'])]
class Siswa extends Model
{
    use HasFactory;
    const CREATED_AT = 'tanggal_waktu';
    const UPDATED_AT = null;

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', '1');
        });
    }

    protected function casts(): array
    {
        return [
            "kelamin" => Gender::class,
        ];
    }
    public function rombel(): BelongsTo
    {
        return $this->belongsTo(Rombel::class);
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
}

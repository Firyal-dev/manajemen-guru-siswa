<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

// Subject (Mapel) — e.g. Mathematics, Bahasa Indonesia.
#[Fillable(['nama_mapel', 'is_not_pai', 'kelompok', 'jurusan_id'])]
class Mapel extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'is_not_pai' => 'boolean',
    ];

    // A subject can be taught by many teachers.
    public function guru(): BelongsToMany
    {
        return $this->belongsToMany(Guru::class);
    }

    // Department/major — set only for vocational (kejuruan) subjects; null means general (umum).
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Search mapel by name.
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (! $search) return $query;

        return $query->where('nama_mapel', 'like', "%{$search}%");
    }
}

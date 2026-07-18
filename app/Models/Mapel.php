<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Subject (Mapel) — e.g. Mathematics, Bahasa Indonesia.
#[Fillable(['nama_mapel', 'status'])]
class Mapel extends Model
{
    use HasFactory;

    // A subject can be taught by many teachers.
    public function guru(): BelongsToMany
    {
        return $this->belongsToMany(Guru::class);
    }

    // Search mapel by name.
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (! $search) return $query;

        return $query->where('nama_mapel', 'like', "%{$search}%");
    }
}

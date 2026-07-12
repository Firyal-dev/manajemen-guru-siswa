<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Teacher model — stores personal info, photo, and relationships to subjects & homeroom.
#[Fillable(['url_foto', 'nama', 'nip', 'agama', 'kelamin'])]
class Guru extends Model
{
    use HasFactory;

    // Cast gender field to Gender enum.
    protected function casts(): array
    {
        return [
            'kelamin' => Gender::class,
        ];
    }

    // A teacher can teach many subjects.
    public function mapel(): BelongsToMany
    {
        return $this->belongsToMany(Mapel::class);
    }

    // A teacher can be homeroom teacher for many study groups via wali_kelas pivot.
    public function rombel(): BelongsToMany
    {
        return $this->belongsToMany(Rombel::class, 'wali_kelas');
    }

    // Search by name or NIP (case-insensitive partial match).
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;

        return $query->where(function (Builder $q) use ($search) {
            $q->whereLike('nama', "%{$search}%", caseSensitive: false)
                ->orWhereLike('nip', "%{$search}%", caseSensitive: false);
        });
    }
}

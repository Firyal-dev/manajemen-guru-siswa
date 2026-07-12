<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Class/Grade level (Kelas) — e.g. X, XI, XII under a specific department.
#[Fillable(['jurusan_id', 'tingkat'])]
class Kelas extends Model
{
    use HasFactory;

    // Each class belongs to a department.
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    // A class has many study groups (rombel).
    public function rombel(): HasMany
    {
        return $this->hasMany(Rombel::class);
    }
}

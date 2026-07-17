<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kode', 'status'];

    public function rombels()
    {
        return $this->hasMany(Rombel::class);
    }
}

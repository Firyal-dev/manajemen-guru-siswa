<?php

namespace Database\Factories;

use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class TahunAjaranFactory extends Factory
{
    protected $model = TahunAjaran::class;

    public function definition(): array
    {
        $tahun_mulai = fake()->numberBetween(2020, 2026);

        return [
            'tahun_mulai' => $tahun_mulai,
            'tahun_selesai' => $tahun_mulai + 1,
            'aktif' => false,
        ];
    }
}

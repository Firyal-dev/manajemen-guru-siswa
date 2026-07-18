<?php

namespace Database\Factories;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    protected $model = Jurusan::class;

    public function definition(): array
    {
        return [
            'nama' => ucwords(fake()->unique()->words(3, true)),
            'panjang_tahun_ajaran' => fake()->numberBetween(3, 4),
        ];
    }
}

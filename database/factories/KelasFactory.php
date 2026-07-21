<?php

namespace Database\Factories;

use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        return [
            'jurusan_id' => Jurusan::factory(),
            'tingkat' => fake()->randomElement(['X', 'XI', 'XII']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class RombelFactory extends Factory
{
    protected $model = Rombel::class;

    public function definition(): array
    {
        return [
            'kelas_id' => Kelas::factory(),
            'tahun_ajaran_id' => TahunAjaran::factory(),
            'tingkat' => fake()->numberBetween(1, 5),
        ];
    }
}

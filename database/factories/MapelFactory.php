<?php

namespace Database\Factories;

use App\Models\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapelFactory extends Factory
{
    protected $model = Mapel::class;

    public function definition(): array
    {
        return [
            'nama_mapel' => fake()->unique()->word(),
        ];
    }
}

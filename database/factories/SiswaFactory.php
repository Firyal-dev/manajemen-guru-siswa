<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        $gender = fake()->randomElement([Gender::LAKI_LAKI, Gender::PEREMPUAN]);

        return [
            'rombel_id' => Rombel::factory(),
            'nama' => fake()->name($gender === Gender::LAKI_LAKI ? 'male' : 'female'),
            'nis' => fake()->unique()->numerify('########'),
            'nisn' => fake()->unique()->numerify('##########'),
            'agama' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'kelamin' => $gender,
        ];
    }
}

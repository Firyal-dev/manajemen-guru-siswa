<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    protected $model = Guru::class;

    public function definition(): array
    {
        $gender = fake()->randomElement([Gender::LAKI_LAKI, Gender::PEREMPUAN]);

        return [
            'url_foto' => fake()->imageUrl(200, 200, 'people', true, 'guru'),
            'nama' => fake()->name($gender === Gender::LAKI_LAKI ? 'male' : 'female'),
            'nip' => fake()->unique()->numerify('################'),
            'agama' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'kelamin' => $gender,
        ];
    }
}

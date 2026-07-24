<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'firyal@mail.com'],
            [
                'name' => 'firyal',
                'password' => Hash::make('12345678'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'resya@gmail.com'],
            [
                'name' => 'resya',
                'password' => Hash::make('@resya98.'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'riffaganteng@gmail.com'],
            [
                'name' => 'riffa',
                'password' => Hash::make('1234567.'),
            ]
        );

        $this->call([
            // DummyDataSeeder::class, // Diganti dengan data aktual
            DataReal2026Seeder::class,
        ]);
    }
}

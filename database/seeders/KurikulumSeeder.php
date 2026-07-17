<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Kurikulum::create([
            'nama' => 'Kurikulum Merdeka',
            'kode' => 'KM',
            'status' => true,
        ]);

        \App\Models\Kurikulum::create([
            'nama' => 'Kurikulum 2013',
            'kode' => 'K13',
            'status' => true,
        ]);
    }
}

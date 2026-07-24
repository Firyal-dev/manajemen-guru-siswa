<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataReal2026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = __DIR__ . '/seed_guru_siswa_2026_2027.sql';
        
        if (file_exists($sqlPath)) {
            $sql = file_get_contents($sqlPath);
            DB::unprepared($sql);
            $this->command->info('Data Real Guru Siswa 2026/2027 berhasil diseed!');
        } else {
            $this->command->error('File seed_guru_siswa_2026_2027.sql tidak ditemukan di ' . $sqlPath);
        }
    }
}

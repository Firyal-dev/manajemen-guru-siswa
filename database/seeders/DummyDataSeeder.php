<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = Jurusan::factory(5)->create();
        
        $tahunAjarans = TahunAjaran::factory(3)->create();
        
        $mapels = Mapel::factory(10)->create();
        
        $gurus = Guru::factory(20)->create();
        
        $kelas = Kelas::factory(5)->create();
        
        // Generate Rombels based on existing Kelas and Tahun Ajaran
        $rombels = collect();
        foreach ($kelas as $k) {
            $rombels->push(Rombel::factory()->create([
                'kelas_id' => $k->id,
                'tahun_ajaran_id' => $tahunAjarans->first()->id, // Assign to the first academic year for dummy data
            ]));
        }

        // Generate Siswa for each Rombel
        foreach ($rombels as $rombel) {
            Siswa::factory(10)->create([
                'rombel_id' => $rombel->id,
            ]);
        }
    }
}

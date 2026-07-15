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
        $faker = \Faker\Factory::create('id_ID');

        // 1. Tahun Ajaran
        $tahunAjaran = TahunAjaran::create(['tahun_mulai' => 2025, 'tahun_selesai' => 2026, 'aktif' => true]);

        // 2. Jurusan
        $jurusanAK = Jurusan::create(['singkatan' => 'AK', 'kepanjangan' => 'Analis Kimia']); 
        $jurusanFAR = Jurusan::create(['singkatan' => 'FAR', 'kepanjangan' => 'Farmasi']);
        $jurusanPPLG = Jurusan::create(['singkatan' => 'PPLG', 'kepanjangan' => 'Pengembangan Perangkat Lunak dan Gim']);

        // 3. Kelas & Rombel
        $dataRombel = [
            // Analis Kimia (4 Tahun -> 4 Tingkat)
            ['kelas_tingkat' => 'X', 'jurusan_id' => $jurusanAK->id, 'rombel_nama' => 'X AK 1'],
            ['kelas_tingkat' => 'XI', 'jurusan_id' => $jurusanAK->id, 'rombel_nama' => 'XI AK 1'],
            ['kelas_tingkat' => 'XII', 'jurusan_id' => $jurusanAK->id, 'rombel_nama' => 'XII AK 1'],
            ['kelas_tingkat' => 'XIII', 'jurusan_id' => $jurusanAK->id, 'rombel_nama' => 'XIII AK 1'],
            // Farmasi (3 Tahun -> 3 Tingkat)
            ['kelas_tingkat' => 'X', 'jurusan_id' => $jurusanFAR->id, 'rombel_nama' => 'X FAR 1'],
            ['kelas_tingkat' => 'XI', 'jurusan_id' => $jurusanFAR->id, 'rombel_nama' => 'XI FAR 1'],
            ['kelas_tingkat' => 'XII', 'jurusan_id' => $jurusanFAR->id, 'rombel_nama' => 'XII FAR 1'],
            // PPLG (3 Tahun -> 3 Tingkat)
            ['kelas_tingkat' => 'X', 'jurusan_id' => $jurusanPPLG->id, 'rombel_nama' => 'X PPLG 1'],
            ['kelas_tingkat' => 'XI', 'jurusan_id' => $jurusanPPLG->id, 'rombel_nama' => 'XI PPLG 1'],
            ['kelas_tingkat' => 'XII', 'jurusan_id' => $jurusanPPLG->id, 'rombel_nama' => 'XII PPLG 1'],
        ];

        $rombels = [];
        foreach ($dataRombel as $dr) {
            $kelas = Kelas::firstOrCreate([
                'tingkat' => $dr['kelas_tingkat'], 
                'jurusan_id' => $dr['jurusan_id']
            ]);
            $rombels[] = Rombel::create([
                'kelas_id' => $kelas->id,
                'tahun_ajaran_id' => $tahunAjaran->id,
                'tingkat' => $dr['rombel_nama']
            ]);
        }

        // 4. Mapel (Muatan Nasional + Kejuruan)
        $namaMapel = [
            'Pendidikan Agama Islam', 'Pendidikan Pancasila', 'Bahasa Indonesia', 'Matematika', 'Bahasa Inggris', 'Sejarah',
            'Kimia Analisis Dasar', 'Teknik Dasar Pekerjaan Laboratorium Kimia', 'Analisis Kimia Instrumen', // AK
            'Farmakognosi', 'Farmakologi', 'Simulasi Apotek', // FAR
            'Pemrograman Dasar', 'Basis Data', 'Pemrograman Berorientasi Objek', // PPLG
        ];
        
        foreach ($namaMapel as $m) {
            Mapel::create(['nama_mapel' => $m]);
        }

        // 5. Guru (20 Guru Realistis)
        for ($i = 1; $i <= 20; $i++) {
            $nipSuffix = str_pad($i, 5, '0', STR_PAD_LEFT);
            Guru::create([
                'nama' => $faker->name . ($i % 2 == 0 ? ', S.Pd.' : ', M.Kom.'),
                'nip' => "19800101200{$nipSuffix}",
                'kelamin' => $i % 2 == 0 ? 'laki_laki' : 'perempuan',
                'agama' => 'Islam'
            ]);
        }

        // 6. Siswa (25 per Rombel -> Total 250 Siswa)
        $siswaIndex = 1;
        foreach ($rombels as $rombel) {
            for ($i = 0; $i < 25; $i++) {
                $nis = "24" . str_pad($siswaIndex, 4, '0', STR_PAD_LEFT);
                $nisn = "00" . str_pad($siswaIndex, 6, '0', STR_PAD_LEFT);
                
                Siswa::create([
                    'rombel_id' => $rombel->id,
                    'nama' => $faker->name,
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'kelamin' => $i % 2 == 0 ? 'laki_laki' : 'perempuan',
                    'agama' => 'Islam'
                ]);
                $siswaIndex++;
            }
        }
    }
}

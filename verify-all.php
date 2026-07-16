<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "--- 1. TEST CONSTRAINT DENGAN ROMBEL BERBEDA ---\n";
try {
    $r = \App\Models\RiwayatKelasSiswa::first();
    if ($r) {
        $rombelId = $r->rombel_id;
        $tahunId = $r->tahun_ajaran_id;
        $rombel = \App\Models\Rombel::withoutGlobalScopes()->find($rombelId);
        
        $differentRombel = \App\Models\Rombel::withoutGlobalScopes()
            ->where('tahun_ajaran_id', $tahunId)
            ->where('id', '!=', $rombelId)
            ->first();
            
        if (!$differentRombel) {
            echo "Membuat rombel dummy untuk test...\n";
            $differentRombel = \App\Models\Rombel::withoutGlobalScopes()->create([
                'kelas_id' => $rombel->kelas_id,
                'tahun_ajaran_id' => $tahunId,
                'tingkat' => 'TEST'
            ]);
        }

        \App\Models\RiwayatKelasSiswa::create([
            'siswa_id' => $r->siswa_id,
            'rombel_id' => $differentRombel->id,
            'tahun_ajaran_id' => $r->tahun_ajaran_id,
            'tanggal_masuk' => now(),
            'status' => 'aktif'
        ]);
        echo "GAGAL: Duplikasi (rombel beda) lolos!\n";
    } else {
        echo "Belum ada riwayat.\n";
    }
} catch (\Exception $e) {
    echo "SUKSES: Constraint caught -> " . $e->getMessage() . "\n";
}

echo "\n--- 2. BACKFILL DATA COUNT ---\n";
$count = DB::table('riwayat_kelas_siswas')->count();
echo "Total data riwayat_kelas_siswas: " . $count . "\n";

echo "\n--- 3. BUKTI KOLOM ROMBEL_ID DI-DROP ---\n";
$columns = DB::select('SHOW COLUMNS FROM siswas');
$hasRombelId = false;
foreach ($columns as $col) {
    if ($col->Field === 'rombel_id') {
        $hasRombelId = true;
    }
}
echo "Apakah ada kolom rombel_id di tabel siswas? " . ($hasRombelId ? "YA" : "TIDAK") . "\n";

echo "\n--- 4. VALIDASI ROMBEL AKTIF ---\n";
$siswa = \App\Models\Siswa::with('riwayatKelas.rombel')->first();
if ($siswa) {
    $rombel = $siswa->rombelAktif();
    if ($rombel) {
        echo "Siswa: {$siswa->nama} -> Rombel Aktif: {$rombel->tingkat}\n";
    } else {
        echo "Siswa: {$siswa->nama} -> Rombel Aktif: NULL\n";
    }
}

echo "\n--- 5. BUKTI PENCEGAHAN N+1 ---\n";
DB::enableQueryLog();
// Ambil 50 siswa, panggil rombelAktif() masing-masing
$siswas = \App\Models\Siswa::with('riwayatKelas.rombel.kelas')->take(50)->get();
foreach ($siswas as $s) {
    $r = $s->rombelAktif();
}
$queries = DB::getQueryLog();
echo "Jumlah Query dieksekusi: " . count($queries) . " (Harusnya cuma 3-4 query, BUKAN proporsional jumlah siswa)\n";
foreach ($queries as $i => $q) {
    echo "Query " . ($i + 1) . ": " . $q['query'] . "\n";
}

echo "\n--- 7. UJI UPDATE VS INSERT (LOGIC CONTROLLER) ---\n";
try {
    $activeTaId = \App\Models\TahunAjaran::where('aktif', true)->first()->id;
    
    // Ambil siswa dummy 1 (untuk update) - Siswa yang SUDAH punya riwayat
    $siswaUpdate = \App\Models\Siswa::whereHas('riwayatKelas', function($q) use ($activeTaId) {
        $q->where('tahun_ajaran_id', $activeTaId);
    })->first();

    // Ambil siswa dummy 2 (untuk insert) - Siswa yang BELUM punya riwayat
    $siswaInsert = \App\Models\Siswa::whereDoesntHave('riwayatKelas', function($q) use ($activeTaId) {
        $q->where('tahun_ajaran_id', $activeTaId);
    })->first();

    // Rombel tujuan untuk UPDATE (pastikan beda dari rombel sekarang agar Laravel mengeksekusi query UPDATE)
    $currentRombelId = $siswaUpdate->rombelAktif()->id;
    $rombelTujuanUpdate = \App\Models\Rombel::where('tahun_ajaran_id', $activeTaId)
        ->where('id', '!=', $currentRombelId)->first();
        
    if (!$rombelTujuanUpdate) {
        $rombelTujuanUpdate = \App\Models\Rombel::create([
            'kelas_id' => 1,
            'tahun_ajaran_id' => $activeTaId,
            'tingkat' => 'UPDATE-TEST'
        ]);
    }

    $rombelTujuanInsert = \App\Models\Rombel::where('tahun_ajaran_id', $activeTaId)->first()->id;

    DB::enableQueryLog();
    
    // UPDATE SCENARIO: Assign siswa ke rombel baru di tahun ajaran yang sama
    \App\Models\RiwayatKelasSiswa::updateOrCreate(
        ['siswa_id' => $siswaUpdate->id, 'tahun_ajaran_id' => $activeTaId],
        ['rombel_id' => $rombelTujuanUpdate->id, 'status' => 'aktif', 'tanggal_masuk' => now()]
    );
    
    // INSERT SCENARIO: Assign siswa baru ke rombel di tahun ajaran aktif
    \App\Models\RiwayatKelasSiswa::updateOrCreate(
        ['siswa_id' => $siswaInsert->id, 'tahun_ajaran_id' => $activeTaId],
        ['rombel_id' => $rombelTujuanInsert, 'status' => 'aktif', 'tanggal_masuk' => now()]
    );
    
    $queries7 = DB::getQueryLog();
    echo "Logic assign-siswa tereksekusi tanpa error. Detail query INSERT/UPDATE:\n";
    foreach ($queries7 as $q) {
        if (str_contains(strtolower($q['query']), 'insert') || str_contains(strtolower($q['query']), 'update `riwayat_kelas_siswas`')) {
             echo "- " . $q['query'] . "\n";
        }
    }
} catch (\Exception $e) {
    echo "ERROR Uji 7: " . $e->getMessage() . "\n";
}

echo "\n--- 8. UJI FOREIGN KEY RESTRICT ---\n";
try {
    $rombelToDelId = \App\Models\RiwayatKelasSiswa::first()->rombel_id;
    $rombelToDel = \App\Models\Rombel::withoutGlobalScopes()->find($rombelToDelId);
    $rombelToDel->delete();
    echo "GAGAL: Rombel berhasil dihapus padahal ada riwayat!\n";
} catch (\Exception $e) {
    echo "SUKSES: Delete restrict caught -> " . $e->getMessage() . "\n";
}

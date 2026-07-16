<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $r = \App\Models\RiwayatKelasSiswa::first();
    if (!$r) {
        echo "Belum ada data untuk dites!\n";
        exit;
    }
    
    // Attempt duplicate
    \App\Models\RiwayatKelasSiswa::create([
        'siswa_id' => $r->siswa_id,
        'rombel_id' => $r->rombel_id,
        'tahun_ajaran_id' => $r->tahun_ajaran_id,
        'tanggal_masuk' => now(),
        'status' => 'aktif'
    ]);
    
    echo "GAGAL: Duplikasi berhasil lolos!\n";
} catch (\Exception $e) {
    echo "SUKSES: Constraint caught -> " . $e->getMessage() . "\n";
}

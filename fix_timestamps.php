<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Current now(): " . now() . "\n";

$models = [
    \App\Models\TahunAjaran::class,
    \App\Models\Guru::class,
    \App\Models\Siswa::class,
    \App\Models\Jurusan::class,
    \App\Models\Mapel::class,
    \App\Models\Rombel::class,
    \App\Models\RiwayatKelasSiswa::class,
    \App\Models\WaliKelas::class,
    \App\Models\GuruMapel::class
];

foreach ($models as $modelClass) {
    $model = new $modelClass;
    $table = $model->getTable();
    if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'updated_at')) {
        $count = $modelClass::where('updated_at', '>', now())->count();
        if ($count > 0) {
            echo "Fixing $count records in $table ...\n";
            $modelClass::where('updated_at', '>', now())->update(['updated_at' => now()]);
        }
    }
}
echo "Done.\n";

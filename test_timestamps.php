<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$records = \App\Models\RiwayatKelasSiswa::orderBy('updated_at', 'desc')->take(5)->get(['id', 'updated_at']);
foreach ($records as $r) {
    echo $r->id . ' - ' . $r->updated_at . PHP_EOL;
}

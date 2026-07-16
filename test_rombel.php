<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$r = \App\Models\Rombel::with(['kelas', 'kelas.jurusan'])->first();
echo json_encode($r->toArray(), JSON_PRETTY_PRINT);

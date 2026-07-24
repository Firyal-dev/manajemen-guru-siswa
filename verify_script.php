<?php
// Script verifikasi
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/', 'GET')
);

// 1. Cek Route API
echo "=== 1. CEK ROUTE ===\n";
$routes = collect(app('router')->getRoutes())->map(function ($route) {
    return $route->uri();
})->filter(function($uri) {
    return str_contains($uri, 'api') || str_contains($uri, 'siswa-by-rombel') || str_contains($uri, 'penugasan/gurus') || str_contains($uri, 'penugasan/mapels');
})->values()->toArray();
print_r($routes);

// 2. Cek Query Log JurusanController
echo "\n=== 2. CEK QUERY LOG JURUSAN CONTROLLER ===\n";
\DB::enableQueryLog();
$jurusans = \App\Models\Jurusan::with([
    'kelas.rombel' => fn($q) => $q->withCount('siswa'),
    'kelas.rombel.guru'
])->get();
$logs = \DB::getQueryLog();
echo "Jumlah Query: " . count($logs) . "\n";
foreach($logs as $log) {
    if (str_contains($log['query'], 'siswas')) {
        echo "QUERY SISWA DITEMUKAN: " . $log['query'] . "\n";
    }
}
echo "(Jika tidak ada tulisan 'QUERY SISWA DITEMUKAN' dengan tabel 'siswas' di-select semua data, berarti aman. Hanya select count saja.)\n";

// 3. Cek Output apiGurus
echo "\n=== 3. CEK API GURUS ===\n";
$user = \App\Models\User::first();
auth()->login($user);
$req = Illuminate\Http\Request::create('/penugasan/gurus', 'GET');
$res = app()->handle($req);
$gurus = json_decode($res->getContent(), true);
echo "Jumlah Guru dari API (Maks 20): " . count($gurus) . "\n";
if (count($gurus) > 0) {
    echo "Sample data: " . $gurus[0]['text'] . "\n";
}

// 4. Cek HTML Render Wali Kelas Dropdown Empty
echo "\n=== 4. CEK HTML RENDER WALI KELAS ===\n";
$req = Illuminate\Http\Request::create('/penugasan/wali-kelas', 'GET');
$res = app()->handle($req);
$html = $res->getContent();
preg_match('/<div id="guru_select_options"[^>]*>(.*?)<\/div>/s', $html, $matches);
if (!empty($matches[1])) {
    echo "Isi div guru_select_options (harus kosong / comment aja):\n" . trim($matches[1]) . "\n";
} else {
    echo "Elemen guru_select_options tidak ditemukan.\n";
}

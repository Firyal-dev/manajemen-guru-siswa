<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/', 'GET');
$kernel->handle($request);

echo "=========================================\n";
echo "1. ROUTE LIST\n";
echo "=========================================\n";
$routes = collect(app('router')->getRoutes())->map(function ($route) {
    return $route->methods()[0] . " | " . $route->uri() . " | " . $route->getName();
})->filter(function($str) {
    return str_contains($str, 'siswa-by-rombel') || str_contains($str, 'penugasan');
})->values();
foreach ($routes as $route) {
    echo $route . "\n";
}

echo "\n=========================================\n";
echo "2. RAW QUERY LOG - JurusanController::index()\n";
echo "=========================================\n";
\DB::enableQueryLog();
// Simulate index()
$jurusans = \App\Models\Jurusan::with([
    'kelas.rombel' => fn($q) => $q->withCount('siswa'),
    'kelas.rombel.guru'
])->get();
$logs = \DB::getQueryLog();
foreach ($logs as $log) {
    $sql = $log['query'];
    $bindings = $log['bindings'];
    // basic interpolation for bindings
    foreach ($bindings as $binding) {
        $val = is_numeric($binding) ? $binding : "'".addslashes((string)$binding)."'";
        $sql = preg_replace('/\?/', escapeshellarg((string)$val), $sql, 1);
    }
    echo "Query:\n" . $sql . "\nTime: " . $log['time'] . "ms\n\n";
}

echo "\n=========================================\n";
echo "3 & 4. CURL apiGurus (TANPA SEARCH, DGN SEARCH, EXCLUDE WALI KELAS)\n";
echo "=========================================\n";

$user = \App\Models\User::first();
auth()->login($user);

// Ambil ID wali kelas yang aktif
$waliKelasAktif = \App\Models\WaliKelas::first();
if ($waliKelasAktif) {
    $assignedGuruId = $waliKelasAktif->guru_id;
    $assignedGuru = \App\Models\Guru::find($assignedGuruId);
    echo "Wali Kelas aktif ditemukan: ID {$assignedGuruId} ({$assignedGuru->nama})\n\n";
} else {
    // Buat dummy assignment
    $firstGuru = \App\Models\Guru::first();
    $firstRombel = \App\Models\Rombel::first();
    $assignedGuruId = $firstGuru->id;
    \App\Models\WaliKelas::create([
        'guru_id' => $firstGuru->id,
        'rombel_id' => $firstRombel->id,
        'tahun_ajaran_id' => $firstRombel->tahun_ajaran_id,
    ]);
    echo "Membuat data wali kelas sementara... Guru ID {$firstGuru->id} ditugaskan\n\n";
}

echo "A. Request TANPA search keyword (?exclude_wali_kelas=1):\n";
$req = Illuminate\Http\Request::create('/penugasan/gurus', 'GET', ['exclude_wali_kelas' => 1]);
$res = app()->handle($req);
$gurus = json_decode($res->getContent(), true);
echo "Total hasil: " . count($gurus) . "\n";
echo "5 hasil pertama:\n";
foreach (array_slice($gurus, 0, 5) as $g) {
    echo "- ID: {$g['id']}, Text: {$g['text']}\n";
}
// Cek apakah assignedGuru ada di list
$isAssignedGuruInList = collect($gurus)->contains('id', $assignedGuruId);
echo "Apakah guru ID {$assignedGuruId} ada di hasil? " . ($isAssignedGuruInList ? 'YA (GAGAL!)' : 'TIDAK (BERHASIL DI-EXCLUDE)') . "\n\n";

echo "B. Request DENGAN search keyword '?q=adi' (?exclude_wali_kelas=1):\n";
$req = Illuminate\Http\Request::create('/penugasan/gurus', 'GET', ['q' => 'adi', 'exclude_wali_kelas' => 1]);
$res = app()->handle($req);
$gurusSearch = json_decode($res->getContent(), true);
echo "Total hasil: " . count($gurusSearch) . "\n";
foreach ($gurusSearch as $g) {
    echo "- ID: {$g['id']}, Text: {$g['text']}\n";
}

echo "\n=========================================\n";
echo "5. RAW HTML OUTPUT - _select_options (wali-kelas.blade.php)\n";
echo "=========================================\n";
$req = Illuminate\Http\Request::create('/penugasan/wali-kelas', 'GET');
$res = app()->handle($req);
$html = $res->getContent();
preg_match('/<div id="guru_select_options"[^>]*>(.*?)<\/div>/s', $html, $matches);
if (!empty($matches[0])) {
    echo $matches[0] . "\n";
} else {
    echo "Elemen tidak ditemukan!\n";
}

echo "\n=========================================\n";
echo "6. CEK SKALA DATA SISWA PER ROMBEL\n";
echo "=========================================\n";
$maxSiswa = \DB::select("
    SELECT rombel_id, COUNT(*) as total 
    FROM riwayat_kelas_siswas 
    WHERE status = 'aktif'
    GROUP BY rombel_id 
    ORDER BY total DESC 
    LIMIT 1
");
if (!empty($maxSiswa)) {
    echo "Rombel ID: {$maxSiswa[0]->rombel_id}\n";
    echo "Jumlah Maksimal Siswa dlm 1 Rombel: {$maxSiswa[0]->total}\n";
} else {
    echo "Belum ada data siswa di rombel.\n";
}

echo "=========================================\n";

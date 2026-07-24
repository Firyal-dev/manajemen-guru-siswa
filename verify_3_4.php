<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/', 'GET');
$kernel->handle($request);

$user = \App\Models\User::first();
auth()->login($user);

echo "=========================================\n";
echo "VERIFIKASI #3: N+1 rombelAktif (SiswaController::index)\n";
echo "=========================================\n";
\DB::enableQueryLog();
$req = Illuminate\Http\Request::create('/siswa', 'GET');
$res = app()->handle($req);
$logs = \DB::getQueryLog();
echo "Total Queries untuk halaman /siswa: " . count($logs) . "\n";
$rombelQueries = array_filter($logs, function($l) {
    return str_contains($l['query'], 'rombels');
});
$riwayatQueries = array_filter($logs, function($l) {
    return str_contains($l['query'], 'riwayat_kelas_siswas');
});
echo "Query riwayat_kelas_siswas: " . count($riwayatQueries) . "\n";
echo "Query rombels: " . count($rombelQueries) . "\n";
if (count($logs) > 0) {
    echo "\nSample Query Riwayat Aktif:\n";
    echo array_values($riwayatQueries)[0]['query'] ?? 'Not found';
    echo "\n";
}
\DB::flushQueryLog();

echo "\n=========================================\n";
echo "VERIFIKASI #4: Optimasi LIKE search\n";
echo "=========================================\n";
$qNumeric = \App\Models\Siswa::search('1234')->toSql();
echo "1. Search Numeric '1234':\n{$qNumeric}\n\n";

$qAlpha = \App\Models\Siswa::search('budi')->toSql();
echo "2. Search Alphabetic 'budi':\n{$qAlpha}\n";

echo "\n=========================================\n";
echo "VERIFIKASI NIK & NIS VALIDATION\n";
echo "=========================================\n";

$request = new \App\Http\Requests\SiswaRequest();
// Kita buat instance validator manual menggunakan aturan dari SiswaRequest
$rules = $request->rules();

$validator = \Illuminate\Support\Facades\Validator::make([
    'nama' => 'Test', 'agama' => 'Islam', 'kelamin' => 'laki_laki',
    'nis' => '123456789012345678', // 18 chars (invalid max 17)
    'nisn' => '12345' // 5 digits (invalid)
], $rules);

echo "A. Test invalid (NIS > 17 chars, NISN 5 digits):\n";
foreach ($validator->errors()->all() as $err) echo "- $err\n";

$validator2 = \Illuminate\Support\Facades\Validator::make([
    'nama' => 'Test', 'agama' => 'Islam', 'kelamin' => 'laki_laki',
    'nis' => '12345678901234567', // 17 chars (valid)
    'nisn' => '3201017513000001' // 16 digits NIK. Tgl=75 (invalid for laki_laki? wait, perumpuan is +40, but this is 75. Maks = 31+40 = 71. So 75 is invalid!)
], $rules);

echo "\nB. Test invalid NIK (16 digit, tgl lahir 75 > 71):\n";
foreach ($validator2->errors()->all() as $err) echo "- $err\n";

$validator3 = \Illuminate\Support\Facades\Validator::make([
    'nama' => 'Test', 'agama' => 'Islam', 'kelamin' => 'perempuan',
    'nis' => '123456', 
    'nisn' => '3201015505000001' // 16 digits NIK. Tgl=55 (15+40, valid for perempuan), bln=05
], $rules);

echo "\nC. Test valid NIK (16 digit, tgl lahir 55, perempuan):\n";
if ($validator3->passes()) {
    echo "Lolos validasi!\n";
} else {
    foreach ($validator3->errors()->all() as $err) echo "- $err\n";
}

$validator4 = \Illuminate\Support\Facades\Validator::make([
    'nama' => 'Test', 'agama' => 'Islam', 'kelamin' => 'laki_laki',
    'nis' => '123456', 
    'nisn' => '0012345678' // 10 digits NISN (valid)
], $rules);

echo "\nD. Test valid NISN (10 digit):\n";
if ($validator4->passes()) {
    echo "Lolos validasi!\n";
} else {
    foreach ($validator4->errors()->all() as $err) echo "- $err\n";
}

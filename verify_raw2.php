<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/', 'GET');
$kernel->handle($request);

$user = \App\Models\User::first();
auth()->login($user);

echo "=========================================\n";
echo "1. CEK LIMIT 20 GURU\n";
echo "=========================================\n";
$countGurus = \DB::select("SELECT COUNT(*) as total FROM gurus")[0]->total;
echo "Total Guru di Database: {$countGurus}\n";
echo "(Karena total guru {$countGurus} < 20, limit take(20) belum mencapai batas. Berikut adalah snippet kode di PenugasanController::apiGurus yang memastikan query dilimit):\n";

$fileController = file_get_contents(app_path('Http/Controllers/PenugasanController.php'));
preg_match('/public function apiGurus.*?take\(20\).*?get\(\)/s', $fileController, $matchController);
if (!empty($matchController[0])) {
    echo "--- SNIPPET PenugasanController::apiGurus ---\n";
    echo $matchController[0] . "\n------------------------------------------\n";
}

echo "\n=========================================\n";
echo "2. CURL apiMapels (TANPA SEARCH & DGN SEARCH)\n";
echo "=========================================\n";
echo "A. Request apiMapels TANPA search keyword:\n";
$req = Illuminate\Http\Request::create('/penugasan/mapels', 'GET');
$res = app()->handle($req);
$mapels = json_decode($res->getContent(), true);
echo "Total hasil: " . count($mapels) . "\n";
echo "3 hasil pertama:\n";
foreach (array_slice($mapels, 0, 3) as $m) {
    echo "- ID: {$m['id']}, Text: {$m['text']}\n";
}

echo "\nB. Request apiMapels DENGAN search keyword '?q=sejarah':\n";
$req = Illuminate\Http\Request::create('/penugasan/mapels', 'GET', ['q' => 'sejarah']);
$res = app()->handle($req);
$mapelsSearch = json_decode($res->getContent(), true);
echo "Total hasil: " . count($mapelsSearch) . "\n";
foreach ($mapelsSearch as $m) {
    echo "- ID: {$m['id']}, Text: {$m['text']}\n";
}

echo "\n=========================================\n";
echo "3. RAW HTML OUTPUT - _select_options (guru-mapel.blade.php)\n";
echo "=========================================\n";
$req = Illuminate\Http\Request::create('/penugasan/guru-mapel', 'GET');
$res = app()->handle($req);
$html = $res->getContent();

echo "A. Bagian guru_select_options:\n";
preg_match('/<div id="guru_select_options"[^>]*>(.*?)<\/div>/s', $html, $matchGuru);
if (!empty($matchGuru[0])) {
    echo $matchGuru[0] . "\n";
}

echo "\nB. Bagian mapel_select_options:\n";
preg_match('/<div id="mapel_select_options"[^>]*>(.*?)<\/div>/s', $html, $matchMapel);
if (!empty($matchMapel[0])) {
    echo $matchMapel[0] . "\n";
}
echo "=========================================\n";

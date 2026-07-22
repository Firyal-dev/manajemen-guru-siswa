<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$client = App\Models\ApiClient::create(['name' => 'Management Nilai', 'is_active' => true]);
echo $client->createToken('sync-token')->plainTextToken;

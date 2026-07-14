<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\TahunAjaran;

Route::middleware(['throttle:60,1', \App\Http\Middleware\RequireApiKey::class])->group(function () {
    Route::get('/gurus', function () {
        return response()->json(Guru::paginate(50));
    });

    Route::get('/siswas', function () {
        return response()->json(Siswa::paginate(50));
    });

    Route::get('/mapels', function () {
        return response()->json(Mapel::paginate(50));
    });

    Route::get('/rombels', function () {
        return response()->json(Rombel::paginate(50));
    });

    Route::get('/tahun-ajaran/aktif', function () {
        return response()->json(TahunAjaran::where('aktif', 1)->first());
    });

    Route::get('/rombel/{id}/siswa', function ($id) {
        return response()->json(Siswa::where('rombel_id', $id)->paginate(50));
    });
});

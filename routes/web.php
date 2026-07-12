<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasRombelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\TahunAjaranController;
use Illuminate\Support\Facades\Route;

// Redirect root to login.
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated + verified dashboard.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Student page (placeholder, just auth required).
Route::get('/siswa', function () {
    return view('siswa.index');
})->middleware(['auth'])->name('siswa');

// All routes below require authentication.
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Academic years
    Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
    Route::patch('/update-tahun-ajaran', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
    Route::patch('/tahun-ajaran/{ta}', [TahunAjaranController::class, 'active'])->name('tahun-ajaran.active');

    // Teacher CRUD
    Route::get('/guru', [GuruController::class, 'index'])->name('guru');
    Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');
    Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
    Route::get('/guru/{guru}/edit', [GuruController::class, 'edit'])->name('guru.edit');
    Route::patch('/guru/{guru}', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');
    
    // Department listing & creation (uses /kelas for listing URL)
    Route::get('/kelas', [JurusanController::class, 'index'])->name('kelas');
    Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');

    // Grade + Study group (Kelas & Rombel)
    Route::get('/kelas-rombel/create', [KelasRombelController::class, 'createKelasRombel'])->name('kelas-rombel.create');
    Route::post('/kelas-rombel', [KelasRombelController::class, 'storeKelasRombel'])->name('kelas-rombel.store');
    Route::delete('/kelas-rombel/{rombel}', [KelasRombelController::class, 'destroyKelasRombel'])->name('kelas-rombel.destroy');
});

require __DIR__ . '/auth.php';

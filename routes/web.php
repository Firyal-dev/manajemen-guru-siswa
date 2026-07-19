<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasRombelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\MapelController;
// Redirect root to login.
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated + verified dashboard.
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// All routes below require authentication.
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Academic years
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
    Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
    Route::patch('/update-tahun-ajaran', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
    Route::patch('/tahun-ajaran/{ta}', [TahunAjaranController::class, 'active'])->name('tahun-ajaran.active');

    // Kurikulum
    Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.index');
    Route::post('/kurikulum', [KurikulumController::class, 'store'])->name('kurikulum.store');
    Route::patch('/kurikulum/{kurikulum}', [KurikulumController::class, 'update'])->name('kurikulum.update');
    Route::delete('/kurikulum/{kurikulum}', [KurikulumController::class, 'destroy'])->name('kurikulum.destroy');

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

    // Department management (Jurusan) — dedicated CRUD page
    Route::get('/jurusan', [JurusanController::class, 'manage'])->name('jurusan.index');
    Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
    Route::patch('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // Grade + Study group (Kelas & Rombel)
    Route::get('/kelas-rombel/create', [KelasRombelController::class, 'createKelasRombel'])->name('kelas-rombel.create');
    Route::post('/kelas-rombel', [KelasRombelController::class, 'storeKelasRombel'])->name('kelas-rombel.store');
    Route::delete('/kelas-rombel/{rombel}', [KelasRombelController::class, 'destroyKelasRombel'])->name('kelas-rombel.destroy');

    // Subject management (Mapel)
    Route::get('/mapel', [MapelController::class, 'caridata'])->name('mapel.index');
    Route::get('/mapel/create', [MapelController::class, 'create'])->name('mapel.create');
    Route::post('/mapel', [MapelController::class, 'store'])->name('mapel.store');
    Route::get('/mapel/{mapel}/edit', [MapelController::class, 'edit'])->name('mapel.edit');
    Route::patch('/mapel/{mapel}', [MapelController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{mapel}', [MapelController::class, 'destroy'])->name('mapel.destroy');
    
    // Assign Siswa to Rombel
    Route::get('/kelas-rombel/{rombel}/assign-siswa', [KelasRombelController::class, 'assignSiswa'])->name('kelas-rombel.assign-siswa');
    Route::post('/kelas-rombel/{rombel}/assign-siswa', [KelasRombelController::class, 'updateAssignSiswa'])->name('kelas-rombel.update-assign-siswa');
    Route::post('/kelas-rombel/api/siswas', [KelasRombelController::class, 'apiSiswas'])->name('kelas-rombel.api-siswas');

    // Student CRUD
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::patch('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    // Penugasan
    Route::get('/penugasan/wali-kelas', [\App\Http\Controllers\PenugasanController::class, 'indexWaliKelas'])->name('penugasan.wali-kelas');
    Route::post('/penugasan/wali-kelas', [\App\Http\Controllers\PenugasanController::class, 'storeWaliKelas'])->name('penugasan.wali-kelas.store');
    Route::delete('/penugasan/wali-kelas/{waliKelas}', [\App\Http\Controllers\PenugasanController::class, 'destroyWaliKelas'])->name('penugasan.wali-kelas.destroy');

    Route::get('/penugasan/guru-mapel', [\App\Http\Controllers\PenugasanController::class, 'indexGuruMapel'])->name('penugasan.guru-mapel');
    Route::post('/penugasan/guru-mapel', [\App\Http\Controllers\PenugasanController::class, 'storeGuruMapel'])->name('penugasan.guru-mapel.store');
    Route::get('/penugasan/rombels', [\App\Http\Controllers\PenugasanController::class, 'apiRombels'])->name('penugasan.rombels');
    Route::delete('/penugasan/guru-mapel/{guruMapel}', [\App\Http\Controllers\PenugasanController::class, 'destroyGuruMapel'])->name('penugasan.guru-mapel.destroy');
});

require __DIR__ . '/auth.php';

use App\Http\Controllers\FallbackController;
Route::fallback(FallbackController::class);



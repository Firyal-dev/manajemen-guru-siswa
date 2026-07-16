<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\TahunAjaran;

Route::middleware(['throttle:60,1', \App\Http\Middleware\RequireApiKey::class])->group(function () {
    Route::get('/version', function () {
        $models = [
            \App\Models\TahunAjaran::class,
            \App\Models\Guru::class,
            \App\Models\Siswa::class,
            \App\Models\Jurusan::class,
            \App\Models\Mapel::class,
            \App\Models\Rombel::class,
            \App\Models\RiwayatKelasSiswa::class,
            \App\Models\WaliKelas::class,
            \App\Models\GuruMapel::class
        ];

        $maxDate = null;
        foreach ($models as $modelClass) {
            $model = new $modelClass;
            $table = $model->getTable();
            $query = $modelClass::query();
            
            if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($modelClass)) && \Illuminate\Support\Facades\Schema::hasColumn($table, 'deleted_at')) {
                $query->withTrashed();
                $maxDeleted = $query->max('deleted_at');
                if ($maxDeleted && (!$maxDate || $maxDeleted > $maxDate)) {
                    $maxDate = $maxDeleted;
                }
            }
            
            if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'updated_at')) {
                $maxUpdated = $query->max('updated_at');
                if ($maxUpdated && (!$maxDate || $maxUpdated > $maxDate)) {
                    $maxDate = $maxUpdated;
                }
            }
        }

        return response()->json([
            'version' => $maxDate,
            'timestamp' => $maxDate ? \Carbon\Carbon::parse($maxDate)->toIso8601String() : null
        ]);
    });

    Route::get('/gurus', function () {
        return response()->json(Guru::paginate(50));
    });

    Route::get('/siswas', function () {
        return response()->json(Siswa::paginate(50));
    });

    Route::get('/jurusans', function () {
        return response()->json(\App\Models\Jurusan::paginate(50));
    });

    Route::get('/mapels', function () {
        return response()->json(Mapel::paginate(50));
    });

    Route::get('/rombels', function () {
        return response()->json(Rombel::with('kelas')->paginate(50));
    });

    Route::get('/tahun-ajarans', function () {
        return response()->json(TahunAjaran::paginate(50));
    });

    Route::get('/tahun-ajaran/aktif', function () {
        return response()->json(TahunAjaran::where('aktif', 1)->first());
    });
    
    Route::get('/riwayat-kelas', function () {
        return response()->json(\App\Models\RiwayatKelasSiswa::paginate(100));
    });

    Route::get('/rombel/{id}/siswa', function ($id) {
        $siswaIds = \App\Models\RiwayatKelasSiswa::where('rombel_id', $id)->pluck('siswa_id');
        return response()->json(Siswa::whereIn('id', $siswaIds)->paginate(50));
    });

    Route::get('/wali-kelas', function () {
        return response()->json(\App\Models\WaliKelas::paginate(50));
    });

    Route::get('/guru-mapel', function () {
        return response()->json(\App\Models\GuruMapel::paginate(50));
    });
});

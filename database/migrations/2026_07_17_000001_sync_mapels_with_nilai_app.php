<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menyamakan struktur tabel `mapels` dengan aplikasi management-nilai
 * agar data dapat saling disinkronisasi.
 *
 * Kolom bersama: is_not_pai, kelompok, jurusan_id, deleted_at (SoftDeletes).
 * Kolom `status` (khas app ini) tetap dipertahankan untuk kompatibilitas controller.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            if (! Schema::hasColumn('mapels', 'is_not_pai')) {
                $table->boolean('is_not_pai')->default(false)->after('nama_mapel');
            }
            if (! Schema::hasColumn('mapels', 'kelompok')) {
                $table->enum('kelompok', ['Umum', 'Kejuruan'])->nullable()->after('is_not_pai');
            }
            if (! Schema::hasColumn('mapels', 'jurusan_id')) {
                $table->foreignId('jurusan_id')->nullable()->after('kelompok')
                    ->constrained('jurusans')->restrictOnDelete();
            }
            if (! Schema::hasColumn('mapels', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            if (Schema::hasColumn('mapels', 'jurusan_id')) {
                $table->dropForeign(['jurusan_id']);
                $table->dropColumn('jurusan_id');
            }
            foreach (['is_not_pai', 'kelompok'] as $col) {
                if (Schema::hasColumn('mapels', $col)) {
                    $table->dropColumn($col);
                }
            }
            if (Schema::hasColumn('mapels', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};

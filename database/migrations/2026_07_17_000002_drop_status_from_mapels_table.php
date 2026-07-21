<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menghapus kolom `status` dari tabel `mapels`.
 * Soft-delete kini ditangani oleh kolom `deleted_at` (SoftDeletes),
 * menyamakan mekanisme dengan aplikasi management-nilai.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            if (Schema::hasColumn('mapels', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            if (! Schema::hasColumn('mapels', 'status')) {
                $table->string('status')->default('1')->after('jurusan_id');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_kelas_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->restrictOnDelete();
            $table->foreignId('rombel_id')->constrained('rombels')->restrictOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->restrictOnDelete();
            $table->enum('status', ['aktif', 'pindah', 'lulus', 'keluar'])->default('aktif');
            $table->date('tanggal_masuk');
            $table->timestamps();

            $table->unique(['siswa_id', 'tahun_ajaran_id']);
        });

        // Backfill existing assignments
        DB::statement("
            INSERT INTO riwayat_kelas_siswas (siswa_id, rombel_id, tahun_ajaran_id, tanggal_masuk, status, created_at, updated_at)
            SELECT s.id, s.rombel_id, r.tahun_ajaran_id, CURRENT_DATE, 'aktif', NOW(), NOW()
            FROM siswas s
            JOIN rombels r ON s.rombel_id = r.id
            WHERE s.rombel_id IS NOT NULL
        ");

        // Drop column rombel_id from siswas
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['rombel_id']);
            $table->dropColumn('rombel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->foreignId('rombel_id')->nullable()->constrained('rombels')->nullOnDelete();
        });

        // Restore active assignments
        DB::statement("
            UPDATE siswas s
            JOIN riwayat_kelas_siswas rks ON s.id = rks.siswa_id
            JOIN tahun_ajarans ta ON rks.tahun_ajaran_id = ta.id
            SET s.rombel_id = rks.rombel_id
            WHERE ta.aktif = 1 AND rks.status = 'aktif'
        ");

        Schema::dropIfExists('riwayat_kelas_siswas');
    }
};

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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nis')->unique();
            $table->string('nisn')->unique();
            $table->string('agama');
            $table->string('kelamin');
            $table->string('url_foto')->nullable();
            $table->foreignId('rombel_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('tanggal_waktu')->nullable();
            $table->string('status')->default('1');
            $table->string('alasan_hapus')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};

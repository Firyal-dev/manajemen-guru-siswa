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
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained();
            $table->foreignId('tahun_ajaran_id')->constrained();
            $table->string('tingkat'); // 10 AK 1, 10 AK 2, 11 FM 1, 11, FM 2, dst
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};

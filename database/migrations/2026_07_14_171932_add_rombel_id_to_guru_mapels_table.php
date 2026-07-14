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
        Schema::table('guru_mapels', function (Blueprint $table) {
            $table->foreignId('rombel_id')->after('mapel_id')->constrained('rombels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru_mapels', function (Blueprint $table) {
            $table->dropForeign(['rombel_id']);
            $table->dropColumn('rombel_id');
        });
    }
};

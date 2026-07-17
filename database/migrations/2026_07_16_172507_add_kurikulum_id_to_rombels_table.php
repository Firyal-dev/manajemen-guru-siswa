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
        // Insert default kurikulum if it doesn't exist so foreign key constraint doesn't fail
        if (\Illuminate\Support\Facades\DB::table('kurikulums')->count() === 0) {
            \Illuminate\Support\Facades\DB::table('kurikulums')->insert([
                ['id' => 1, 'nama' => 'Kurikulum Merdeka', 'kode' => 'KM', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'nama' => 'Kurikulum 2013', 'kode' => 'K13', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        Schema::table('rombels', function (Blueprint $table) {
            $table->foreignId('kurikulum_id')->default(1)->constrained('kurikulums')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rombels', function (Blueprint $table) {
            $table->dropForeign(['kurikulum_id']);
            $table->dropColumn('kurikulum_id');
        });
    }
};

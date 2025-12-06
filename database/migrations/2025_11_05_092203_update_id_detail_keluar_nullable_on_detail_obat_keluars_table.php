<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perubahan pada database.
     */
    public function up(): void
    {
        Schema::table('detail_obat_keluars', function (Blueprint $table) {
            $table->string('Id_Detail_Keluar', 100)->nullable()->change();
        });
    }

    /**
     * Kembalikan perubahan jika di-rollback.
     */
    public function down(): void
    {
        Schema::table('detail_obat_keluars', function (Blueprint $table) {
            $table->string('Id_Detail_Keluar', 100)->nullable(false)->change();
        });
    }
};

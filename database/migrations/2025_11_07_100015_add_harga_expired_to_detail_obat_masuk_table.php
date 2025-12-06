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
    Schema::table('detail_obat_masuks', function (Blueprint $table) {
        if (!Schema::hasColumn('detail_obat_masuks', 'Harga_Beli')) {
            $table->integer('Harga_Beli')->nullable()->after('Jumlah');
        }

        if (!Schema::hasColumn('detail_obat_masuks', 'Tanggal_Kadaluwarsa')) {
            $table->date('Tanggal_Kadaluwarsa')->nullable()->after('Harga_Beli');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_obat_masuks', function (Blueprint $table) {
            //
        });
    }
};

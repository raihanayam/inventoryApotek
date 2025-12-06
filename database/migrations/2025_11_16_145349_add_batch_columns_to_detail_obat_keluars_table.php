<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('detail_obat_keluars', function (Blueprint $table) {
        $table->integer('Harga_Beli')->nullable()->after('Jumlah');
        $table->date('Tanggal_Kadaluwarsa')->nullable()->after('Harga_Beli');
    });
}

public function down()
{
    Schema::table('detail_obat_keluars', function (Blueprint $table) {
        $table->dropColumn(['Harga_Beli', 'Tanggal_Kadaluwarsa']);
    });
}

};

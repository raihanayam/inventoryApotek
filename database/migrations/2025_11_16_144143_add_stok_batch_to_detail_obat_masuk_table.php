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
    Schema::table('detail_obat_masuks', function (Blueprint $table) {
        $table->integer('stok_batch')->default(0);
    });
}

public function down()
{
    Schema::table('detail_obat_masuks', function (Blueprint $table) {
        $table->dropColumn('stok_batch');
    });
}

};

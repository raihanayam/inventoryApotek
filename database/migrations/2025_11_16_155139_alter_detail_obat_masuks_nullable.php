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
            $table->string('Id_Detail_Masuk', 100)->nullable()->change();
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->unsignedBigInteger('obat_masuk_id')->nullable()->change();
            $table->integer('Jumlah')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_obat_masuks', function (Blueprint $table) {
            $table->string('Id_Detail_Masuk', 100)->nullable(false)->change();
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
            $table->unsignedBigInteger('obat_masuk_id')->nullable(false)->change();
            $table->integer('Jumlah')->nullable(false)->change();
        });
    }
};

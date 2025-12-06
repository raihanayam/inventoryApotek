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
        Schema::create('detail_obat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('Id_Detail_Keluar', 100);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('obat_keluar_id');
            $table->integer('Jumlah');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('obat_keluar_id')->references('id')->on('obat_keluars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_obat_keluars');
    }
};

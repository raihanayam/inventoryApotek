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
        Schema::create('obat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('Id_Masuk', 100)->nullable();
            $table->unsignedBigInteger('Id_User');
            $table->date('Tanggal_Masuk');
            $table->decimal('total', 10, 2);
            $table->timestamps();

            $table->foreign('Id_User')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_masuks');
    }
};

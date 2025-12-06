<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('obat_keluars', function (Blueprint $table) {
            $table->string('Id_Keluar')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('obat_keluars', function (Blueprint $table) {
            $table->string('Id_Keluar')->nullable(false)->change();
        });
    }
};


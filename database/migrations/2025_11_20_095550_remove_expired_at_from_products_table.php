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
    Schema::table('products', function (Blueprint $table) {
        if (Schema::hasColumn('products', 'expired_at')) {
            $table->dropColumn('expired_at');
        }
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->date('expired_at')->nullable();
    });
}

};

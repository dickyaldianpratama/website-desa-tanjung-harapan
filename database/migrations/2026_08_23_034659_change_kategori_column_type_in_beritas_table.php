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
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('kategori')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Kita tidak bisa me-rollback ke enum lama dengan mudah jika sudah ada data lain, 
            // tapi sebagai formalitas kita kembalikan ke string biasa atau enum.
            $table->string('kategori')->change();
        });
    }
};

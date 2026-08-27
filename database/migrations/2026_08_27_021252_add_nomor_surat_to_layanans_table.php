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
        Schema::table('layanans', function (Blueprint $table) {
            $table->string('nomor_surat')->nullable()->after('nomor_tiket');
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn('nomor_surat');
        });
    }
};

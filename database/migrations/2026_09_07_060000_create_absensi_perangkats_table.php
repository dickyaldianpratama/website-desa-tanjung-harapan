<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi_perangkats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perangkat_id')->constrained('perangkats')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'belum'])->default('belum');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Unique: 1 perangkat hanya 1 record per tanggal
            $table->unique(['perangkat_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi_perangkats');
    }
};

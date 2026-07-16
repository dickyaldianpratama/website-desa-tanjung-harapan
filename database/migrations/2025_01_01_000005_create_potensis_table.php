<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('potensis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->enum('kategori', ['wisata', 'umkm', 'pertanian', 'budaya'])->default('wisata');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('potensis');
    }
};

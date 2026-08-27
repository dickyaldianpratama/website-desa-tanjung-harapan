<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            // Posisi gambar: kombinasi horizontal & vertikal, e.g. "center center", "left top"
            $table->string('image_position')->default('center center')->after('gambar');
            // Kualitas kompresi gambar saat diupload (1-100, default 85)
            $table->unsignedTinyInteger('image_quality')->default(85)->after('image_position');
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['image_position', 'image_quality']);
        });
    }
};

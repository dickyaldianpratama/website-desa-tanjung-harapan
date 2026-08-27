<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            // Zoom level gambar: 100 = normal (1x), 200 = zoom 2x, maks 300 = 3x
            $table->unsignedSmallInteger('image_scale')->default(100)->after('image_quality');
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('image_scale');
        });
    }
};

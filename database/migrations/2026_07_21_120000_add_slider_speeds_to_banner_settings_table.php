<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banner_settings', function (Blueprint $table) {
            // Home-page product slider auto-switch speed (ms). 0 = no autoplay.
            $table->integer('new_slider_speed')->default(3000)->after('rotation_speed');
            $table->integer('popular_slider_speed')->default(3000)->after('new_slider_speed');
            $table->integer('sale_slider_speed')->default(3000)->after('popular_slider_speed');
        });
    }

    public function down(): void
    {
        Schema::table('banner_settings', function (Blueprint $table) {
            $table->dropColumn(['new_slider_speed', 'popular_slider_speed', 'sale_slider_speed']);
        });
    }
};

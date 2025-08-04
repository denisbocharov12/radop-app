<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('rotation_speed')->default(3000);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_settings');
    }
};

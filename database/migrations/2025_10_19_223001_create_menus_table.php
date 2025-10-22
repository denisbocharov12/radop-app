<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Widget programmatic key');
            $table->string('name')->comment('Widget name');
            $table->string('link')->nullable()->comment('Main menu link');
            $table->text('description')->nullable()->comment('Widget description');
            $table->boolean('is_active')->default(true)->comment('Widget active status');
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};


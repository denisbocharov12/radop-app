<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('header_menus', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Header menu programmatic key');
            $table->string('name')->comment('Header menu name');
            $table->string('link')->nullable()->comment('Main menu link');
            $table->text('description')->nullable()->comment('Menu description');
            $table->boolean('is_active')->default(true)->comment('Menu active status');
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_menus');
    }
};

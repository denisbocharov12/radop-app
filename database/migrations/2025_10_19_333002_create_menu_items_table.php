<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade')->comment('Menu ID');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade')->comment('Parent item (Adjacency List pattern)');
            $table->integer('order')->default(0)->comment('Sort order');
            $table->enum('type', ['category', 'custom_link', 'promo_block'])->default('custom_link')->comment('Item type');
            $table->string('title')->comment('Item title');
            $table->string('link')->nullable()->comment('Item link');
            $table->string('target')->default('_self')->comment('Link target attribute');
            $table->string('icon_class')->nullable()->comment('CSS icon class');
            $table->json('content_data')->nullable()->comment('Additional data (JSON for promo_block, etc.)');
            $table->boolean('is_active')->default(true)->comment('Item active status');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['menu_id', 'parent_id', 'order']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};


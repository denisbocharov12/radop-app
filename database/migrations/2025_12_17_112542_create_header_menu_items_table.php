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
        Schema::create('header_menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('header_menu_id')->constrained()->onDelete('cascade')->comment('Header Menu ID');
            $table->foreignId('parent_id')->nullable()->constrained('header_menu_items')->onDelete('cascade')->comment('Parent item (Adjacency List pattern)');
            $table->integer('order')->default(0)->comment('Sort order');
            $table->enum('type', ['category', 'custom_link', 'promo_block', 'widget_link'])->default('custom_link')->comment('Item type');
            $table->string('title')->comment('Item title');
            $table->string('link')->nullable()->comment('Item link');
            $table->string('target')->default('_self')->comment('Link target attribute');
            $table->string('icon_class')->nullable()->comment('CSS icon class');
            $table->json('content_data')->nullable()->comment('Additional data (JSON for promo_block, etc.)');
            $table->string('category_id')->nullable()->comment('Category OneC ID');
            $table->boolean('is_active')->default(true)->comment('Item active status');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['header_menu_id', 'parent_id', 'order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_menu_items');
    }
};

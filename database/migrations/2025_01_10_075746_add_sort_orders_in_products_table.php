<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('sale_order')->nullable();
            $table->integer('new_order')->nullable();
            $table->integer('popular_order')->nullable();
            $table->integer('hot_order')->nullable();
            $table->integer('featured_order')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sale_order',
                'new_order',
                'popular_order',
                'hot_order',
                'featured_order',
            ]);
        });
    }
};

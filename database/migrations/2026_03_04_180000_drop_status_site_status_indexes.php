<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_brand_status_idx');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_status_parent_idx');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex('brands_status_idx');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index(['brand_id', 'status', 'site_status'], 'products_brand_status_idx');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index(['status', 'parent_id'], 'categories_status_parent_idx');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->index('status', 'brands_status_idx');
        });
    }
};

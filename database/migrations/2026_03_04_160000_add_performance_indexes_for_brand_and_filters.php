<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('brand_id', 'products_brand_id_idx');
            $table->index('onec_id', 'products_onec_id_idx');
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->index('product_id', 'product_categories_product_id_idx');
            $table->index('category_id', 'product_categories_category_id_idx');
            $table->index(['product_id', 'category_id'], 'product_categories_pid_cid_idx');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('onec_id', 'categories_onec_id_idx');
            $table->index('parent_id', 'categories_parent_id_idx');
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->index('product_onec_id', 'attribute_values_product_idx');
            $table->index('attribute_onec_id', 'attribute_values_attr_idx');
            $table->index(['product_onec_id', 'attribute_onec_id'], 'attribute_values_p_a_idx');
        });

        Schema::table('product_profiles', function (Blueprint $table) {
            $table->index('product_id', 'product_profiles_product_id_idx');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->index('onec_id', 'brands_onec_id_idx');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_brand_id_idx');
            $table->dropIndex('products_onec_id_idx');
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropIndex('product_categories_product_id_idx');
            $table->dropIndex('product_categories_category_id_idx');
            $table->dropIndex('product_categories_pid_cid_idx');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_onec_id_idx');
            $table->dropIndex('categories_parent_id_idx');
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropIndex('attribute_values_product_idx');
            $table->dropIndex('attribute_values_attr_idx');
            $table->dropIndex('attribute_values_p_a_idx');
        });

        Schema::table('product_profiles', function (Blueprint $table) {
            $table->dropIndex('product_profiles_product_id_idx');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex('brands_onec_id_idx');
        });
    }
};

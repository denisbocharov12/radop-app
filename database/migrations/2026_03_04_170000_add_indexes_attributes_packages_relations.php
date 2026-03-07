<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->index('onec_id', 'attributes_onec_id_idx');
        });

        Schema::table('product_attributes', function (Blueprint $table) {
            $table->index('product_id', 'product_attributes_product_id_idx');
            $table->index('attribute_id', 'product_attributes_attribute_id_idx');
            $table->index(['product_id', 'attribute_id'], 'product_attributes_p_a_idx');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->index('product_onec_id', 'packages_product_onec_id_idx');
        });

        Schema::table('product_category_sorts', function (Blueprint $table) {
            $table->index('product_id', 'product_category_sorts_product_id_idx');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index('product_id', 'order_items_product_id_idx');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->index(['model_type', 'model_id'], 'media_model_idx');
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->index('product_id', 'favorites_product_id_idx');
            $table->index(['user_id', 'product_id'], 'favorites_user_product_idx');
        });
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropIndex('attributes_onec_id_idx');
        });

        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropIndex('product_attributes_product_id_idx');
            $table->dropIndex('product_attributes_attribute_id_idx');
            $table->dropIndex('product_attributes_p_a_idx');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropIndex('packages_product_onec_id_idx');
        });

        Schema::table('product_category_sorts', function (Blueprint $table) {
            $table->dropIndex('product_category_sorts_product_id_idx');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex('order_items_product_id_idx');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dropIndex('media_model_idx');
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->dropIndex('favorites_product_id_idx');
            $table->dropIndex('favorites_user_product_idx');
        });
    }
};

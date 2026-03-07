<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_profiles', function (Blueprint $table) {
            $table->dropIndex('product_profiles_condition_idx');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->dropIndex('attributes_status_idx');
        });
    }

    public function down(): void
    {
        Schema::table('product_profiles', function (Blueprint $table) {
            $table->index('condition', 'product_profiles_condition_idx');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->index('status', 'attributes_status_idx');
        });
    }
};

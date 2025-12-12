<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('category_id')->nullable()->after('icon_class')->comment('Category onec_id for autofill');
            
            DB::statement("ALTER TABLE menu_items MODIFY COLUMN type ENUM('category', 'custom_link', 'promo_block', 'widget_link') DEFAULT 'custom_link'");
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('category_id');
            DB::statement("ALTER TABLE menu_items MODIFY COLUMN type ENUM('category', 'custom_link', 'promo_block') DEFAULT 'custom_link'");
        });
    }
};

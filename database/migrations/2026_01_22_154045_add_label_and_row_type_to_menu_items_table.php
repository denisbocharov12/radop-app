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
            $table->json('label_name')->nullable()->after('title')->comment('Label name (translatable)');
            $table->string('label_color', 7)->nullable()->after('label_name')->comment('Label color in hex format (#FFFFFF)');
            $table->boolean('display_title')->default(false)->after('label_color')->comment('Display title as header for row type');
            $table->boolean('display_as_link')->default(true)->after('display_title')->comment('Display as link or subtitle');
            
            DB::statement("ALTER TABLE menu_items MODIFY COLUMN type ENUM('category', 'custom_link', 'promo_block', 'widget_link', 'row') DEFAULT 'custom_link'");
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['label_name', 'label_color', 'display_title', 'display_as_link']);
            DB::statement("ALTER TABLE menu_items MODIFY COLUMN type ENUM('category', 'custom_link', 'promo_block', 'widget_link') DEFAULT 'custom_link'");
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->tinyInteger('column')->nullable()->after('catalog_order')->comment('Column (1-3)');
            $table->integer('column_order')->nullable()->after('column')->comment('Column sorting order');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['column', 'column_order']);
        });
    }
};

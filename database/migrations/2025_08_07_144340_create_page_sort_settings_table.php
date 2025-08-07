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
        Schema::create('page_sort_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page'); // brand, category, shop
            $table->string('default_sort'); // например: popularity, price_asc, price_desc, newest
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_sort_settings');
    }
};

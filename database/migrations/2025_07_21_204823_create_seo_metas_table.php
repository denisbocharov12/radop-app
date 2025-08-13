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
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();
            $table->string('page_type');
            $table->string('page_id')->nullable();
            $table->string('locale');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical')->nullable();
            $table->string('robots')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};

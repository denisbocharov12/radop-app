<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('sku')->nullable();
            $table->mediumText('summary')->nullable();
            $table->longText('description')->nullable();
            $table->float('iur_price', 32)->nullable();
            $table->text('upp_sale')->nullable();
            $table->string('condition')->default('regular');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_profiles');
    }
};

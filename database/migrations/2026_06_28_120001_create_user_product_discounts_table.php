<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Per-user discount applied to an individual product within a category.
     * Either a percent off the user's base price or a fixed unit price.
     */
    public function up(): void
    {
        Schema::create('user_product_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('product_onec_id');                 // products.onec_id
            $table->string('category_onec_id')->nullable();    // origin category (for the admin UI grouping)
            $table->string('discount_type', 16);               // 'percent' | 'fixed'
            $table->decimal('discount_value', 12, 2);          // % (0-100) or fixed price
            $table->timestamps();

            $table->unique(['user_id', 'product_onec_id']);
            $table->index('product_onec_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_product_discounts');
    }
};

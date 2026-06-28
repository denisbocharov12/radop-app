<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Per-user discount applied to an ENTIRE category (percent only).
     */
    public function up(): void
    {
        Schema::create('user_category_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('category_onec_id');           // categories.onec_id
            $table->decimal('discount_percent', 5, 2);    // 0.00 — 100.00
            $table->timestamps();

            $table->unique(['user_id', 'category_onec_id']);
            $table->index('category_onec_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_category_discounts');
    }
};

<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->string('product_onec_id');
            $table->text('text');
            $table->decimal('score', 2, 1)->default(5.0);
            $table->boolean('status')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('product_onec_id');
            $table->index(['product_onec_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};


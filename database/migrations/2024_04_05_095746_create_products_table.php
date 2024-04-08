<?php

use App\Models\Brand;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('onec_id')->nullable();
            $table->text('title');
            $table->string('slug')->unique();
            $table->string('stock')->default(0);
            $table->string('unit')->nullable();
            $table->float('price', 32)->default(0);
            $table->float('sale_price', 32)->nullable();
            $table->boolean('status')->default(true);
            $table->foreignIdFor(Brand::class, 'brand_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

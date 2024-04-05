<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('onec_id')->nullable();
            $table->foreignIdFor(Category::class, 'parent_id')->nullable();
            $table->string('name',255);
            $table->mediumText('summary')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('order')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

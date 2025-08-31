<?php

declare(strict_types=1);

use App\Models\Brand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand_view_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)->constrained('brands');
            $table->string('ip_address')->nullable();
            $table->string('session_id')->nullable();
            $table->bigInteger('view_count')->default(0);
            $table->timestamp('last_viewed_at')->nullable();
            $table->timestamps();

            $table->index(['brand_id', 'ip_address', 'session_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_view_counts');
    }
};

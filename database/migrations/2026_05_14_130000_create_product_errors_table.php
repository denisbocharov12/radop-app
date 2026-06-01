<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Stores one row per (product, error type) so the admin panel can surface
 * products that came out of the 1C imports incomplete or broken — missing
 * images, categories, brand (critical) or description / attributes (minor).
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_errors', function (Blueprint $table): void {
            $table->id();
            $table->string('product_onec_id')->index();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('product_title')->nullable();
            $table->string('type', 64)->index();           // missing_images, missing_category, ...
            $table->string('severity', 16)->index();        // critical | minor
            $table->string('source', 32)->default('scan');  // scan | nomenclature | description | ...
            $table->text('message')->nullable();
            $table->json('context')->nullable();
            $table->timestamp('resolved_at')->nullable()->index();
            $table->timestamps();

            // One active record per product per error type — scans use
            // updateOrCreate against this key.
            $table->unique(['product_onec_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_errors');
    }
};

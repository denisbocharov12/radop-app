<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('delivery_settings')) {
            return;
        }

        Schema::create('delivery_settings', function (Blueprint $table) {
            $table->id();
            // Free delivery for a supplement order (дозаказ) is available every
            // day within [start, end); after the end time normal order rules apply.
            $table->boolean('supplement_free_enabled')->default(true);
            $table->time('supplement_free_start')->default('08:00:00');
            $table->time('supplement_free_end')->default('15:00:00');
            $table->timestamps();
        });

        DB::table('delivery_settings')->insert([
            'supplement_free_enabled' => true,
            'supplement_free_start'   => '08:00:00',
            'supplement_free_end'     => '15:00:00',
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_settings');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('code')->unique();
            $table->enum('type',['fixed','percent'])->default('fixed');
            $table->string('value')->default(0);
            $table->boolean('status')->default(true);
            $table->string('minimal_total')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

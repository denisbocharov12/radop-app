<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_activations', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignIdFor( User::class,'user_id')->constrained()->cascadeOnDelete();
            $table->string('token');
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activations');
    }
};

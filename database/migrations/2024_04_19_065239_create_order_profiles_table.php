<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class, 'order_id')->constrained()->cascadeOnDelete();
            $table->string('company_name')->nullable();
            $table->string('reserve_phone')->nullable();
            $table->string('bank')->nullable();
            $table->string('idno')->nullable();
            $table->string('tva')->nullable();
            $table->string('registered_city')->nullable();
            $table->string('iur_address')->nullable();
            $table->string('shipping_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_profiles');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_number')->unique();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('user_type'); // fiz/iur or from UserType Model
            $table->string('city');

            $table->string('note')->nullable();

            $table->foreignIdFor(User::class, 'user_id')->nullable();
            $table->foreignIdFor(User::class, 'manager_id')->nullable();

            $table->string('payment_method')->default('cash');
            $table->string('payment_status')->default('unpaid');
            $table->string('status')->default('pending');

            $table->string('subtotal')->nullable();
            $table->string('discount')->nullable();
            $table->string('total')->nullable();

            $table->string('delivery_charge')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

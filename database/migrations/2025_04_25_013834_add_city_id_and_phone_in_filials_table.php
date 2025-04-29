<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('filials', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('contact_name');
            $table->foreignIdFor(City::class, 'city_id')->after('phone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('filials', function (Blueprint $table) {
            $table->dropColumn(['phone', 'city_id']);
        });
    }
};

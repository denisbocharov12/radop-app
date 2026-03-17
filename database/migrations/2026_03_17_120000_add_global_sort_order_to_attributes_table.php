<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->unsignedInteger('global_sort_order')->default(0)->after('order');
        });
        DB::table('attributes')->whereNotNull('order')->update(['global_sort_order' => DB::raw('`order`')]);
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn('global_sort_order');
        });
    }
};

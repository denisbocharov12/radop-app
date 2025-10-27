<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('page_sort_settings')->insert([
            [
                'page' => 'new',
                'default_sort' => 'condition',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page' => 'popular',
                'default_sort' => 'popular_order',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page' => 'sale',
                'default_sort' => 'price',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('page_sort_settings')->whereIn('page', ['new', 'popular', 'sale'])->delete();
    }
};

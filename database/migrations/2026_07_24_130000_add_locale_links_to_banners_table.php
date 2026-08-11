<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Per-locale banner links. The legacy single `link` column is kept as a fallback
 * and is backfilled into both locale columns for existing banners.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            if (!Schema::hasColumn('banners', 'link_ru')) {
                $table->string('link_ru')->nullable()->after('link');
            }
            if (!Schema::hasColumn('banners', 'link_ro')) {
                $table->string('link_ro')->nullable()->after('link_ru');
            }
        });

        DB::statement('UPDATE banners SET link_ru = link, link_ro = link WHERE link IS NOT NULL');
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['link_ru', 'link_ro']);
        });
    }
};

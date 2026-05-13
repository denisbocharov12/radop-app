<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add a `content` long-text column to `seo_metas` for the visible long-form
 * body copy (rendered on the page, not as a meta tag). Kept inside the same
 * table so all SEO data shares one lookup and one cache invalidation path.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('seo_metas', function (Blueprint $table): void {
            $table->longText('content')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('seo_metas', function (Blueprint $table): void {
            $table->dropColumn('content');
        });
    }
};

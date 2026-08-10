<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Speeds up the view-count reports (period aggregation + daily activity series)
 * which filter/group by last_viewed_at. Idempotent: skips tables where the index
 * already exists (a prior partial run may have created some of them).
 */
return new class extends Migration
{
    private array $tables = ['product_view_counts', 'category_view_counts', 'brand_view_counts'];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            $indexName = $table . '_last_viewed_at_index';

            if ($this->indexExists($table, $indexName)) {
                continue;
            }

            Schema::table($table, function (Blueprint $t) use ($indexName) {
                $t->index('last_viewed_at', $indexName);
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            $indexName = $table . '_last_viewed_at_index';

            if (!$this->indexExists($table, $indexName)) {
                continue;
            }

            Schema::table($table, function (Blueprint $t) use ($indexName) {
                $t->dropIndex($indexName);
            });
        }
    }

    private function indexExists(string $table, string $indexName): bool
    {
        return DB::selectOne(
            'SELECT 1 FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = ? AND index_name = ? LIMIT 1',
            [$table, $indexName]
        ) !== null;
    }
};

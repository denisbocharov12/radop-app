<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ТЗ 68: популярные запросы в поиске.
 *
 * Копим то, что люди действительно ищут: на каждый запрос одна строка со
 * счётчиком. Витрине нужен короткий список лучших, поэтому важен индекс по
 * языку и числу обращений; закреплённые и скрытые записи ведёт администратор.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_popular_criteries', function (Blueprint $table) {
            $table->id();
            $table->string('query', 190);
            $table->string('locale', 8)->index();
            $table->unsignedInteger('hits')->default(0);
            $table->unsignedInteger('results')->default(0);
            // Закреплённый запрос стоит выше счётчика, скрытый не показываем.
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->timestamp('last_searched_at')->nullable();
            $table->timestamps();

            $table->unique(['query', 'locale']);
            $table->index(['locale', 'is_hidden', 'hits']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_popular_criteries');
    }
};

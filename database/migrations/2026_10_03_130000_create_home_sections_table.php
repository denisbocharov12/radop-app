<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Секции главной страницы.
 *
 * Порядок блоков был зашит в шаблоне: чтобы поменять местами новинки и хиты
 * или убрать слайдер брендов, нужен был выкат. Теперь это строки таблицы —
 * с порядком, видимостью и настройками по типу секции.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('type', 40);
            // Заголовок и подпись переводимые — JSON, как у пунктов меню.
            $table->json('title')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('link_title')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('order')->default(0);
            // Настройки, своё у каждого типа: источник товаров, цвет маски и т. п.
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};

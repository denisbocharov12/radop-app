<?php

declare(strict_types=1);

use App\Models\HomeSection;
use Illuminate\Database\Migrations\Migration;

/**
 * Сезонный блок получает новое название, а главная — порядок, который просил
 * клиент: баннер, быстрые категории, новинки, сезонное предложение, топ
 * продаж, товары со скидкой, бренды.
 *
 * Название, состав товаров и видимость по-прежнему правятся в админке —
 * миграция только задаёт начальное состояние.
 */
return new class extends Migration
{
    private const TITLE = ['ro' => 'Oferta sezonului', 'ru' => 'Сезонное предложение'];

    public function up(): void
    {
        $seasonal = HomeSection::query()->where('type', HomeSection::TYPE_SEASONAL)->first();

        if ($seasonal !== null) {
            $seasonal->update(['title' => self::TITLE]);
        }

        $this->reorder([
            [HomeSection::TYPE_BANNERS, null, 10],
            [HomeSection::TYPE_TOP_CATEGORIES, null, 20],
            [HomeSection::TYPE_PRODUCT_RAIL, 'new', 30],
            [HomeSection::TYPE_SEASONAL, null, 40],
            [HomeSection::TYPE_PRODUCT_RAIL, 'popular', 50],
            [HomeSection::TYPE_PRODUCT_RAIL, 'sale', 60],
            [HomeSection::TYPE_BRANDS, null, 70],
        ]);
    }

    public function down(): void
    {
        $seasonal = HomeSection::query()->where('type', HomeSection::TYPE_SEASONAL)->first();

        if ($seasonal !== null) {
            $seasonal->update(['title' => ['ro' => 'Noutăți de sezon', 'ru' => 'Сезонные новинки']]);
        }

        $this->reorder([
            [HomeSection::TYPE_BANNERS, null, 10],
            [HomeSection::TYPE_TOP_CATEGORIES, null, 15],
            [HomeSection::TYPE_PRODUCT_RAIL, 'new', 20],
            [HomeSection::TYPE_PRODUCT_RAIL, 'popular', 30],
            [HomeSection::TYPE_SEASONAL, null, 40],
            [HomeSection::TYPE_PRODUCT_RAIL, 'sale', 50],
            [HomeSection::TYPE_BRANDS, null, 60],
        ]);
    }

    /**
     * Ленты различаем по источнику товаров: тип у них один на троих.
     *
     * @param  array<int, array{0: string, 1: string|null, 2: int}>  $rows
     */
    private function reorder(array $rows): void
    {
        foreach ($rows as [$type, $source, $order]) {
            HomeSection::query()
                ->where('type', $type)
                ->get()
                ->filter(static fn (HomeSection $section) => $source === null || $section->setting('source') === $source)
                ->each(static fn (HomeSection $section) => $section->update(['order' => $order]));
        }
    }
};

<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\HomeSection;
use Illuminate\Database\Migrations\Migration;

/**
 * Полоса меню под шапкой переезжает на главную отдельной секцией
 * «Топ-категории»: те же разделы и тем же порядком, что показывало меню.
 *
 * Меню шапки в админке остаётся: витрина его больше не выводит, но настройки
 * никуда не делись и состав блока теперь правится в секциях главной.
 */
return new class extends Migration
{
    /** Разделы из меню шапки на момент переноса. */
    private const CATEGORY_CODES = ['1112', '1110', '10004', '2', '71', '414', '148'];

    public function up(): void
    {
        if (HomeSection::query()->where('type', HomeSection::TYPE_TOP_CATEGORIES)->exists()) {
            return;
        }

        HomeSection::query()->create([
            'type' => HomeSection::TYPE_TOP_CATEGORIES,
            'is_active' => true,
            // Между баннером (10) и первой лентой товаров (20).
            'order' => 15,
            'settings' => [
                'anchor' => 'top-categories-home-anchor',
                'category_ids' => $this->codes(),
            ],
        ]);
    }

    public function down(): void
    {
        HomeSection::query()->where('type', HomeSection::TYPE_TOP_CATEGORIES)->delete();
    }

    /**
     * На чужой базе кодов из меню может не быть — тогда берём верхние разделы
     * каталога в их обычном порядке, как делала и сама полоса меню.
     *
     * @return array<int, string>
     */
    private function codes(): array
    {
        $existing = Category::query()
            ->whereIn('onec_id', self::CATEGORY_CODES)
            ->pluck('onec_id')
            ->map(static fn ($code) => (string) $code)
            ->all();

        $codes = array_values(array_filter(
            self::CATEGORY_CODES,
            static fn (string $code) => in_array($code, $existing, true)
        ));

        if ($codes !== []) {
            return $codes;
        }

        return Category::query()
            ->where('status', true)
            ->whereNull('parent_id')
            ->whereNotNull('onec_id')
            ->orderBy('catalog_order')
            ->take(7)
            ->pluck('onec_id')
            ->map(static fn ($code) => (string) $code)
            ->all();
    }
};

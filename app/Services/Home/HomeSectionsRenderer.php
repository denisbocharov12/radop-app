<?php

declare(strict_types=1);

namespace App\Services\Home;

use App\Enums\ProductConditions;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\ProductProfile;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Собирает главную страницу из секций: порядок и состав берутся из таблицы,
 * а не из шаблона.
 *
 * Каждая секция приходит во вьюху уже с готовыми данными — товарами, фоном,
 * заголовком на текущем языке, — чтобы в шаблоне остался только вывод.
 */
final class HomeSectionsRenderer
{
    /** Сколько товаров показываем в ленте, если в настройках не задано иное. */
    private const DEFAULT_LIMIT = 12;

    public function __construct(
        private readonly ProductRepository $products,
        private readonly ProductConditions $conditions,
    ) {
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function sections(): Collection
    {
        return HomeSection::query()
            ->visible()
            ->with('media')
            ->get()
            ->map(fn (HomeSection $section) => $this->prepare($section))
            ->filter(static fn (array $section) => $section['ready'])
            ->values();
    }

    /**
     * @return array<string, mixed>
     */
    private function prepare(HomeSection $section): array
    {
        $locale = app()->getLocale();

        $data = [
            'id' => $section->id,
            'type' => $section->type,
            'title' => $this->translated($section, 'title', $locale),
            'subtitle' => $this->translated($section, 'subtitle', $locale),
            'linkTitle' => $this->translated($section, 'link_title', $locale),
            'link' => $section->link,
            'anchor' => (string) $section->setting('anchor', 'home-section-' . $section->id),
            'settings' => (array) ($section->settings ?? []),
            'products' => collect(),
            'background' => null,
            'ready' => true,
        ];

        if (in_array($section->type, [HomeSection::TYPE_PRODUCT_RAIL, HomeSection::TYPE_SEASONAL], true)) {
            $data['products'] = $this->productsFor($section);
            // Пустую ленту не показываем: заголовок без товаров выглядит сбоем.
            $data['ready'] = $data['products']->isNotEmpty();
        }

        if ($section->type === HomeSection::TYPE_SEASONAL) {
            $data['background'] = $section->backgroundUrl();
            $data['overlayColor'] = (string) $section->setting('overlay_color', '#0b2a4a');
            $data['overlayOpacity'] = max(0, min(100, (int) $section->setting('overlay_opacity', 55)));
            $data['headingStyle'] = $section->setting('heading_style') === 'dark' ? 'dark' : 'light';
        }

        return $data;
    }

    /**
     * Пустой перевод заменяем языком по умолчанию: заголовок «на половине
     * языков» хуже, чем один и тот же текст.
     */
    private function translated(HomeSection $section, string $field, string $locale): ?string
    {
        $value = $section->getTranslation($field, $locale, false);

        if (is_string($value) && trim($value) !== '') {
            return $value;
        }

        $fallback = $section->getTranslation($field, (string) config('app.fallback_locale'), false);

        return is_string($fallback) && trim($fallback) !== '' ? $fallback : null;
    }

    /**
     * @return Collection<int, Product>
     */
    public function productsFor(HomeSection $section): Collection
    {
        $source = (string) $section->setting('source', 'new');
        $limit = (int) $section->setting('limit', self::DEFAULT_LIMIT);

        return match ($source) {
            'new' => $this->products->getNewProductsForHomePage(),
            'popular' => $this->products->getPopularProductsForHomePage(),
            'sale' => $this->products->getDiscountProductsForHomePage(),
            'manual' => $this->manual((array) $section->setting('product_ids', []), $limit),
            default => $this->byCondition($source, $limit),
        };
    }

    /**
     * Товары по условию из номенклатуры: winter, hot, featured и прочие — их
     * проставляют в карточке товара в админке.
     *
     * @return Collection<int, Product>
     */
    private function byCondition(string $condition, int $limit): Collection
    {
        $known = array_values((array) $this->conditions->getAll());

        if (! in_array($condition, $known, true) && ! in_array($condition, array_keys((array) $this->conditions->getAll()), true)) {
            return collect();
        }

        $cacheKey = 'home_section_condition_' . $condition . '_' . $limit . '_' . app()->getLocale();

        return Cache::remember($cacheKey, 7200, function () use ($condition, $limit) {
            $codes = ProductProfile::where('condition', $condition)->pluck('product_id');

            if ($codes->isEmpty()) {
                return collect();
            }

            return $this->baseQuery()
                ->whereIn('onec_id', $codes)
                ->take($limit)
                ->get();
        });
    }

    /**
     * @param  array<int, string|int>  $codes
     * @return Collection<int, Product>
     */
    private function manual(array $codes, int $limit): Collection
    {
        $codes = array_values(array_filter(array_map('strval', $codes)));

        if ($codes === []) {
            return collect();
        }

        $products = $this->baseQuery()->whereIn('onec_id', $codes)->take($limit)->get();

        // Сохраняем порядок, в котором товары выбрали в админке.
        return $products->sortBy(static fn (Product $product) => array_search((string) $product->onec_id, $codes, true))->values();
    }

    private function baseQuery()
    {
        return Product::query()
            ->where('status', true)
            ->where('site_status', true)
            ->where('stock', '!=', 0)
            ->whereNotNull('price_koef')
            ->with(['brand:id,onec_id,title', 'media', 'packages', 'values', 'data', 'categories:onec_id,name']);
    }
}

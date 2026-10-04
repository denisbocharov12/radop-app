<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

/**
 * Пути всех страниц витрины — по одному на строку.
 *
 * Нужен статическому экспорту для GitHub Pages: обходчику неоткуда взять
 * список адресов, а карта сайта привязана к домену и перечисляет все 14 тысяч
 * товаров — для витрины-демонстрации это лишнее.
 *
 * Объём ограничивается ключами: витрина на Pages показывает раздел каталога
 * целиком, а товары — выборочно, иначе выгрузка не влезет в ограничения Pages.
 */
final class ListPublicUrlsCommand extends Command
{
    protected $signature = 'site:urls
        {--all : Выгрузить всё, что есть в базе: каждый раздел, товар и бренд}
        {--products-per-category=4 : Сколько товаров брать из каждого раздела}
        {--max-products=600 : Предел по товарам на всю выгрузку}
        {--max-categories=120 : Предел по разделам}
        {--max-brands=24 : Предел по брендам}
        {--locales= : Языки через запятую; по умолчанию все настроенные}';

    protected $description = 'Вывести пути страниц витрины для статического экспорта';

    public function handle(): int
    {
        foreach ($this->paths() as $path) {
            $this->line($path);
        }

        return self::SUCCESS;
    }

    /**
     * @return array<int, string>
     */
    private function paths(): array
    {
        $paths = $this->staticPaths();

        $categories = $this->categories();

        foreach ($categories as $category) {
            $paths[] = '/category/' . $category->onec_id;
        }

        foreach ($this->brands() as $brand) {
            $paths[] = '/brand/' . $brand->onec_id;
        }

        foreach ($this->products($categories) as $slug) {
            $paths[] = '/product/' . $slug;
        }

        return $this->withLocales(array_values(array_unique($paths)));
    }

    /**
     * @return array<int, string>
     */
    private function staticPaths(): array
    {
        return [
            '',
            '/shop',
            '/shop/catalog',
            '/shop/new',
            '/shop/popular',
            '/shop/sale',
            '/brand/catalog',
            '/about-us',
            '/contacts',
            '/delivery',
            '/how-to-order',
            '/terms-and-conditions',
            '/privacy-policy',
            '/cookie',
            '/return-rules',
            // Служебные страницы тоже выгружаем: на них ведут шапка и карточки,
            // а без файла статика отдаёт 404.
            '/cart',
            '/wishlist',
            '/login',
            '/registration',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection<int, Category>
     */
    private function categories()
    {
        $query = Category::query()
            ->where('status', true)
            ->whereNotNull('onec_id')
            ->withCount('products');

        if ($this->option('all')) {
            // Пустые разделы тоже нужны: на них ведут меню и хлебные крошки.
            return $query->orderBy('onec_id')->get();
        }

        return $query
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->take((int) $this->option('max-categories'))
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection<int, Brand>
     */
    private function brands()
    {
        $query = Brand::query()->whereNotNull('onec_id');

        return $this->option('all')
            ? $query->orderBy('onec_id')->get()
            : $query->take((int) $this->option('max-brands'))->get();
    }

    /**
     * Товары берём по нескольку из каждого раздела: так в выгрузке есть и
     * карточки, и ссылки с разделов никуда не ведут в пустоту.
     *
     * @param  \Illuminate\Support\Collection<int, Category>  $categories
     * @return array<int, string>
     */
    private function products($categories): array
    {
        if ($this->option('all')) {
            return Product::query()
                ->where('status', true)
                ->where('site_status', true)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->orderBy('id')
                ->pluck('slug')
                ->all();
        }

        $perCategory = max(1, (int) $this->option('products-per-category'));
        $max = max(1, (int) $this->option('max-products'));

        $slugs = [];

        foreach ($categories as $category) {
            $chunk = $category->products()
                ->where('products.status', true)
                ->where('products.site_status', true)
                ->where('products.stock', '!=', 0)
                ->whereNotNull('products.slug')
                ->orderBy('products.id')
                ->take($perCategory)
                ->pluck('products.slug')
                ->all();

            foreach ($chunk as $slug) {
                $slugs[$slug] = true;

                if (count($slugs) >= $max) {
                    return array_keys($slugs);
                }
            }
        }

        return array_keys($slugs);
    }

    /**
     * Каждый путь отдаём на всех языках. Язык по умолчанию живёт без префикса.
     *
     * @param  array<int, string>  $paths
     * @return array<int, string>
     */
    private function withLocales(array $paths): array
    {
        $locales = $this->option('locales')
            ? array_filter(array_map('trim', explode(',', (string) $this->option('locales'))))
            : array_keys((array) config('laravellocalization.supportedLocales', []));

        $default = (string) config('app.fallback_locale', 'ro');
        $result = [];

        foreach ($locales as $locale) {
            $prefix = $locale === $default ? '' : '/' . $locale;

            foreach ($paths as $path) {
                $result[] = $prefix . $path === '' ? '/' : $prefix . ($path === '' ? '/' : $path);
            }
        }

        return array_values(array_unique($result));
    }
}

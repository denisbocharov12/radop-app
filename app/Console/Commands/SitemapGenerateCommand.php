<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\Sitemap\LocalizedThemeUrlGenerator;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

/**
 * Generate sitemap_index.xml plus per-section sub-sitemaps (pages, categories,
 * brands, products). Every URL carries `<xhtml:link rel="alternate"
 * hreflang="ro-MD|ru-MD">` annotations so each locale variant is discovered
 * in a single crawl.
 */
final class SitemapGenerateCommand extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap_index.xml + per-section sub-sitemaps with hreflang alternates.';

    private const HREFLANG_MAP = [
        'ro' => 'ro-MD',
        'ru' => 'ru-MD',
    ];

    private LocalizedThemeUrlGenerator $generator;
    /** @var list<string> */
    private array $locales = [];

    public function handle(LaravelLocalization $laravelLocalization): int
    {
        $this->generator = new LocalizedThemeUrlGenerator($laravelLocalization);
        $this->locales   = $this->generator->supportedLocaleKeys();

        $this->writePagesSitemap();
        $this->writeCategoriesSitemap();
        $this->writeBrandsSitemap();
        $this->writeProductsSitemap();
        $this->writeIndex();

        $this->info('Sitemap index written to public/sitemap.xml');
        return self::SUCCESS;
    }

    private function writePagesSitemap(): void
    {
        $sitemap = Sitemap::create();
        foreach ($this->locales as $locale) {
            foreach ($this->staticPaths() as $item) {
                $sitemap->add(
                    $this->urlWithAlternates(
                        $locale,
                        $item['path'],
                        null,
                        (float) $item['priority'],
                        (string) $item['frequency'],
                    )
                );
            }
        }
        $sitemap->writeToFile(public_path('sitemap-pages.xml'));
    }

    private function writeCategoriesSitemap(): void
    {
        $sitemap = Sitemap::create();
        Category::query()
            ->where('status', true)
            ->whereNotNull('onec_id')
            ->orderBy('onec_id')
            ->chunk(400, function ($categories) use ($sitemap): void {
                foreach ($categories as $category) {
                    assert($category instanceof Category);
                    $path = 'category/' . $category->onec_id;
                    $lastmod = Carbon::make($category->updated_at) ?? Carbon::now();
                    foreach ($this->locales as $locale) {
                        $sitemap->add(
                            $this->urlWithAlternates($locale, $path, $lastmod, 0.75, Url::CHANGE_FREQUENCY_WEEKLY)
                        );
                    }
                }
            });
        $sitemap->writeToFile(public_path('sitemap-categories.xml'));
    }

    private function writeBrandsSitemap(): void
    {
        $sitemap = Sitemap::create();
        Brand::query()
            ->where('status', true)
            ->whereNotNull('onec_id')
            ->orderBy('onec_id')
            ->chunk(400, function ($brands) use ($sitemap): void {
                foreach ($brands as $brand) {
                    assert($brand instanceof Brand);
                    $path = 'brand/' . $brand->onec_id;
                    $lastmod = Carbon::make($brand->updated_at) ?? Carbon::now();
                    foreach ($this->locales as $locale) {
                        $sitemap->add(
                            $this->urlWithAlternates($locale, $path, $lastmod, 0.75, Url::CHANGE_FREQUENCY_WEEKLY)
                        );
                    }
                }
            });
        $sitemap->writeToFile(public_path('sitemap-brands.xml'));
    }

    private function writeProductsSitemap(): void
    {
        $sitemap = Sitemap::create();
        Product::query()
            ->where('site_status', true)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->orderBy('id')
            ->chunk(400, function ($products) use ($sitemap): void {
                foreach ($products as $product) {
                    assert($product instanceof Product);
                    $path = 'product/' . $product->slug;
                    $lastmod = Carbon::make($product->updated_at) ?? Carbon::now();
                    foreach ($this->locales as $locale) {
                        $sitemap->add(
                            $this->urlWithAlternates($locale, $path, $lastmod, 0.85, Url::CHANGE_FREQUENCY_WEEKLY)
                        );
                    }
                }
            });
        $sitemap->writeToFile(public_path('sitemap-products.xml'));
    }

    private function writeIndex(): void
    {
        SitemapIndex::create()
            ->add('/sitemap-pages.xml')
            ->add('/sitemap-categories.xml')
            ->add('/sitemap-brands.xml')
            ->add('/sitemap-products.xml')
            ->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Build a Url tag for the given (locale, path) and attach <xhtml:link>
     * alternates for every OTHER supported locale so Google sees both ro-MD
     * and ru-MD versions on the same sitemap entry.
     */
    private function urlWithAlternates(
        string $locale,
        string $path,
        ?Carbon $lastmod,
        float $priority,
        string $frequency
    ): Url {
        $url = Url::create($this->generator->absolute($locale, $path))
            ->setChangeFrequency($frequency)
            ->setPriority($priority);

        if ($lastmod !== null) {
            $url->setLastModificationDate($lastmod);
        } else {
            // No trustworthy modification date (static pages): omit <lastmod>
            // instead of reporting the generation time as a change.
            unset($url->lastModificationDate);
        }

        // List every language version, the URL itself included, plus x-default.
        foreach ($this->locales as $alt) {
            $hreflang = self::HREFLANG_MAP[$alt] ?? $alt;
            $url->addAlternate($this->generator->absolute($alt, $path), $hreflang);
        }
        $url->addAlternate($this->generator->absolute((string) config('app.fallback_locale'), $path), 'x-default');

        return $url;
    }

    /**
     * Sitemap-eligible static pages. Login / registration / search / cart are
     * intentionally excluded — they are in robots.txt Disallow and should
     * never be indexed.
     *
     * @return list<array{path: string, priority: float, frequency: string}>
     */
    private function staticPaths(): array
    {
        return [
            ['path' => '',                       'priority' => 1.0,  'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'about-us',               'priority' => 0.6,  'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'contacts',               'priority' => 0.65, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'delivery',               'priority' => 0.6,  'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'privacy-policy',         'priority' => 0.4,  'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            ['path' => 'terms-and-conditions',   'priority' => 0.4,  'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            ['path' => 'cookie',                 'priority' => 0.4,  'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            ['path' => 'return-rules',           'priority' => 0.5,  'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'how-to-order',           'priority' => 0.55, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'shop',                   'priority' => 0.9,  'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'shop/new',               'priority' => 0.8,  'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'shop/popular',           'priority' => 0.8,  'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'shop/sale',              'priority' => 0.8,  'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'shop/catalog',           'priority' => 0.85, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'brand/catalog',          'priority' => 0.85, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
        ];
    }
}

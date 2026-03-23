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
use Spatie\Sitemap\Tags\Url;

final class SitemapGenerateCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap.';

    public function handle(LaravelLocalization $laravelLocalization): int
    {
        $generator = new LocalizedThemeUrlGenerator($laravelLocalization);
        $locales = $generator->supportedLocaleKeys();
        $sitemap = Sitemap::create();

        foreach ($locales as $locale) {
            foreach ($this->staticPaths() as $item) {
                $path = $item['path'];
                $priority = $item['priority'];
                $frequency = $item['frequency'];
                $url = $generator->absolute($locale, $path);
                $tag = Url::create($url)
                    ->setChangeFrequency($frequency)
                    ->setPriority($priority);
                $sitemap->add($tag);
            }
        }

        foreach ($locales as $locale) {
            Product::query()
                ->where('site_status', true)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->orderBy('id')
                ->chunk(400, function ($products) use ($sitemap, $generator, $locale): void {
                    foreach ($products as $product) {
                        assert($product instanceof Product);
                        $path = 'product/' . $product->slug;
                        $url = $generator->absolute($locale, $path);
                        $updated = Carbon::make($product->updated_at) ?? Carbon::now();
                        $sitemap->add(
                            Url::create($url)
                                ->setLastModificationDate($updated)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                ->setPriority(0.85)
                        );
                    }
                });
        }

        foreach ($locales as $locale) {
            Category::query()
                ->where('status', true)
                ->whereNotNull('onec_id')
                ->orderBy('onec_id')
                ->chunk(400, function ($categories) use ($sitemap, $generator, $locale): void {
                    foreach ($categories as $category) {
                        assert($category instanceof Category);
                        $path = 'category/' . $category->onec_id;
                        $url = $generator->absolute($locale, $path);
                        $updated = Carbon::make($category->updated_at) ?? Carbon::now();
                        $sitemap->add(
                            Url::create($url)
                                ->setLastModificationDate($updated)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                ->setPriority(0.75)
                        );
                    }
                });
        }

        foreach ($locales as $locale) {
            Brand::query()
                ->where('status', true)
                ->whereNotNull('onec_id')
                ->orderBy('onec_id')
                ->chunk(400, function ($brands) use ($sitemap, $generator, $locale): void {
                    foreach ($brands as $brand) {
                        assert($brand instanceof Brand);
                        $path = 'brand/' . $brand->onec_id;
                        $url = $generator->absolute($locale, $path);
                        $updated = Carbon::make($brand->updated_at) ?? Carbon::now();
                        $sitemap->add(
                            Url::create($url)
                                ->setLastModificationDate($updated)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                ->setPriority(0.75)
                        );
                    }
                });
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap written to public/sitemap.xml');

        return self::SUCCESS;
    }

    /**
     * @return list<array{path: string, priority: float, frequency: string}>
     */
    private function staticPaths(): array
    {
        return [
            ['path' => '', 'priority' => 1.0, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'about-us', 'priority' => 0.6, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'contacts', 'priority' => 0.65, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'delivery', 'priority' => 0.6, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'privacy-policy', 'priority' => 0.4, 'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            ['path' => 'terms-and-conditions', 'priority' => 0.4, 'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            ['path' => 'cookie', 'priority' => 0.4, 'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            ['path' => 'return-rules', 'priority' => 0.5, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'how-to-order', 'priority' => 0.55, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'shop', 'priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'shop/new', 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'shop/popular', 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'shop/sale', 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'shop/catalog', 'priority' => 0.85, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['path' => 'search', 'priority' => 0.5, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['path' => 'brand/catalog', 'priority' => 0.85, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['path' => 'login', 'priority' => 0.35, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['path' => 'registration', 'priority' => 0.35, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
        ];
    }
}

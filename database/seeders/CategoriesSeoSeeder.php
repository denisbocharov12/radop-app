<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\SeoMeta;
use Illuminate\Database\Seeder;

/**
 * (Re)writes SEO metadata for a curated set of categories and their first ~12 products.
 *
 * Data source: database/seeders/data/categories_seo.json
 *   { "categories": { "<onec_id>": {name, ru{...}, ro{...}} },
 *     "products":   { "<onec_id>": {type, category_id, source_title, ru{...}, ro{...}} } }
 *
 * Keys follow the site convention (ProductController / CategoryController):
 *   category → page_type 'category', page_id = (string) Category.onec_id (== id in /category/{id})
 *   product  → page_type 'product',  page_id = (string) Product.onec_id  (== product code)
 * Existing rows are OVERWRITTEN (the brief asks to replace category/product SEO even if present).
 * og_image = first image in the model's media collection (products: 'products'; category: default).
 *
 * NOT registered in DatabaseSeeder — run manually:
 *   php artisan db:seed --class=CategoriesSeoSeeder
 */
final class CategoriesSeoSeeder extends Seeder
{
    private const LOCALES = ['ru', 'ro'];
    private const PRODUCT_MEDIA_COLLECTION = 'products';

    public function run(): void
    {
        $path = database_path('seeders/data/categories_seo.json');

        if (!is_file($path)) {
            $this->command?->error("SEO data file not found: {$path}");
            return;
        }

        $data = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);

        $catRows = $this->seedCategories($data['categories'] ?? []);
        $prodRows = $this->seedProducts($data['products'] ?? []);

        $this->command?->info(sprintf(
            'Categories SEO seeded: %d categories → %d rows, %d products → %d rows.',
            count($data['categories'] ?? []),
            $catRows,
            count($data['products'] ?? []),
            $prodRows
        ));
    }

    /** @param array<string,array> $categories */
    private function seedCategories(array $categories): int
    {
        $rows = 0;
        foreach ($categories as $onecId => $entry) {
            $onecId = (string) $onecId;

            $category = Category::where('onec_id', $onecId)->first();
            $ogImage = $category?->getFirstMediaUrl() ?: null; // default collection

            $rows += $this->writeLocales('category', $onecId, $entry, $ogImage);
        }
        return $rows;
    }

    /** @param array<string,array> $products */
    private function seedProducts(array $products): int
    {
        $rows = 0;
        foreach ($products as $onecId => $entry) {
            $onecId = (string) $onecId;

            $product = Product::where('onec_id', $onecId)->first();
            $ogImage = $product?->getFirstMediaUrl(self::PRODUCT_MEDIA_COLLECTION) ?: null;

            $rows += $this->writeLocales('product', $onecId, $entry, $ogImage);
        }
        return $rows;
    }

    /**
     * Upsert one SeoMeta row per locale. Existing rows are overwritten.
     */
    private function writeLocales(string $pageType, string $pageId, array $entry, ?string $ogImage): int
    {
        $rows = 0;
        foreach (self::LOCALES as $locale) {
            $loc = $entry[$locale] ?? null;
            if (!is_array($loc) || empty($loc['title'])) {
                continue;
            }

            $values = [
                'title'        => $loc['title'],
                'description'  => $loc['description'] ?? null,
                'keywords'     => $loc['keywords'] ?? null,
                'ai_generated' => false,
            ];
            if ($ogImage !== null) {
                $values['og_image'] = $ogImage;
            }

            SeoMeta::updateOrCreate(
                ['page_type' => $pageType, 'page_id' => $pageId, 'locale' => $locale],
                $values
            );
            $rows++;
        }
        return $rows;
    }
}

<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SeoMeta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fills SEO metadata (title / description / keywords / og_image) for the
 * "popular" ("HIT") products shown on /shop/popular.
 *
 * Data source: database/seeders/data/popular_products_seo.json — a curated,
 * keyword-rich map keyed by product onec_id, with ru + ro copy.
 *
 * SEO rows follow the site's own convention (see ProductController / GenerateSeoMetaForItemJob):
 *   page_type = 'product', page_id = (string) Product.onec_id, locale = ru|ro.
 * og_image is taken from the FIRST image in the product's 'products' media collection.
 *
 * NOT registered in DatabaseSeeder — run manually:
 *   php artisan db:seed --class=PopularProductsSeoSeeder
 */
final class PopularProductsSeoSeeder extends Seeder
{
    private const PAGE_TYPE      = 'product';
    private const MEDIA_COLLECTION = 'products';
    private const LOCALES        = ['ru', 'ro'];

    public function run(): void
    {
        $path = database_path('seeders/data/popular_products_seo.json');

        if (!is_file($path)) {
            $this->command?->error("SEO data file not found: {$path}");
            return;
        }

        /** @var array<string,array> $data */
        $data = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);

        $created = 0;
        $updated = 0;
        $withImage = 0;
        $missingProduct = [];

        foreach ($data as $onecId => $entry) {
            $onecId = (string) $onecId; // preserve leading-zero ids like "01010112"

            // Resolve the first media image once per product (same URL for both locales).
            $product = Product::where('onec_id', $onecId)->first();
            if ($product === null) {
                $missingProduct[] = $onecId;
            }
            $ogImage = $product?->getFirstMediaUrl(self::MEDIA_COLLECTION) ?: null;
            if ($ogImage !== null) {
                $withImage++;
            }

            foreach (self::LOCALES as $locale) {
                $loc = $entry[$locale] ?? null;
                if (!is_array($loc) || empty($loc['title'])) {
                    continue;
                }

                $attributes = [
                    'page_type' => self::PAGE_TYPE,
                    'page_id'   => $onecId,
                    'locale'    => $locale,
                ];

                $values = [
                    'title'        => $loc['title'],
                    'description'  => $loc['description'] ?? null,
                    'keywords'     => $loc['keywords'] ?? null,
                    'ai_generated' => false,
                ];

                // Only set og_image when we actually resolved one, so we never
                // wipe an existing image on products whose media isn't loaded yet.
                if ($ogImage !== null) {
                    $values['og_image'] = $ogImage;
                }

                $seo = SeoMeta::firstOrNew($attributes);
                $existed = $seo->exists;
                $seo->fill($values)->save();

                $existed ? $updated++ : $created++;
            }
        }

        $this->command?->info(sprintf(
            'Popular SEO seeded: %d products, %d created, %d updated, %d with og_image.',
            count($data),
            $created,
            $updated,
            $withImage
        ));

        if ($missingProduct !== []) {
            $this->command?->warn(sprintf(
                '%d onec_id(s) had no matching product on this DB (SEO row still written): %s',
                count($missingProduct),
                implode(', ', $missingProduct)
            ));
        }
    }
}

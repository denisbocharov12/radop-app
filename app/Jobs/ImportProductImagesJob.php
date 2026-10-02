<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\Product\ProductImagesManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class ImportProductImagesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param array $productIds
     * @param bool $force
     */
    public function __construct(
        private readonly array $productIds,
        private readonly bool $force = false
    ) {}

    /**
     * @return void
     */
    public function handle(): void
    {
        $products = Product::whereIn('id', $this->productIds)->get();

        $skipped = 0;
        $updated = 0;

        foreach ($products as $product) {
            try {
                /*
                 * Полная перезаливка меняет id медиафайлов, а значит и адреса
                 * картинок: поисковик теряет уже проиндексированные снимки.
                 * Поэтому товары, где количество исходников совпадает с
                 * количеством загруженных, пропускаем, а остальным доливаем
                 * недостающее — с очисткой только по явному требованию.
                 */
                if (ProductImagesManager::imagesAreUpToDate($product)) {
                    $skipped++;

                    continue;
                }

                if ($this->force && ! ProductImagesManager::hasProductImages($product)) {
                    ProductImagesManager::importProductImagesSafe($product);
                } else {
                    ProductImagesManager::updateProductImages($product);
                }

                $updated++;
            } catch (\Exception $e) {
                Log::error("Ошибка при импорте изображений для товара {$product->onec_id}: {$e->getMessage()}", [
                    'product_id' => $product->id,
                    'onec_id' => $product->onec_id,
                    'exception' => $e
                ]);
            }
        }

        Log::info('Импорт изображений: обновлено ' . $updated . ', пропущено ' . $skipped);
    }
}

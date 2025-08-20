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

        foreach ($products as $product) {
            try {
                if ($this->force) {
                    ProductImagesManager::clearProductImages($product);
                }

                if (!ProductImagesManager::hasProductImages($product)) {
                    ProductImagesManager::importProductImagesSafe($product);
                } else {
                    ProductImagesManager::updateProductImages($product);
                }
            } catch (\Exception $e) {
                Log::error("Ошибка при импорте изображений для товара {$product->onec_id}: {$e->getMessage()}", [
                    'product_id' => $product->id,
                    'onec_id' => $product->onec_id,
                    'exception' => $e
                ]);
            }
        }
    }
}

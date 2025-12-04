<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Product;
use App\Services\Product\ProductImagesManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class RegenerateProductImagesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param int $productId
     */
    public function __construct(
        private readonly int $productId
    ) {}

    /**
     * @return void
     */
    public function handle(): void
    {
        $product = Product::find($this->productId);

        if (!$product) {
            Log::warning("Товар с ID {$this->productId} не найден для регенерации фотографий");
            return;
        }

        try {
            ProductImagesManager::clearProductImages($product);

            ProductImagesManager::importProductImagesSafe($product);

            Log::info("Фотографии товара {$product->onec_id} успешно регенерированы", [
                'product_id' => $product->id,
                'onec_id' => $product->onec_id,
            ]);
        } catch (\Exception $e) {
            Log::error("Ошибка при регенерации изображений для товара {$product->onec_id}: {$e->getMessage()}", [
                'product_id' => $product->id,
                'onec_id' => $product->onec_id,
                'exception' => $e
            ]);

            throw $e;
        }
    }
}


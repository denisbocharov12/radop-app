<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class ProductCategorySyncFromNomenclatureJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param array<int, object> $importData
     * @param array<string, mixed> $headers
     */
    public function __construct(
        public $importData,
        public $headers
    ) {
    }

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        foreach ($this->importData as $product) {
            if (!isset($product->category_id) || !is_array($product->category_id)) {
                continue;
            }

            foreach ($product->category_id as $item) {
                $category = Category::where('onec_id', $item)->first();
                if ($category === null) {
                    continue;
                }

                $ancestorsAndSelf = $category->ancestorsAndSelf->pluck('onec_id')->toArray();
                foreach ($ancestorsAndSelf as $categoryId) {
                    ProductCategory::firstOrCreate([
                        'category_id' => $categoryId,
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }
}

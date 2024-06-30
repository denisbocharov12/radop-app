<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

final class ProductImportJsonJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $importData;
    public  $headers;

    public function __construct(
        $importData,
        $headers
    )
    {
        $this->importData = $importData;
        $this->headers = $headers;
    }

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        foreach ($this->importData as $product) {

            $status = $product['status'] ? true : false;

            $data = [
                'title' => [
                    'ro' => $product['name_ro_full'],
                    'ru' => $product['name_ru_full'],
                ],
                'slug' => Str::slug($product['name_ru_full']) . '-' . $product['id'],
                'price' => $product['price'],
                'status' => $status,
                'stock' => $product['stock'],
                'brand_id' => $product['brand_id'],
            ];

            Product::updateOrCreate(['onec_id' => $product['id']], $data);

            ProductProfile::updateOrCreate(['product_id' => $product['id']], [
                'sku' => $product['id']
            ]);

            foreach ($product['category_id'] as $item) {
                ProductCategory::create([
                    'category_id' => $item,
                    'product_id' => $product['id'],
                ]);
            }
        }
    }
}

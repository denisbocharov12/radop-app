<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use App\Services\Product\ProductImagesManager;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

            $status = $product->status ? true : false;
            $characteristics = [];

            if (isset($product->character_id) && isset($product->selected_type)) {
                $characteristics = [
                    'character_id' => $product->character_id,
                    'selected_type' => $product->selected_type,
                ];
            }

            $shtrihCode = null;

            if (isset($product->shtrih_code)) {
                $shtrihCode = $product->shtrih_code;
            }

            // TODO: Add default value for admin
            $priceKoef = 1;

            if (isset($product->price_koef) && $product->price_koef > 0) {
                $priceKoef = $product->price_koef;
            }

            $data = [
                'title' => [
                    'ro' => isset($product->name_ro_full) ? $product->name_ro_full : '',
                    'ru' => isset($product->name_ru_full) ? $product->name_ru_full : '',
                ],
                'price' => $product->price,
                'status' => $status,
                'stock' => $product->stock,
                'brand_id' => $product->brand_id,
                'shtrih_code' => $shtrihCode,
                'characteristic' => json_encode($characteristics),
                'price_koef' => $priceKoef,
            ];

            $productModel = Product::updateOrCreate(['onec_id' => $product->id], $data);

            ProductProfile::updateOrCreate(['product_id' => $product->id], [
                'sku' => $product->id
            ]);

            if (isset($product->product_onec_ids)) {
                ProductProfile::updateOrCreate(['product_id' => $product->id], [
                    'upp_sale' => $product->product_onec_ids
                ]);
            }

            foreach ($product->category_id as $item) {

                if (Category::where('onec_id', $item)->first() !== null) {

                    $ancestorsAndSelf = Category::where('onec_id', $item)->first()->ancestorsAndSelf->pluck('onec_id')->toArray();

                    foreach ($ancestorsAndSelf as $categoryId)
                    {
                        ProductCategory::create([
                            'category_id' => $categoryId,
                            'product_id' => $product->id,
                        ]);
                    }
                }

            }
            ProductImagesManager::clearProductImages($productModel);

            ProductImagesManager::importProductImagesSafe($productModel);
//            foreach ($product->getMedia('products') as $mediaItem) {
//                $customFileRemover->removeAllFiles($mediaItem);
//            }
//
//            if (!ProductImagesManager::hasProductImages($productModel)) {
//                ProductImagesManager::importProductImagesSafe($productModel);
//            } else {
//                ProductImagesManager::updateProductImages($productModel);
//            }
        }
    }
}

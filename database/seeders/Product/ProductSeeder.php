<?php

namespace Database\Seeders\Product;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends seeder
{
    public function run(): void
    {
        $product =
            [
                'onec_id' => 'pro9991',
                'title' => 'Product 1',
                'stock' => '999',
                'unit' => '899',
                'brand_id' => 1,
                'price' => '899.99',
                'sale_price' => null,
                'status' => '1',
            ];

        Product::create($product);
    }
}

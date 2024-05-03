<?php

namespace App\Services\ONEC;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class ONECManager
{

    public function importCategories($json)
    {
        if (isset($json['Categories'])) {
            foreach ($json['Categories'] as $category) {
                if (!empty($category['id'])) {
                    $isParent = !empty($category['parent_id']) ? false : true;
                    $categoryId = !empty($category['parent_id']) ? $category['parent_id'] : null;

                    $data = [
                        'name' => $category['name_ro'],
                        'slug' => $category['id'],
                        'is_parent' => $isParent,
                        'parent_id' => $categoryId,
                    ];

                    Category::updateOrCreate(['onec_id' => $category['id']], $data);
                }
            }

            return true;
        }

        return false;
    }

    public function importNomenclature($json)
    {
        if (isset($json['Product'])) {
            try {
                DB::beginTransaction();

                Product::query()->truncate();
                ProductCategory::query()->truncate();
                ProductProfile::query()->truncate();

                foreach ($json['Product'] as $product) {
                    if (!empty($product['id'])) {
                        $status = $product['status'] ? true : false;

                        $data = [
                            'title' => $product['name_ru_full'],
                            'slug' => Str::slug($product['name_ru_full']) . '-' . $product['id'],
                            'price' => $product['price'],
                            'status' => $status,
                            'stock' => $product['stock'],
                            'brand_id' => $product['brand_id'],
                        ];

                        Product::updateOrCreate(['onec_id' => $product['id']], $data);

                        ProductProfile::updateOrCreate(['product_id' => $product['id']], []);

                        foreach ($product['category_id'] as $item) {
                            ProductCategory::create([
                                'category_id' => $item,
                                'product_id' => $product['id'],
                            ]);
                        }
                    }
                }

                return true;
            } catch (\Exception $e) {
                DB::rollBack();

                return false;
            }
        }

        return false;
    }

    public function importBrands($json)
    {
        if (isset($json['Brands'])) {
            foreach ($json['Brands'] as $brand) {
                if (!empty($brand['id'])) {
                    $data = [
                        'title' => $brand['name_ro'],
                        'slug' => Str::slug($brand['name_ro']) . '-' . $brand['id'],
                        'onec_id' => $brand['id'],
                    ];

                    Brand::updateOrCreate(['onec_id' => $brand['id']], $data);
                }
            }
            return true;
        }

        return false;
    }

    public function importAttributes($json)
    {
        if (isset($json['Characteristics'])) {
            foreach ($json['Characteristics'] as $attribute) {
                if (!empty($attribute['id'])) {
                    $data = [
                        'name' => $attribute['name_ro'],
                        'slug' => Str::slug($attribute['name_ro']),
                        'onec_id' => $attribute['id'],
                    ];

                    Attribute::updateOrCreate([
                        'onec_id' => $attribute['id']
                    ], $data);
                }
            }
            return true;
        }
        return false;
    }

    public function importAttributeValues($json)
    {
        if (isset($json['ProductCharacteristics'])) {
            DB::beginTransaction();

            try {
                AttributeValue::query()->truncate();
                ProductAttribute::query()->truncate();

                foreach ($json['ProductCharacteristics'] as $attributeValue) {
                    if (!empty($attributeValue['product_id'])) {
                        AttributeValue::query()->create([
                            'attribute_onec_id' => $attributeValue['characteristic_id'],
                            'product_onec_id' => $attributeValue['product_id'],
                            'value' => $attributeValue['name_ro'],
                        ]);

                        $attributeId = Attribute::query()
                            ->where('onec_id', $attributeValue['characteristic_id'])
                            ->first()->id;

                        ProductAttribute::query()->create([
                            'product_id' => $attributeValue['product_id'],
                            'attribute_id' => $attributeId,
                        ]);
                    }
                }

                return true;
            } catch (\Exception $e) {
                DB::rollBack();

                return false;
            }
        }

        return false;
    }

    public function importProductsImages($json)
    {
        if (isset($json['Photos'])) {
            ProductImage::query()->truncate();

            foreach ($json['Photos'] as $photo) {
                ProductImage::create([
                    'image_path' => '/images/' . $photo['filename'],
                    'product_id' => $photo['id'],
                    'title' => 'product-' . Str::slug($photo['id']),
                ]);
            }

            return true;
        }

        return false;
    }

    public function getOneCIdForCreate(Model $model): string
    {
        $modelName = class_basename($model);
        $modelPrefix = mb_substr(strtolower($modelName), 0, 3);

        return $modelPrefix . config('product_onec.onec_id') . $model->id;
    }
}

<?php

namespace App\Services\ONEC;

use App\Jobs\AttributeImportJsonJob;
use App\Jobs\AttributeValueImportJsonJob;
use App\Jobs\BrandImportJsonJob;
use App\Jobs\CategoryImportJsonJob;
use App\Jobs\DescriptionImportJsonJob;
use App\Jobs\ProductImportJsonJob;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Bus;

final class ONECManager
{

    public function importCategories($json): bool
    {
        if (isset($json['Categories'])) {
            $categoriesData = $json['Categories'];
            $header = [];
            $batch  = Bus::batch([]);

            $categoryChunks = array_chunk($categoriesData, 200);

            foreach ($categoryChunks as $categoryChunk) {
                $batch->add(new CategoryImportJsonJob($categoryChunk, $header));
            }

            $batch->name('Import Categories')->dispatch();

            return true;
        }

        return false;
    }

    public function importNomenclature($json): bool
    {
        if (isset($json['Product'])) {
            try {
                DB::beginTransaction();

                ProductCategory::query()->truncate();
                ProductProfile::query()->truncate();

                $productsData = $json['Product'];
                $header = [];
                $batch  = Bus::batch([]);

                $productChunks = array_chunk($productsData, 200);

                foreach ($productChunks as $productChunk) {
                    $batch->add(new ProductImportJsonJob($productChunk, $header));
                }

                $batch->name('Import Products')->dispatch();

                return true;
            } catch (\Exception $e) {
                DB::rollback();

                return false;
            }
        }

        return false;
    }

    public function importBrands($json): bool
    {
        if (isset($json['Brands'])) {

            $brandsData = $json['Brands'];
            $header = [];
            $batch  = Bus::batch([]);

            $brandChunks = array_chunk($brandsData, 200);

            foreach ($brandChunks as $brandChunk) {
                $batch->add(new BrandImportJsonJob($brandChunk, $header));
            }

            $batch->name('Import Brands')->dispatch();

            return true;
        }

        return false;
    }

    public function importAttributes($json): bool
    {
        if (isset($json['Characteristics'])) {

            $attributesData = $json['Characteristics'];
            $header = [];
            $batch  = Bus::batch([]);

            $attributeChunks = array_chunk($attributesData, 200);

            foreach ($attributeChunks as $attributeChunk) {
                $batch->add(new AttributeImportJsonJob($attributeChunk, $header));
            }

            $batch->name('Import Attributes')->dispatch();

            return true;
        }

        return false;
    }

    public function importAttributeValues($json): bool
    {
        if (isset($json['ProductCharacteristics'])) {
            DB::beginTransaction();

            AttributeValue::query()->truncate();
            ProductAttribute::query()->truncate();

            $attributeValuesData = $json['ProductCharacteristics'];
            $header = [];
            $batch  = Bus::batch([]);

            $attributeValueChunks = array_chunk($attributeValuesData, 400);

            foreach ($attributeValueChunks as $attributeValueChunk) {

                $batch->add(new AttributeValueImportJsonJob($attributeValueChunk, $header));
            }

            $batch->name('Import Attribute Values')->dispatch();

        }

        return false;
    }

    public function importProductDescriptions($json): bool
    {
        if (isset($json['Description'])) {
            try {

                $descriptionsData = $json['Description'];
                $header = [];
                $batch  = Bus::batch([]);

                $descriptionsChunks = array_chunk($descriptionsData, 800);

                foreach ($descriptionsChunks as $descriptionChunk) {
                    $batch->add(new DescriptionImportJsonJob($descriptionChunk, $header));
                }

                $batch->name('Import Descriptions')->dispatch();

                return true;
            } catch (\Exception $e) {
                DB::rollback();

                return false;
            }

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

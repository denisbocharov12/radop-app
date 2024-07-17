<?php

namespace App\Http\Mappers;

use App\Data\Product\ProductData;
use App\Http\Requests\Product\ProductRequest;

final class ProductDataMapper
{
    public function mapFromRequestToNormalized(ProductRequest $request): ProductData
    {
        return new ProductData(
            $request->onec_id,
            $request->title_ro,
            $request->title_ru,
            $request->stock,
            $request->unit,
            $request->price,
            $request->sale_price,
            $request->status,
            $request->site_status,
            $request->brand_id,
            $request->category_id,
            $request->attachments,
            $request->sku,
            $request->summary_ro,
            $request->summary_ru,
            $request->description,
            $request->upp_sale,
            $request->iur_price,
            $request->condition,
        );
    }
}

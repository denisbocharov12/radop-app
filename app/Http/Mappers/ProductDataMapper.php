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
            $request->title,
            $request->stock,
            $request->unit,
            $request->price,
            $request->sale_price,
            $request->status,
            $request->brand_id,
            $request->category_id,
            $request->attachments
        );
    }
}

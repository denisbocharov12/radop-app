<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\Product\AddToCartData;
use App\Http\Requests\Theme\Product\AddToCartRequest;

final class AddToCartDataMapper
{
    public function mapFromRequestToNormalized(AddToCartRequest $request): AddToCartData
    {
        return new AddToCartData(
            $request->product_qty,
            $request->product_id
        );
    }
}

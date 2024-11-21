<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\Product\AddToCartData;
use App\Data\Theme\WishList\WishListData;
use App\Http\Requests\Theme\Product\AddToCartRequest;
use App\Http\Requests\Theme\WishList\WishListRequest;

final class AddToWishListDataMapper
{
    public function mapFromRequestToNormalized(WishListRequest $request): WishListData
    {
        return new WishListData(
            $request->product_id
        );
    }
}

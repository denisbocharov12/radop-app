<?php

declare(strict_types=1);

namespace App\Http\Mappers\Product;

use App\Data\Product\UpdateProductConditionsData;
use App\Http\Requests\Product\UpdateProductConditionsRequest;

final class UpdateProductConditionDataMapper
{
    public function mapFromRequestToNormalized(UpdateProductConditionsRequest $request): UpdateProductConditionsData
    {
        return new UpdateProductConditionsData(
            $request->product_ids,
            $request->condition,
        );
    }
}



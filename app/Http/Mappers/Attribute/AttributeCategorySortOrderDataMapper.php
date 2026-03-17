<?php

declare(strict_types=1);

namespace App\Http\Mappers\Attribute;

use App\Data\Attribute\AttributeCategorySortOrderData;
use App\Http\Requests\Attribute\AttributeCategorySortOrderRequest;

final class AttributeCategorySortOrderDataMapper
{
    public function mapFromRequestToNormalized(AttributeCategorySortOrderRequest $request): AttributeCategorySortOrderData
    {
        $order = [];
        foreach ($request->validated('order') as $item) {
            $order[] = [
                'id' => (int) $item['id'],
                'position' => (int) $item['position'],
            ];
        }

        return new AttributeCategorySortOrderData(
            categoryOnecId: $request->validated('category_id'),
            order: $order,
        );
    }
}

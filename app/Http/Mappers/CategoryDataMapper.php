<?php

namespace App\Http\Mappers;

use App\Data\Category\CategoryData;
use App\Http\Requests\Category\CategoryRequest;

final class CategoryDataMapper
{
    public function mapFromRequestToNormalized(CategoryRequest $request): CategoryData
    {
        return new CategoryData(
            $request->onec_id,
            $request->parent_id,
            $request->name,
            $request->summary,
            $request->status,
            $request->order,
        );
    }
}

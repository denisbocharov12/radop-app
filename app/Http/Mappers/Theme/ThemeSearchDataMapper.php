<?php

namespace App\Http\Mappers\Theme;

use App\Data\Theme\Search\ThemeSearchData;
use App\Http\Requests\Theme\Search\ThemeSearchRequest;

final class ThemeSearchDataMapper
{
    /**
     * @param ThemeSearchRequest $request
     * @return ThemeSearchData
     */
    public function mapFromRequestToNormalized(ThemeSearchRequest $request): ThemeSearchData
    {
        return new ThemeSearchData(
            trim($request->search)
        );
    }
}

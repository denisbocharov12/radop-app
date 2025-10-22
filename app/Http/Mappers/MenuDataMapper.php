<?php

declare(strict_types=1);

namespace App\Http\Mappers;

use App\Data\Menu\MenuData;
use App\Http\Requests\Menu\MenuRequest;

final class MenuDataMapper
{
    public function mapFromRequestToNormalized(MenuRequest $request): MenuData
    {
        return new MenuData(
            $request->code,
            $request->name,
            $request->link,
            $request->description,
            (bool) ($request->is_active ?? true)
        );
    }
}


<?php

declare(strict_types=1);

namespace App\Http\Mappers;

use App\Data\Menu\MenuItemData;
use App\Http\Requests\Menu\MenuItemRequest;

final class MenuItemDataMapper
{
    public function mapFromRequestToNormalized(MenuItemRequest $request, int $menuId, int $order = 0): MenuItemData
    {
        return new MenuItemData(
            $menuId,
            $request->parent_id ? (int) $request->parent_id : null,
            (int) ($request->order ?? $order),
            $request->type,
            $request->title,
            $request->link,
            $request->target ?? '_self',
            $request->icon_class,
            $request->content_data,
            (bool) ($request->is_active ?? true)
        );
    }
    
    public function mapFromRequestToArray(MenuItemRequest $request, int $menuId, int $order = 0): array
    {
        return [
            'menu_id' => $menuId,
            'parent_id' => $request->parent_id ? (int) $request->parent_id : null,
            'order' => (int) ($request->order ?? $order),
            'type' => $request->type,
            'title' => $request->title,
            'label_name' => $request->label_name_ro || $request->label_name_ru ? [
                'ro' => $request->label_name_ro,
                'ru' => $request->label_name_ru,
            ] : null,
            'label_color' => $request->label_color,
            'display_title' => (bool) ($request->display_title ?? false),
            'display_as_link' => (bool) ($request->display_as_link ?? true),
            'link' => $request->link,
            'target' => $request->target ?? '_self',
            'icon_class' => $request->icon_class,
            'category_id' => $request->category_id,
            'content_data' => $request->content_data,
            'is_active' => (bool) ($request->is_active ?? true),
        ];
    }

    public function mapToArray(MenuItemData $data): array
    {
        return [
            'menu_id' => $data->menu_id,
            'parent_id' => $data->parent_id,
            'order' => $data->order,
            'type' => $data->type,
            'title' => $data->title,
            'link' => $data->link,
            'target' => $data->target,
            'icon_class' => $data->icon_class,
            'content_data' => $data->content_data,
            'is_active' => $data->is_active,
        ];
    }
}


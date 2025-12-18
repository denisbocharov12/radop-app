<?php

declare(strict_types=1);

namespace App\Services\HeaderMenu;

use App\Http\Requests\HeaderMenu\HeaderMenuRequest;
use App\Http\Requests\HeaderMenu\HeaderMenuItemRequest;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuItem;
use App\Services\HeaderMenuHierarchyService;
use Illuminate\Validation\ValidationException;

final class HeaderMenuManager
{
    public function __construct(
        private readonly HeaderMenuHierarchyService $headerMenuHierarchyService
    ) {
    }

    public function store(HeaderMenuRequest $request): HeaderMenu
    {
        $menu = $this->headerMenuHierarchyService->createHeaderMenu([
            'code' => $request->code,
            'name' => [
                'ro' => $request->name_ro,
                'ru' => $request->name_ru,
            ],
            'link' => [
                'ro' => $request->link_ro,
                'ru' => $request->link_ru,
            ],
            'description' => [
                'ro' => $request->description_ro,
                'ru' => $request->description_ru,
            ],
            'is_active' => $request->is_active ?? true,
        ]);

        if ($request->hasFile('image')) {
            $menu->addMediaFromRequest('image')
                ->toMediaCollection('header_menu_image');
        }

        return $menu;
    }

    public function update(HeaderMenuRequest $request, int $id): HeaderMenu
    {
        $menu = $this->headerMenuHierarchyService->findHeaderMenuById($id);

        if (!$menu) {
            throw new \InvalidArgumentException("Header menu with ID '{$id}' not found");
        }

        if ($request->has('clear_image') && $request->clear_image) {
            $menu->clearMediaCollection('header_menu_image');
        }

        if ($request->code !== $menu->code) {
            $this->headerMenuHierarchyService->updateHeaderMenu($id, [
                'code' => $request->code,
                'name' => [
                    'ro' => $request->name_ro,
                    'ru' => $request->name_ru,
                ],
                'link' => [
                    'ro' => $request->link_ro,
                    'ru' => $request->link_ru,
                ],
                'description' => [
                    'ro' => $request->description_ro,
                    'ru' => $request->description_ru,
                ],
                'is_active' => $request->is_active ?? true,
            ]);
        } else {
            $this->headerMenuHierarchyService->updateHeaderMenu($id, [
                'name' => [
                    'ro' => $request->name_ro,
                    'ru' => $request->name_ru,
                ],
                'link' => [
                    'ro' => $request->link_ro,
                    'ru' => $request->link_ru,
                ],
                'description' => [
                    'ro' => $request->description_ro,
                    'ru' => $request->description_ru,
                ],
                'is_active' => $request->is_active ?? true,
            ]);
        }

        $menu = $this->headerMenuHierarchyService->findHeaderMenuById($id);

        if ($request->hasFile('image')) {
            $menu->clearMediaCollection('header_menu_image');
            $menu->addMediaFromRequest('image')
                ->toMediaCollection('header_menu_image');
        }

        return $menu;
    }

    public function storeItem(HeaderMenuItemRequest $request, int $menuId): HeaderMenuItem
    {
        $data = [
            'header_menu_id' => $menuId,
            'parent_id' => $request->parent_id ? (int) $request->parent_id : null,
            'order' => (int) ($request->order ?? 0),
            'type' => $request->type,
            'title' => [
                'ro' => $request->title_ro,
                'ru' => $request->title_ru,
            ],
            'link' => [
                'ro' => $request->link_ro,
                'ru' => $request->link_ru,
            ],
            'target' => $request->target ?? '_self',
            'icon_class' => $request->icon_class,
            'category_id' => $request->category_id,
            'content_data' => $request->content_data,
            'is_active' => (bool) ($request->is_active ?? true),
        ];

        $menuItem = $this->headerMenuHierarchyService->createHeaderMenuItem($data);

        if ($request->hasFile('image')) {
            $menuItem->addMediaFromRequest('image')
                ->toMediaCollection('header_menu_item_image');
        }

        return $menuItem;
    }

    public function updateItem(HeaderMenuItemRequest $request, int $menuId, int $itemId): HeaderMenuItem
    {
        $menuItem = $this->headerMenuHierarchyService->findHeaderMenuItemById($itemId);

        if (!$menuItem) {
            throw new \InvalidArgumentException("Header menu item with ID '{$itemId}' not found");
        }

        if ($request->has('remove_image') && $request->remove_image) {
            $menuItem->clearMediaCollection('header_menu_item_image');
        }

        $data = [
            'header_menu_id' => $menuId,
            'parent_id' => $request->parent_id ? (int) $request->parent_id : null,
            'order' => (int) ($request->order ?? $menuItem->order),
            'type' => $request->type,
            'title' => [
                'ro' => $request->title_ro,
                'ru' => $request->title_ru,
            ],
            'link' => [
                'ro' => $request->link_ro,
                'ru' => $request->link_ru,
            ],
            'target' => $request->target ?? '_self',
            'icon_class' => $request->icon_class,
            'category_id' => $request->category_id,
            'content_data' => $request->content_data,
            'is_active' => (bool) ($request->is_active ?? true),
        ];

        $this->headerMenuHierarchyService->updateHeaderMenuItem($itemId, $data);

        $menuItem = $this->headerMenuHierarchyService->findHeaderMenuItemById($itemId);

        if ($request->hasFile('image')) {
            $menuItem->clearMediaCollection('header_menu_item_image');
            $menuItem->addMediaFromRequest('image')
                ->toMediaCollection('header_menu_item_image');
        }

        return $menuItem;
    }
}


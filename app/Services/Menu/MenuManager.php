<?php

declare(strict_types=1);

namespace App\Services\Menu;

use App\Http\Requests\Menu\MenuRequest;
use App\Http\Requests\Menu\MenuItemRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\MenuHierarchyService;
use Illuminate\Validation\ValidationException;

final class MenuManager
{
    public function __construct(
        private readonly MenuHierarchyService $menuHierarchyService
    ) {
    }

    /**
     * Create a new menu
     *
     * @param MenuRequest $request
     * @return Menu
     * @throws ValidationException
     */
    public function store(MenuRequest $request): Menu
    {
        $menu = $this->menuHierarchyService->createMenu([
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
                ->toMediaCollection('menu_image');
        }

        return $menu;
    }

    /**
     * Update menu
     *
     * @param MenuRequest $request
     * @param int $id
     * @return Menu
     * @throws ValidationException
     */
    public function update(MenuRequest $request, int $id): Menu
    {
        $menu = $this->menuHierarchyService->findMenuById($id);

        if (!$menu) {
            throw new \InvalidArgumentException("Menu with ID '{$id}' not found");
        }

        if ($request->has('clear_image') && $request->clear_image) {
            $menu->clearMediaCollection('menu_image');
        }

        if ($request->code !== $menu->code) {
            $this->menuHierarchyService->updateMenu($id, [
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
            $this->menuHierarchyService->updateMenu($id, [
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

        $menu = $this->menuHierarchyService->findMenuById($id);

        if ($request->hasFile('image')) {
            $menu->clearMediaCollection('menu_image');
            $menu->addMediaFromRequest('image')
                ->toMediaCollection('menu_image');
        }

        return $menu;
    }

    /**
     * Create a new menu item
     *
     * @param MenuItemRequest $request
     * @param int $menuId
     * @return MenuItem
     * @throws ValidationException
     */
    public function storeItem(MenuItemRequest $request, int $menuId): MenuItem
    {
        $data = [
            'menu_id' => $menuId,
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

        $menuItem = $this->menuHierarchyService->createMenuItem($data);

        if ($request->hasFile('image')) {
            $menuItem->addMediaFromRequest('image')
                ->toMediaCollection('menu_item_image');
        }

        return $menuItem;
    }

    /**
     * Update menu item
     *
     * @param MenuItemRequest $request
     * @param int $menuId
     * @param int $itemId
     * @return MenuItem
     * @throws ValidationException
     */
    public function updateItem(MenuItemRequest $request, int $menuId, int $itemId): MenuItem
    {
        $menuItem = $this->menuHierarchyService->findMenuItemById($itemId);

        if (!$menuItem) {
            throw new \InvalidArgumentException("Menu item with ID '{$itemId}' not found");
        }

        if ($request->has('remove_image') && $request->remove_image) {
            $menuItem->clearMediaCollection('menu_item_image');
        }

        $data = [
            'menu_id' => $menuId,
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

        $this->menuHierarchyService->updateMenuItem($itemId, $data);

        $menuItem = $this->menuHierarchyService->findMenuItemById($itemId);

        if ($request->hasFile('image')) {
            $menuItem->clearMediaCollection('menu_item_image');
            $menuItem->addMediaFromRequest('image')
                ->toMediaCollection('menu_item_image');
        }

        return $menuItem;
    }
}


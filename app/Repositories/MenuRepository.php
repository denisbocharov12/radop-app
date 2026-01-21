<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class MenuRepository implements MenuRepositoryInterface
{
    /**
     * Получить все меню
     *
     * @return Collection
     */
    public function getAllMenus(): Collection
    {
        return Menu::with('items')->get();
    }

    /**
     * Получить активные меню
     *
     * @return Collection
     */
    public function getActiveMenus(): Collection
    {
        return Menu::active()->with('items')->get();
    }

    /**
     * Найти меню по ID
     *
     * @param int $id
     * @return Menu|null
     */
    public function findMenuById(int $id): ?Menu
    {
        $menu = Menu::find($id);
        
        if ($menu) {
            // Загружаем медиа для меню
            $menu->loadMedia('menu_image');
        }
        
        return $menu;
    }

    /**
     * Найти меню по коду
     *
     * @param string $code
     * @return Menu|null
     */
    public function findMenuByCode(string $code): ?Menu
    {
        return Menu::byCode($code)->first();
    }

    /**
     * Получить полную иерархию меню по коду (для фронтенда)
     * Загружает корневые элементы с рекурсивными дочерними элементами
     *
     * @param string $code
     * @param bool $onlyActive
     * @return Menu|null
     */
    public function getMenuHierarchyByCode(string $code, bool $onlyActive = true): ?Menu
    {
        $cacheKey = "menu_hierarchy_{$code}_" . ($onlyActive ? 'active' : 'all');
        
        return Cache::remember($cacheKey, 86400, function () use ($code, $onlyActive) {
            $query = Menu::byCode($code);

            if ($onlyActive) {
                $query->active();
            }

            $menu = $query->with(['rootItems' => function ($query) use ($onlyActive) {
                if ($onlyActive) {
                    $query->active();
                }
                
                $query->with(['children' => function ($childrenQuery) use ($onlyActive) {
                    if ($onlyActive) {
                        $childrenQuery->active();
                    }
                    $childrenQuery->orderBy('order');
                }])->orderBy('order');
            }])->first();
            
            if ($menu && $menu->rootItems) {
                $menu->rootItems->load('media');
                foreach ($menu->rootItems as $item) {
                    if ($item->children) {
                        $item->children->load('media');
                        foreach ($item->children as $child) {
                            if ($child->children) {
                                $child->children->load('media');
                            }
                        }
                    }
                }
            }
            
            return $menu;
        });
    }

    /**
     * Создать новое меню
     *
     * @param array $data
     * @return Menu
     */
    public function createMenu(array $data): Menu
    {
        return Menu::create($data);
    }

    /**
     * Обновить меню
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateMenu(int $id, array $data): bool
    {
        $menu = $this->findMenuById($id);

        if (!$menu) {
            return false;
        }

        return $menu->update($data);
    }

    /**
     * Удалить меню
     *
     * @param int $id
     * @return bool
     */
    public function deleteMenu(int $id): bool
    {
        $menu = $this->findMenuById($id);

        if (!$menu) {
            return false;
        }

        return $menu->delete();
    }

    /**
     * Найти элемент меню по ID
     *
     * @param int $id
     * @return MenuItem|null
     */
    public function findMenuItemById(int $id): ?MenuItem
    {
        $menuItem = MenuItem::with(['menu', 'parent', 'children'])->find($id);
        
        if ($menuItem) {
            // Загружаем медиа для элемента меню
            $menuItem->loadMedia('menu_item_image');
        }
        
        return $menuItem;
    }

    /**
     * Получить все элементы меню
     *
     * @param int $menuId
     * @param bool $onlyActive
     * @return Collection
     */
    public function getMenuItems(int $menuId, bool $onlyActive = false): Collection
    {
        $query = MenuItem::where('menu_id', $menuId)->orderBy('order');

        if ($onlyActive) {
            $query->active();
        }

        return $query->get();
    }

    /**
     * Получить корневые элементы меню
     *
     * @param int $menuId
     * @param bool $onlyActive
     * @return Collection
     */
    public function getRootMenuItems(int $menuId, bool $onlyActive = true): Collection
    {
        $query = MenuItem::where('menu_id', $menuId)
            ->rootItems()
            ->orderBy('order');

        if ($onlyActive) {
            $query->active();
        }

        return $query->with('children')->get();
    }

    /**
     * Создать элемент меню
     *
     * @param array $data
     * @return MenuItem
     */
    public function createMenuItem(array $data): MenuItem
    {
        // Автоматически устанавливаем order, если не указан
        if (!isset($data['order'])) {
            $data['order'] = $this->getMaxOrderForMenuItem(
                $data['menu_id'],
                $data['parent_id'] ?? null
            ) + 1;
        }

        return MenuItem::create($data);
    }

    /**
     * Обновить элемент меню
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateMenuItem(int $id, array $data): bool
    {
        $menuItem = $this->findMenuItemById($id);

        if (!$menuItem) {
            return false;
        }

        return $menuItem->update($data);
    }

    /**
     * Удалить элемент меню
     *
     * @param int $id
     * @return bool
     */
    public function deleteMenuItem(int $id): bool
    {
        $menuItem = $this->findMenuItemById($id);

        if (!$menuItem) {
            return false;
        }

        return $menuItem->delete();
    }

    /**
     * Массовое обновление порядка и parent_id для элементов меню
     * (используется для Drag & Drop)
     *
     * @param array $items Массив вида [['id' => 1, 'parent_id' => null, 'order' => 0], ...]
     * @return bool
     */
    public function bulkUpdateMenuItemsHierarchy(array $items): bool
    {
        try {
            DB::beginTransaction();

            foreach ($items as $item) {
                if (!isset($item['id'])) {
                    continue;
                }

                MenuItem::where('id', $item['id'])->update([
                    'parent_id' => $item['parent_id'] ?? null,
                    'order' => $item['order'] ?? 0,
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to bulk update menu items hierarchy: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Получить максимальное значение order для элементов меню
     *
     * @param int $menuId
     * @param int|null $parentId
     * @return int
     */
    public function getMaxOrderForMenuItem(int $menuId, ?int $parentId = null): int
    {
        $query = MenuItem::where('menu_id', $menuId);

        if ($parentId === null) {
            $query->whereNull('parent_id');
        } else {
            $query->where('parent_id', $parentId);
        }

        return $query->max('order') ?? 0;
    }
}


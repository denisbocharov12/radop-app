<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\UpdateMenuCacheJob;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Repositories\MenuRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MenuHierarchyService
{
    /**
     * @var MenuRepositoryInterface
     */
    protected MenuRepositoryInterface $menuRepository;

    /**
     * Время кэширования меню в секундах (по умолчанию 24 часа)
     *
     * @var int
     */
    protected int $cacheTime = 86400;

    /**
     * MenuHierarchyService constructor.
     *
     * @param MenuRepositoryInterface $menuRepository
     */
    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Получить иерархию меню по коду (с кэшированием)
     *
     * @param string $menuCode
     * @param bool $onlyActive
     * @return Menu|null
     */
    public function getMenuHierarchy(string $menuCode, bool $onlyActive = true): ?Menu
    {
        $cacheKey = $this->getCacheKey($menuCode, $onlyActive);
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($menuCode, $onlyActive) {
            return $this->menuRepository->getMenuHierarchyByCode($menuCode, $onlyActive);
        });
    }

    /**
     * Обновить иерархию меню (Drag & Drop handler)
     * Принимает плоский массив структуры и обновляет БД
     *
     * @param string $menuCode
     * @param array $structure Массив вида [['id' => 1, 'parent_id' => null, 'order' => 0], ...]
     * @return bool
     * @throws ValidationException
     */
    public function updateHierarchy(string $menuCode, array $structure): bool
    {
        // Валидация структуры
        $this->validateStructure($structure);

        $menu = $this->menuRepository->findMenuByCode($menuCode);

        if (!$menu) {
            throw new \InvalidArgumentException("Menu with code '{$menuCode}' not found");
        }

        try {
            DB::beginTransaction();

            // Массовое обновление иерархии
            $result = $this->menuRepository->bulkUpdateMenuItemsHierarchy($structure);

            if (!$result) {
                throw new \RuntimeException('Failed to update menu hierarchy');
            }

            DB::commit();

            UpdateMenuCacheJob::dispatch($menuCode, true)->onQueue('high');
            UpdateMenuCacheJob::dispatch($menuCode, false)->onQueue('high');

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update menu hierarchy: ' . $e->getMessage(), [
                'menu_code' => $menuCode,
                'structure' => $structure,
            ]);
            throw $e;
        }
    }

    /**
     * Создать меню
     *
     * @param array $data
     * @return Menu
     * @throws ValidationException
     */
    public function createMenu(array $data): Menu
    {
        $this->validateMenuData($data);

        $menu = $this->menuRepository->createMenu($data);

        return $menu;
    }

    /**
     * Обновить меню
     *
     * @param int $menuId
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function updateMenu(int $menuId, array $data): bool
    {
        $menu = $this->menuRepository->findMenuById($menuId);

        if (!$menu) {
            throw new \InvalidArgumentException("Menu with ID '{$menuId}' not found");
        }

        $result = $this->menuRepository->updateMenu($menuId, $data);

        if ($result && $menu) {
            UpdateMenuCacheJob::dispatch($menu->code, true)->onQueue('high');
            UpdateMenuCacheJob::dispatch($menu->code, false)->onQueue('high');
        }

        return $result;
    }

    /**
     * Удалить меню
     *
     * @param int $menuId
     * @return bool
     */
    public function deleteMenu(int $menuId): bool
    {
        $menu = $this->menuRepository->findMenuById($menuId);

        if (!$menu) {
            throw new \InvalidArgumentException("Menu with ID '{$menuId}' not found");
        }

        $result = $this->menuRepository->deleteMenu($menuId);

        if ($result && $menu) {
            UpdateMenuCacheJob::dispatch($menu->code, true)->onQueue('high');
            UpdateMenuCacheJob::dispatch($menu->code, false)->onQueue('high');
        }

        return $result;
    }

    /**
     * Создать элемент меню
     *
     * @param array $data
     * @return MenuItem
     * @throws ValidationException
     */
    public function createMenuItem(array $data): MenuItem
    {
        $this->validateMenuItemData($data);

        $menuItem = $this->menuRepository->createMenuItem($data);

        if ($menuItem && $menuItem->menu) {
            UpdateMenuCacheJob::dispatch($menuItem->menu->code, true)->onQueue('high');
            UpdateMenuCacheJob::dispatch($menuItem->menu->code, false)->onQueue('high');
        }

        return $menuItem;
    }

    /**
     * Обновить элемент меню
     *
     * @param int $itemId
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function updateMenuItem(int $itemId, array $data): bool
    {
        $this->validateMenuItemData($data, true);

        $menuItem = $this->menuRepository->findMenuItemById($itemId);

        if (!$menuItem) {
            throw new \InvalidArgumentException("Menu item with ID '{$itemId}' not found");
        }

        $result = $this->menuRepository->updateMenuItem($itemId, $data);

        if ($result && $menuItem && $menuItem->menu) {
            UpdateMenuCacheJob::dispatch($menuItem->menu->code, true)->onQueue('high');
            UpdateMenuCacheJob::dispatch($menuItem->menu->code, false)->onQueue('high');
        }

        return $result;
    }

    /**
     * Удалить элемент меню
     *
     * @param int $itemId
     * @return bool
     */
    public function deleteMenuItem(int $itemId): bool
    {
        $menuItem = $this->menuRepository->findMenuItemById($itemId);

        if (!$menuItem) {
            throw new \InvalidArgumentException("Menu item with ID '{$itemId}' not found");
        }

        $result = $this->menuRepository->deleteMenuItem($itemId);

        if ($result && $menuItem && $menuItem->menu) {
            UpdateMenuCacheJob::dispatch($menuItem->menu->code, true)->onQueue('high');
            UpdateMenuCacheJob::dispatch($menuItem->menu->code, false)->onQueue('high');
        }

        return $result;
    }

    /**
     * Получить все меню
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllMenus()
    {
        return $this->menuRepository->getAllMenus();
    }

    /**
     * Получить все меню с пагинацией
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllMenusPaginated(int $perPage = 15)
    {
        return Menu::with('items')->paginate($perPage);
    }

    /**
     * Найти меню по ID
     *
     * @param int $id
     * @return Menu|null
     */
    public function findMenuById(int $id): ?Menu
    {
        return $this->menuRepository->findMenuById($id);
    }

    /**
     * Найти элемент меню по ID
     *
     * @param int $id
     * @return MenuItem|null
     */
    public function findMenuItemById(int $id): ?MenuItem
    {
        return $this->menuRepository->findMenuItemById($id);
    }

    /**
     * Преобразовать иерархию меню в плоский массив (для фронтенда)
     *
     * @param string $menuCode
     * @return array
     */
    public function getMenuAsFlatArray(string $menuCode): array
    {
        $menu = $this->getMenuHierarchy($menuCode, false);

        if (!$menu) {
            return [];
        }

        $flatArray = [];
        $this->flattenMenuItems($menu->items, $flatArray);

        return $flatArray;
    }

    /**
     * Рекурсивно преобразовать элементы меню в плоский массив
     *
     * @param $items
     * @param array $result
     * @param int $depth
     * @return void
     */
    protected function flattenMenuItems($items, array &$result, int $depth = 0): void
    {
        foreach ($items as $item) {
            $titleRaw = $item->getRawOriginal('title');
            $linkRaw = $item->getRawOriginal('link');

            $title = is_array(json_decode($titleRaw, true))
                ? $item->getTranslation('title', 'ru')
                : ($titleRaw ?? '');

            $link = is_array(json_decode($linkRaw, true))
                ? $item->getTranslation('link', 'ru')
                : ($linkRaw ?? '');

            $result[] = [
                'id' => $item->id,
                'parent_id' => $item->parent_id,
                'order' => $item->order,
                'title' => $title,
                'type' => $item->type,
                'link' => $link,
                'is_active' => $item->is_active,
                'depth' => $depth,
            ];

            if ($item->allChildren && $item->allChildren->isNotEmpty()) {
                $this->flattenMenuItems($item->allChildren, $result, $depth + 1);
            }
        }
    }

    /**
     * Валидация данных меню
     *
     * @param array $data
     * @param bool $isUpdate
     * @return void
     * @throws ValidationException
     */
    protected function validateMenuData(array $data, bool $isUpdate = false): void
    {
        $rules = [
            'code' => $isUpdate ? 'sometimes|string|max:255|unique:menus,code,' . ($data['id'] ?? 0) : 'required|string|max:255|unique:menus,code',
            'name' => 'required|array',
            'name.ro' => 'required|string|max:255',
            'name.ru' => 'required|string|max:255',
            'link' => 'nullable|array',
            'link.ro' => 'nullable|string|max:255',
            'link.ru' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.ro' => 'nullable|string',
            'description.ru' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Валидация данных элемента меню
     *
     * @param array $data
     * @param bool $isUpdate
     * @return void
     * @throws ValidationException
     */
    protected function validateMenuItemData(array $data, bool $isUpdate = false): void
    {
        $rules = [
            'menu_id' => $isUpdate ? 'sometimes|exists:menus,id' : 'required|exists:menus,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'sometimes|integer|min:0',
            'type' => 'required|in:category,custom_link,promo_block,widget_link,row',
            'title' => 'required|array',
            'title.ro' => 'required|string|max:255',
            'title.ru' => 'required|string|max:255',
            'link' => 'nullable|array',
            'link.ro' => 'nullable|string|max:255',
            'link.ru' => 'nullable|string|max:255',
            'target' => 'sometimes|string|in:_self,_blank,_parent,_top',
            'icon_class' => 'nullable|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'content_data' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Валидация структуры иерархии
     *
     * @param array $structure
     * @return void
     * @throws ValidationException
     */
    protected function validateStructure(array $structure): void
    {
        foreach ($structure as $item) {
            $validator = Validator::make($item, [
                'id' => 'required|exists:menu_items,id',
                'parent_id' => 'nullable|exists:menu_items,id',
                'order' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }
    }

    /**
     * Получить ключ кэша для меню
     *
     * @param string $menuCode
     * @param bool $onlyActive
     * @return string
     */
    protected function getCacheKey(string $menuCode, bool $onlyActive): string
    {
        $suffix = $onlyActive ? 'active' : 'all';
        return "menu_hierarchy_{$menuCode}_{$suffix}";
    }

    /**
     * @param string $menuCode
     * @return void
     */
    protected function clearMenuCache(string $menuCode): void
    {
        Cache::forget($this->getCacheKey($menuCode, true));
        Cache::forget($this->getCacheKey($menuCode, false));
    }

    /**
     * Очистить весь кэш меню
     *
     * @return void
     */
    public function clearAllMenuCache(): void
    {
        Cache::flush();
    }
}


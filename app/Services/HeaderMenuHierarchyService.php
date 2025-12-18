<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\HeaderMenu;
use App\Models\HeaderMenuItem;
use App\Repositories\HeaderMenuRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HeaderMenuHierarchyService
{
    protected HeaderMenuRepositoryInterface $headerMenuRepository;

    protected int $cacheTime = 86400;

    public function __construct(HeaderMenuRepositoryInterface $headerMenuRepository)
    {
        $this->headerMenuRepository = $headerMenuRepository;
    }

    public function getHeaderMenuHierarchy(string $menuCode, bool $onlyActive = true): ?HeaderMenu
    {
        $cacheKey = $this->getCacheKey($menuCode, $onlyActive);

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($menuCode, $onlyActive) {
            return $this->headerMenuRepository->getHeaderMenuHierarchyByCode($menuCode, $onlyActive);
        });
    }

    public function updateHierarchy(string $menuCode, array $structure): bool
    {
        $this->validateStructure($structure);

        $menu = $this->headerMenuRepository->findHeaderMenuByCode($menuCode);

        if (!$menu) {
            throw new \InvalidArgumentException("Header menu with code '{$menuCode}' not found");
        }

        try {
            DB::beginTransaction();

            $result = $this->headerMenuRepository->bulkUpdateHeaderMenuItemsHierarchy($structure);

            if (!$result) {
                throw new \RuntimeException('Failed to update header menu hierarchy');
            }

            DB::commit();

            $this->clearHeaderMenuCache($menuCode);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update header menu hierarchy: ' . $e->getMessage(), [
                'menu_code' => $menuCode,
                'structure' => $structure,
            ]);
            throw $e;
        }
    }

    public function createHeaderMenu(array $data): HeaderMenu
    {
        $this->validateHeaderMenuData($data);

        $menu = $this->headerMenuRepository->createHeaderMenu($data);

        return $menu;
    }

    public function updateHeaderMenu(int $menuId, array $data): bool
    {
        $menu = $this->headerMenuRepository->findHeaderMenuById($menuId);

        if (!$menu) {
            throw new \InvalidArgumentException("Header menu with ID '{$menuId}' not found");
        }

        $result = $this->headerMenuRepository->updateHeaderMenu($menuId, $data);

        if ($result) {
            $this->clearHeaderMenuCache($menu->code);
        }

        return $result;
    }

    public function deleteHeaderMenu(int $menuId): bool
    {
        $menu = $this->headerMenuRepository->findHeaderMenuById($menuId);

        if (!$menu) {
            throw new \InvalidArgumentException("Header menu with ID '{$menuId}' not found");
        }

        $result = $this->headerMenuRepository->deleteHeaderMenu($menuId);

        if ($result) {
            $this->clearHeaderMenuCache($menu->code);
        }

        return $result;
    }

    public function createHeaderMenuItem(array $data): HeaderMenuItem
    {
        $this->validateHeaderMenuItemData($data);

        $menuItem = $this->headerMenuRepository->createHeaderMenuItem($data);

        $menu = $this->headerMenuRepository->findHeaderMenuById($data['header_menu_id']);
        if ($menu) {
            $this->clearHeaderMenuCache($menu->code);
        }

        return $menuItem;
    }

    public function updateHeaderMenuItem(int $itemId, array $data): bool
    {
        $this->validateHeaderMenuItemData($data, true);

        $menuItem = $this->headerMenuRepository->findHeaderMenuItemById($itemId);

        if (!$menuItem) {
            throw new \InvalidArgumentException("Header menu item with ID '{$itemId}' not found");
        }

        $result = $this->headerMenuRepository->updateHeaderMenuItem($itemId, $data);

        if ($result) {
            $this->clearHeaderMenuCache($menuItem->headerMenu->code);
        }

        return $result;
    }

    public function deleteHeaderMenuItem(int $itemId): bool
    {
        $menuItem = $this->headerMenuRepository->findHeaderMenuItemById($itemId);

        if (!$menuItem) {
            throw new \InvalidArgumentException("Header menu item with ID '{$itemId}' not found");
        }

        $result = $this->headerMenuRepository->deleteHeaderMenuItem($itemId);

        if ($result) {
            $this->clearHeaderMenuCache($menuItem->headerMenu->code);
        }

        return $result;
    }

    public function getAllHeaderMenus()
    {
        return $this->headerMenuRepository->getAllHeaderMenus();
    }

    public function getAllHeaderMenusPaginated(int $perPage = 15)
    {
        return HeaderMenu::with('items')->paginate($perPage);
    }

    public function findHeaderMenuById(int $id): ?HeaderMenu
    {
        return $this->headerMenuRepository->findHeaderMenuById($id);
    }

    public function findHeaderMenuItemById(int $id): ?HeaderMenuItem
    {
        return $this->headerMenuRepository->findHeaderMenuItemById($id);
    }

    public function getHeaderMenuAsFlatArray(string $menuCode): array
    {
        $menu = $this->getHeaderMenuHierarchy($menuCode, false);

        if (!$menu) {
            return [];
        }

        $flatArray = [];
        $this->flattenHeaderMenuItems($menu->items, $flatArray);

        return $flatArray;
    }

    protected function flattenHeaderMenuItems($items, array &$result, int $depth = 0): void
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
                $this->flattenHeaderMenuItems($item->allChildren, $result, $depth + 1);
            }
        }
    }

    protected function validateHeaderMenuData(array $data, bool $isUpdate = false): void
    {
        $rules = [
            'code' => $isUpdate ? 'sometimes|string|max:255|unique:header_menus,code,' . ($data['id'] ?? 0) : 'required|string|max:255|unique:header_menus,code',
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

    protected function validateHeaderMenuItemData(array $data, bool $isUpdate = false): void
    {
        $rules = [
            'header_menu_id' => $isUpdate ? 'sometimes|exists:header_menus,id' : 'required|exists:header_menus,id',
            'parent_id' => 'nullable|exists:header_menu_items,id',
            'order' => 'sometimes|integer|min:0',
            'type' => 'required|in:category,custom_link,promo_block,widget_link',
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

    protected function validateStructure(array $structure): void
    {
        foreach ($structure as $item) {
            $validator = Validator::make($item, [
                'id' => 'required|exists:header_menu_items,id',
                'parent_id' => 'nullable|exists:header_menu_items,id',
                'order' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }
    }

    protected function getCacheKey(string $menuCode, bool $onlyActive): string
    {
        $suffix = $onlyActive ? 'active' : 'all';
        return "header_menu_hierarchy_{$menuCode}_{$suffix}";
    }

    protected function clearHeaderMenuCache(string $menuCode): void
    {
        Cache::forget($this->getCacheKey($menuCode, true));
        Cache::forget($this->getCacheKey($menuCode, false));
    }

    public function clearAllHeaderMenuCache(): void
    {
        $menus = $this->headerMenuRepository->getAllHeaderMenus();

        foreach ($menus as $menu) {
            $this->clearHeaderMenuCache($menu->code);
        }
    }
}


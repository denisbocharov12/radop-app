<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\HeaderMenu;
use App\Models\HeaderMenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class HeaderMenuRepository implements HeaderMenuRepositoryInterface
{
    public function getAllHeaderMenus(): Collection
    {
        return HeaderMenu::with('items')->get();
    }

    public function getActiveHeaderMenus(): Collection
    {
        return HeaderMenu::active()->with('items')->get();
    }

    public function findHeaderMenuById(int $id): ?HeaderMenu
    {
        $menu = HeaderMenu::find($id);
        
        if ($menu) {
            $menu->loadMedia('header_menu_image');
        }
        
        return $menu;
    }

    public function findHeaderMenuByCode(string $code): ?HeaderMenu
    {
        return HeaderMenu::byCode($code)->first();
    }

    public function getHeaderMenuHierarchyByCode(string $code, bool $onlyActive = true): ?HeaderMenu
    {
        $query = HeaderMenu::byCode($code);

        if ($onlyActive) {
            $query->active();
        }

        $menu = $query->with(['rootItems' => function ($query) use ($onlyActive) {
            if ($onlyActive) {
                $query->active();
            }
            
            $query->with('children')->orderBy('order');
        }])->first();
        
        if ($menu && $menu->rootItems) {
            $menu->rootItems->load('media');
            foreach ($menu->rootItems as $item) {
                if ($item->children) {
                    $item->children->load('media');
                }
            }
        }
        
        return $menu;
    }

    public function createHeaderMenu(array $data): HeaderMenu
    {
        return HeaderMenu::create($data);
    }

    public function updateHeaderMenu(int $id, array $data): bool
    {
        $menu = $this->findHeaderMenuById($id);

        if (!$menu) {
            return false;
        }

        return $menu->update($data);
    }

    public function deleteHeaderMenu(int $id): bool
    {
        $menu = $this->findHeaderMenuById($id);

        if (!$menu) {
            return false;
        }

        return $menu->delete();
    }

    public function findHeaderMenuItemById(int $id): ?HeaderMenuItem
    {
        $menuItem = HeaderMenuItem::with(['headerMenu', 'parent', 'children'])->find($id);
        
        if ($menuItem) {
            $menuItem->loadMedia('header_menu_item_image');
        }
        
        return $menuItem;
    }

    public function getHeaderMenuItems(int $headerMenuId, bool $onlyActive = false): Collection
    {
        $query = HeaderMenuItem::where('header_menu_id', $headerMenuId)->orderBy('order');

        if ($onlyActive) {
            $query->active();
        }

        return $query->get();
    }

    public function getRootHeaderMenuItems(int $headerMenuId, bool $onlyActive = true): Collection
    {
        $query = HeaderMenuItem::where('header_menu_id', $headerMenuId)
            ->rootItems()
            ->orderBy('order');

        if ($onlyActive) {
            $query->active();
        }

        return $query->with('children')->get();
    }

    public function createHeaderMenuItem(array $data): HeaderMenuItem
    {
        if (!isset($data['order'])) {
            $data['order'] = $this->getMaxOrderForHeaderMenuItem(
                $data['header_menu_id'],
                $data['parent_id'] ?? null
            ) + 1;
        }

        return HeaderMenuItem::create($data);
    }

    public function updateHeaderMenuItem(int $id, array $data): bool
    {
        $menuItem = $this->findHeaderMenuItemById($id);

        if (!$menuItem) {
            return false;
        }

        return $menuItem->update($data);
    }

    public function deleteHeaderMenuItem(int $id): bool
    {
        $menuItem = $this->findHeaderMenuItemById($id);

        if (!$menuItem) {
            return false;
        }

        return $menuItem->delete();
    }

    public function bulkUpdateHeaderMenuItemsHierarchy(array $items): bool
    {
        try {
            DB::beginTransaction();

            foreach ($items as $item) {
                if (!isset($item['id'])) {
                    continue;
                }

                HeaderMenuItem::where('id', $item['id'])->update([
                    'parent_id' => $item['parent_id'] ?? null,
                    'order' => $item['order'] ?? 0,
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to bulk update header menu items hierarchy: ' . $e->getMessage());
            return false;
        }
    }

    public function getMaxOrderForHeaderMenuItem(int $headerMenuId, ?int $parentId = null): int
    {
        $query = HeaderMenuItem::where('header_menu_id', $headerMenuId);

        if ($parentId === null) {
            $query->whereNull('parent_id');
        } else {
            $query->where('parent_id', $parentId);
        }

        return $query->max('order') ?? 0;
    }
}


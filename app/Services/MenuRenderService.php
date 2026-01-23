<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MenuItem;
use App\Repositories\MenuRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

final class MenuRenderService
{
    protected MenuRepositoryInterface $menuRepository;
    protected MegaMenuProductCountService $productCountService;

    /**
     * @param MenuRepositoryInterface $menuRepository
     * @param MegaMenuProductCountService $productCountService
     */
    public function __construct(
        MenuRepositoryInterface $menuRepository,
        MegaMenuProductCountService $productCountService
    ) {
        $this->menuRepository = $menuRepository;
        $this->productCountService = $productCountService;
    }

    /**
     * @param string $code
     * @param string $cssClass
     * @param string $view
     * @return string
     */
    public function render(string $code, string $cssClass = '', string $view = 'partials.menus.mega-menu'): string
    {
        $cacheKey = "menu_render_{$code}_{$view}_" . md5($cssClass) . '_' . app()->getLocale();

        return Cache::remember($cacheKey, 3600, function () use ($code, $cssClass, $view) {
            $menu = $this->menuRepository->getMenuHierarchyByCode($code);

            if (!$menu || !$menu->is_active || $menu->rootItems->isEmpty()) {
                return '';
            }

            $menu->rootItems = $this->productCountService->attachProductCountsToMenuItems($menu->rootItems);

            return View::make($view, [
                'menu' => $menu,
                'cssClass' => $cssClass,
                'code' => $code,
            ])->render();
        });
    }

    /**
     * @param string $code
     * @param string $cssClass
     * @return string
     */
    public function renderContent(string $code, string $cssClass = ''): string
    {
        $cacheKey = "menu_content_{$code}_" . md5($cssClass) . '_' . app()->getLocale();

        return Cache::remember($cacheKey, 3600, function () use ($code, $cssClass) {
            $menu = $this->menuRepository->getMenuHierarchyByCode($code);

            if (!$menu || !$menu->is_active || $menu->rootItems->isEmpty()) {
                return '';
            }

            $menu->rootItems = $this->productCountService->attachProductCountsToMenuItems($menu->rootItems);

            return View::make('partials.menus.mega-menu-content', [
                'menu' => $menu,
                'cssClass' => $cssClass,
                'code' => $code,
            ])->render();
        });
    }

    /**
     * @param string $code
     * @param string $cssClass
     * @return string
     */
    public function renderMobileContent(string $code, string $cssClass = ''): string
    {
        $cacheKey = "menu_mobile_content_{$code}_" . md5($cssClass) . '_' . app()->getLocale();

        return Cache::remember($cacheKey, 3600, function () use ($code, $cssClass) {
            $menu = $this->menuRepository->getMenuHierarchyByCode($code);

            if (!$menu || !$menu->is_active || $menu->rootItems->isEmpty()) {
                return '';
            }

            $menu->rootItems = $this->productCountService->attachProductCountsToMenuItems($menu->rootItems);

            return View::make('partials.menus.mobile-mega-menu-content', [
                'menu' => $menu,
                'cssClass' => $cssClass,
                'code' => $code,
            ])->render();
        });
    }

    /**
     * @param string $code
     * @return \App\Models\Menu|null
     */
    public function getMenuData(string $code)
    {
        $cacheKey = "menu_data_{$code}_" . app()->getLocale();

        return Cache::remember($cacheKey, 3600, function () use ($code) {
            $menu = $this->menuRepository->getMenuHierarchyByCode($code);

            if ($menu && $menu->rootItems) {
                $menu->rootItems = $this->productCountService->attachProductCountsToMenuItems($menu->rootItems);
            }

            return $menu;
        });
    }

    /**
     * @param int $itemId
     * @param string $code
     * @return string
     */
    public function renderCategoryContent(int $itemId, string $code): string
    {
        $cacheKey = "menu_category_content_{$code}_{$itemId}_" . app()->getLocale();

        return Cache::remember($cacheKey, 3600, function () use ($itemId, $code) {
            $menu = $this->menuRepository->getMenuHierarchyByCode($code);

            if (!$menu || !$menu->is_active) {
                return '';
            }

            $item = MenuItem::with(['children' => function ($query) {
                $query->active()->orderBy('order');
            }])
            ->where('id', $itemId)
            ->where('menu_id', $menu->id)
            ->active()
            ->first();

            if (!$item) {
                return '';
            }

            $item->load('media');
            if ($item->children) {
                $item->children->load('media');
                foreach ($item->children as $child) {
                    if ($child->children) {
                        $child->children->load('media');
                    }
                }
            }

            $item = $this->productCountService->attachProductCountsToMenuItems(collect([$item]))->first();

            return View::make('partials.menus.mega-menu-category-content', [
                'item' => $item,
            ])->render();
        });
    }

    /**
     * @param int $itemId
     * @param string $code
     * @return string
     */
    public function renderMobileCategoryContent(int $itemId, string $code): string
    {
        $cacheKey = "menu_mobile_category_content_{$code}_{$itemId}_" . app()->getLocale();

        return Cache::remember($cacheKey, 3600, function () use ($itemId, $code) {
            $menu = $this->menuRepository->getMenuHierarchyByCode($code);

            if (!$menu || !$menu->is_active) {
                return '';
            }

            $item = MenuItem::with(['children' => function ($query) {
                $query->active()->orderBy('order');
            }])
            ->where('id', $itemId)
            ->where('menu_id', $menu->id)
            ->active()
            ->first();

            if (!$item) {
                return '';
            }

            $item->load('media');
            if ($item->children) {
                $item->children->load('media');
                foreach ($item->children as $child) {
                    if ($child->children) {
                        $child->children->load('media');
                    }
                }
            }

            $item = $this->productCountService->attachProductCountsToMenuItems(collect([$item]))->first();

            return View::make('partials.menus.mobile-mega-menu-category-content', [
                'item' => $item,
            ])->render();
        });
    }
}


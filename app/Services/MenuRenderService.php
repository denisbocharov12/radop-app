<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Menu;
use App\Repositories\MenuRepositoryInterface;
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
    }

    /**
     * @param string $code
     * @param string $cssClass
     * @return string
     */
    public function renderContent(string $code, string $cssClass = ''): string
    {
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
    }

    /**
     * @param string $code
     * @param string $cssClass
     * @return string
     */
    public function renderMobileContent(string $code, string $cssClass = ''): string
    {
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
    }

    /**
     * @param string $code
     * @return \App\Models\Menu|null
     */
    public function getMenuData(string $code)
    {
        $menu = $this->menuRepository->getMenuHierarchyByCode($code);

        if ($menu && $menu->rootItems) {
            $menu->rootItems = $this->productCountService->attachProductCountsToMenuItems($menu->rootItems);
        }

        return $menu;
    }
}


<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\HeaderMenuRepositoryInterface;
use Illuminate\Support\Facades\View;

final class HeaderMenuRenderService
{
    protected HeaderMenuRepositoryInterface $headerMenuRepository;
    protected MegaMenuProductCountService $productCountService;

    /**
     * @param HeaderMenuRepositoryInterface $headerMenuRepository
     * @param MegaMenuProductCountService $productCountService
     */
    public function __construct(
        HeaderMenuRepositoryInterface $headerMenuRepository,
        MegaMenuProductCountService $productCountService
    ) {
        $this->headerMenuRepository = $headerMenuRepository;
        $this->productCountService = $productCountService;
    }

    /**
     * @param string $code
     * @param string $cssClass
     * @param string $view
     * @return string
     */
    public function render(string $code, string $cssClass = '', string $view = 'partials.header-menus.header-menu'): string
    {
        $menu = $this->headerMenuRepository->getHeaderMenuHierarchyByCode($code);

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
     * @return \App\Models\HeaderMenu|null
     */
    public function getHeaderMenuData(string $code)
    {
        $menu = $this->headerMenuRepository->getHeaderMenuHierarchyByCode($code);

        if ($menu && $menu->rootItems) {
            $menu->rootItems = $this->productCountService->attachProductCountsToMenuItems($menu->rootItems);
        }

        return $menu;
    }
}


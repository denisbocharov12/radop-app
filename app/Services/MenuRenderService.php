<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\MenuRepositoryInterface;
use Illuminate\Support\Facades\View;

final class MenuRenderService
{
    /**
     * @var MenuRepositoryInterface
     */
    protected MenuRepositoryInterface $menuRepository;

    /**
     * MenuRenderService constructor.
     *
     * @param MenuRepositoryInterface $menuRepository
     */
    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Render menu by code
     *
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

        return View::make($view, [
            'menu' => $menu,
            'cssClass' => $cssClass,
            'code' => $code,
        ])->render();
    }

    /**
     * Get menu data by code
     *
     * @param string $code
     * @return \App\Models\Menu|null
     */
    public function getMenuData(string $code)
    {
        return $this->menuRepository->getMenuHierarchyByCode($code);
    }
}


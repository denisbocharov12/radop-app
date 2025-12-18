<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\HeaderMenuRepositoryInterface;
use Illuminate\Support\Facades\View;

final class HeaderMenuRenderService
{
    protected HeaderMenuRepositoryInterface $headerMenuRepository;

    public function __construct(HeaderMenuRepositoryInterface $headerMenuRepository)
    {
        $this->headerMenuRepository = $headerMenuRepository;
    }

    public function render(string $code, string $cssClass = '', string $view = 'partials.header-menus.header-menu'): string
    {
        $menu = $this->headerMenuRepository->getHeaderMenuHierarchyByCode($code);

        if (!$menu || !$menu->is_active || $menu->rootItems->isEmpty()) {
            return '';
        }

        return View::make($view, [
            'menu' => $menu,
            'cssClass' => $cssClass,
            'code' => $code,
        ])->render();
    }

    public function getHeaderMenuData(string $code)
    {
        return $this->headerMenuRepository->getHeaderMenuHierarchyByCode($code);
    }
}


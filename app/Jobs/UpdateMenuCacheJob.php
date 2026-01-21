<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\MenuRepositoryInterface;
use App\Services\MegaMenuProductCountService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

final class UpdateMenuCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param string $menuCode
     * @param bool $onlyActive
     */
    public function __construct(
        private readonly string $menuCode,
        private readonly bool $onlyActive = true
    ) {
    }

    /**
     * @param MenuRepositoryInterface $menuRepository
     * @param MegaMenuProductCountService $productCountService
     * @return void
     */
    public function handle(
        MenuRepositoryInterface $menuRepository,
        MegaMenuProductCountService $productCountService
    ): void {
        $cacheKey = "menu_hierarchy_{$this->menuCode}_" . ($this->onlyActive ? 'active' : 'all');
        
        Cache::forget($cacheKey);

        $menu = Cache::remember($cacheKey, 86400, function () use ($menuRepository, $productCountService) {
            $query = \App\Models\Menu::byCode($this->menuCode);

            if ($this->onlyActive) {
                $query->active();
            }

            $menu = $query->with(['rootItems' => function ($query) {
                if ($this->onlyActive) {
                    $query->active();
                }
                
                $query->with(['children' => function ($childrenQuery) {
                    if ($this->onlyActive) {
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

            if ($menu && $menu->rootItems) {
                $menu->rootItems = $productCountService->attachProductCountsToMenuItems($menu->rootItems);
            }

            return $menu;
        });
    }
}

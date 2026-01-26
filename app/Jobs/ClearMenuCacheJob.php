<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\MenuRepositoryInterface;
use App\Services\MenuHierarchyService;
use App\Services\MenuRenderService;
use App\Services\MegaMenuProductCountService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

final class ClearMenuCacheJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param string|null $menuCode Код меню для очистки. Если null - очищает все меню
     */
    public function __construct(
        private readonly ?string $menuCode = null
    ) {}

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $locales = ['ro', 'ru'];
            $menuRepository = app(MenuRepositoryInterface::class);

            if ($this->menuCode) {
                // Очистка и пересоздание кэша для конкретного меню
                $this->clearMenuCache($this->menuCode, $locales);
                $this->rebuildMenuCache($this->menuCode, $locales);
            } else {
                // Очистка и пересоздание кэша для всех меню
                $menus = $menuRepository->getAllMenus();
                foreach ($menus as $menu) {
                    $this->clearMenuCache($menu->code, $locales);
                    $this->rebuildMenuCache($menu->code, $locales);
                }
            }

            // Очистка кэша подсчета товаров
            $productCountService = app(MegaMenuProductCountService::class);
            $productCountService->clearCache();

            Log::info('Кэш меню успешно очищен и пересоздан', [
                'menu_code' => $this->menuCode ?? 'all',
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка при очистке кэша меню: ' . $e->getMessage(), [
                'menu_code' => $this->menuCode ?? 'all',
                'exception' => $e,
            ]);

            throw $e;
        }
    }

    /**
     * Очистить кэш для конкретного меню
     *
     * @param string $menuCode
     * @param array $locales
     * @return void
     */
    private function clearMenuCache(string $menuCode, array $locales): void
    {
        // Очистка кэша из MenuRepository и MenuHierarchyService
        foreach ($locales as $locale) {
            Cache::forget("menu_hierarchy_{$menuCode}_active_{$locale}");
            Cache::forget("menu_hierarchy_{$menuCode}_all_{$locale}");
        }

        // Очистка кэша из MenuRenderService
        foreach ($locales as $locale) {
            // menu_data
            Cache::forget("menu_data_{$menuCode}_{$locale}");

            // menu_render (различные варианты с разными view и cssClass)
            // Очищаем базовые варианты (без cssClass и с пустым cssClass)
            $views = ['partials.menus.mega-menu', 'partials.menus.mobile-mega-menu'];
            foreach ($views as $view) {
                $viewKey = str_replace('.', '_', $view);
                // Базовый вариант (пустой cssClass)
                Cache::forget("menu_render_{$menuCode}_{$viewKey}_" . md5('') . "_{$locale}");
            }

            // menu_content и menu_mobile_content (базовые варианты)
            Cache::forget("menu_content_{$menuCode}_" . md5('') . "_{$locale}");
            Cache::forget("menu_mobile_content_{$menuCode}_" . md5('') . "_{$locale}");

            // Очистка всех вариантов категорий (itemId может быть любым)
            // Используем более агрессивный подход - очищаем все ключи, начинающиеся с префикса
            // Это работает только если используется Redis или Memcached с поддержкой tags
            // Для других драйверов ключи будут пересозданы при следующем запросе
            $this->clearCacheByPrefix("menu_category_content_{$menuCode}_", $locale);
            $this->clearCacheByPrefix("menu_mobile_category_content_{$menuCode}_", $locale);
            $this->clearCacheByPrefix("menu_render_{$menuCode}_", $locale);
            $this->clearCacheByPrefix("menu_content_{$menuCode}_", $locale);
            $this->clearCacheByPrefix("menu_mobile_content_{$menuCode}_", $locale);
        }
    }

    /**
     * Очистить кэш по префиксу
     * Пытается очистить все ключи, начинающиеся с префикса
     * Работает только для Redis и Memcached
     *
     * @param string $prefix
     * @param string $locale
     * @return void
     */
    private function clearCacheByPrefix(string $prefix, string $locale): void
    {
        $driver = config('cache.default');
        
        if ($driver === 'redis') {
            try {
                $redis = Redis::connection();
                $cachePrefix = config('cache.prefix', '');
                
                $patterns = [
                    $cachePrefix ? "{$cachePrefix}:{$prefix}*_{$locale}" : "{$prefix}*_{$locale}",
                    $cachePrefix ? "{$cachePrefix}:{$prefix}*_{$locale}*" : "{$prefix}*_{$locale}*",
                ];
                
                foreach ($patterns as $pattern) {
                    $keys = $redis->keys($pattern);
                    
                    if (!empty($keys)) {
                        if (is_array($keys)) {
                            $redis->del($keys);
                        } else {
                            $redis->del([$keys]);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Не удалось очистить кэш по префиксу через Redis', [
                    'prefix' => $prefix,
                    'locale' => $locale,
                    'error' => $e->getMessage(),
                ]);
            }
        } else {
            Log::debug('Очистка кэша по префиксу поддерживается только для Redis', [
                'driver' => $driver,
                'prefix' => $prefix,
                'locale' => $locale,
            ]);
        }
    }

    /**
     * Пересоздать кэш для конкретного меню
     *
     * @param string $menuCode
     * @param array $locales
     * @return void
     */
    private function rebuildMenuCache(string $menuCode, array $locales): void
    {
        $menuRepository = app(MenuRepositoryInterface::class);
        $menuHierarchyService = app(MenuHierarchyService::class);
        $menuRenderService = app(MenuRenderService::class);

        foreach ($locales as $locale) {
            App::setLocale($locale);

            try {
                $menuRepository->getMenuHierarchyByCode($menuCode, true);
                $menuRepository->getMenuHierarchyByCode($menuCode, false);

                $menuHierarchyService->getMenuHierarchy($menuCode, true);
                $menuHierarchyService->getMenuHierarchy($menuCode, false);

                $menuRenderService->getMenuData($menuCode);
                $menuRenderService->renderContent($menuCode);
                $menuRenderService->renderMobileContent($menuCode);
                $menuRenderService->render($menuCode, '', 'partials.menus.mega-menu');
                $menuRenderService->render($menuCode, '', 'partials.menus.mobile-mega-menu');

                $menu = $menuRepository->getMenuHierarchyByCode($menuCode, true);
                if ($menu && $menu->rootItems) {
                    $this->rebuildCategoryCache($menu->rootItems, $menuCode, $menuRenderService);
                }
            } catch (\Exception $e) {
                Log::warning('Ошибка при пересоздании кэша меню', [
                    'menu_code' => $menuCode,
                    'locale' => $locale,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        App::setLocale(config('app.locale', 'ru'));
    }

    /**
     * Пересоздать кэш категорий рекурсивно
     *
     * @param \Illuminate\Support\Collection $items
     * @param string $menuCode
     * @param MenuRenderService $menuRenderService
     * @return void
     */
    private function rebuildCategoryCache($items, string $menuCode, MenuRenderService $menuRenderService): void
    {
        foreach ($items as $item) {
            if ($item->children && $item->children->isNotEmpty()) {
                try {
                    $menuRenderService->renderCategoryContent($item->id, $menuCode);
                    $menuRenderService->renderMobileCategoryContent($item->id, $menuCode);
                } catch (\Exception $e) {
                    Log::warning('Ошибка при пересоздании кэша категории', [
                        'menu_code' => $menuCode,
                        'item_id' => $item->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                $this->rebuildCategoryCache($item->children, $menuCode, $menuRenderService);
            }
        }
    }
}

<?php

namespace App\Providers\Theme;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class PropertyServiceProvider extends ServiceProvider
{
    private const CACHE_KEY = 'theme_parent_categories';
    private const CACHE_TTL = 7200;

    /**
     * @return void
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function($view)
        {
            static $categories = null;
            static $loaded = false;

            $viewName = $view->getName();
            $needsCategories = str_starts_with($viewName, 'frontend.v1.header')
                || $viewName === 'frontend.v1.pages.shop.parts.catalog'
                || str_contains($viewName, 'header-search')
                || str_contains($viewName, 'mobile-catalog')
                || str_contains($viewName, 'header-catalog-item');

            if ($needsCategories && !$loaded) {
                $categories = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
                    return Category::where(['parent_id' => null, 'status' => true])
                        ->select('id', 'onec_id', 'parent_id', 'name', 'order', 'catalog_order', 'status')
                        ->with(['children' => function ($query) {
                            $query->where('status', true)
                                ->select('id', 'onec_id', 'parent_id', 'name', 'order', 'catalog_order', 'status')
                                ->orderBy('order')
                                ->with(['children' => function ($query) {
                                    $query->where('status', true)
                                        ->select('id', 'onec_id', 'parent_id', 'name', 'order', 'catalog_order', 'status')
                                        ->orderBy('order');
                                }]);
                        }])
                        ->orderBy('order')
                        ->get();
                });
                $loaded = true;
            }

            if ($needsCategories && $categories) {
                $view->with(['themeParentCategories' => $categories]);
            }
        });
    }
}

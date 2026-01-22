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
    private const CACHE_TTL = 3600;

    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('*', function($view)
        {
            $themeParentCategories = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
                return Category::where(['parent_id'=> null,'status'=> true])->orderBy('order')->get();
            });
            $view->with(['themeParentCategories' => $themeParentCategories]);
        });
    }
}

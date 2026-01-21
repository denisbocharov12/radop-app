<?php

namespace App\Providers\Theme;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class PropertyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('*', function($view)
        {
            $themeParentCategories = Category::where(['parent_id'=> null,'status'=> true])->orderBy('order')->lazy();
            $view->with(['themeParentCategories' => $themeParentCategories]);
        });
    }
}

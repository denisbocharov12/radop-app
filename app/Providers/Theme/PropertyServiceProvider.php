<?php

namespace App\Providers\Theme;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class PropertyServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('*', function($view)
        {
            $themeParentCategories = Category::where(['parent_id' => null, 'status' => true])
                ->with([
                    'media',
                    'children.media',
                    'children.children.media',
                    'children.children',
                    'children',
                ])
                ->orderBy('order')
                ->get();
            $view->with(['themeParentCategories' => $themeParentCategories]);
        });
    }
}

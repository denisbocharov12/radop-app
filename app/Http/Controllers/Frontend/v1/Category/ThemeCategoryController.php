<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Category;

use App\Exceptions\Category\CategoryNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Theme\Category\ThemeCategoryManager;
use Illuminate\Http\Request;

final class ThemeCategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly ProductRepository $productRepository,
        private readonly ThemeCategoryManager $themeCategoryManager,
    )
    {
    }

    public function index(Request $request, string $onecId)
    {
        $existedCategory = $this->categoryRepository->getByOnecId($onecId);

        if ($existedCategory === null) {
            throw new CategoryNotFoundValidationException();
        }

        $breadcrumbs = $this->themeCategoryManager->getBreadcrumbsForCategory($existedCategory);

        return view('frontend.v1.pages.category.index', compact([
            'existedCategory',
            'breadcrumbs'
        ]));
    }

}

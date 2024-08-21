<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Category;

use App\Exceptions\Category\CategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
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
        private readonly BrandRepository $brandRepository,
        private readonly AttributeRepository $attributeRepository,
    )
    {
    }

    public function index(Request $request, string $onecId)
    {
        $query = $request->query('filter');

        $existedCategory = $this->categoryRepository->getByOnecId($onecId);

        if ($existedCategory === null) {
            throw new CategoryNotFoundException();
        }

        $products = $this->categoryRepository->getAllPaginatedWithFiltersToFrontEnd($existedCategory);

        $breadcrumbs = $this->themeCategoryManager->getBreadcrumbsForCategory($existedCategory);
        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllByCategoryId($existedCategory->onec_id);

        return view('frontend.v1.pages.category.index', compact([
            'existedCategory',
            'products',
            'breadcrumbs',
            'query',
            'brands',
            'attributes'
        ]));
    }
}

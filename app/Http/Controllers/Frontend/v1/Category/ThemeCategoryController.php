<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Category;

use App\Exceptions\Category\ThemeCategoryNotFoundException;
use App\Exports\CategoryExport;
use App\Http\Controllers\Controller;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Theme\Category\ThemeCategoryManager;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * @throws ThemeCategoryNotFoundException
     */
    public function index(Request $request, string $onecId)
    {
        $query = $request->query('filter');

        $existedCategory = $this->categoryRepository->getByOnecId($onecId);

        if ($existedCategory === null) {
            throw new ThemeCategoryNotFoundException();
        }

        $breadcrumbs = $this->themeCategoryManager->getBreadcrumbsForCategory($existedCategory);

        $themeBrands = $this->brandRepository->getLimited();

        if ($existedCategory->children->isNotEmpty()) {
            return view('frontend.v1.pages.category.category', compact([
                'existedCategory',
                'breadcrumbs',
                'themeBrands',
            ]));
        }

        $products = $this->categoryRepository->getAllPaginatedWithFiltersToFrontEnd($existedCategory, $request);
        $productsByCategory = $this->productRepository->getAllProductsByCategory($existedCategory);

        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllByCategoryId($existedCategory->onec_id);

        return view('frontend.v1.pages.category.index', compact([
            'existedCategory',
            'products',
            'productsByCategory',
            'breadcrumbs',
            'query',
            'brands',
            'attributes',
        ]));
    }

    /**
     * @throws ThemeCategoryNotFoundException
     */
    public function export(string $onecId)
    {
        $existedCategory = $this->categoryRepository->getByOnecId($onecId);

        if ($existedCategory === null) {
            throw new ThemeCategoryNotFoundException();
        }

        $products = $this->categoryRepository->getAllByCategoryOnecId($existedCategory);

        return Excel::download(new CategoryExport($products), 'radop_categories_' . $onecId . '.xlsx');
    }
}

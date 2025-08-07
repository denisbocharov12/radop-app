<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Brand;

use App\Exceptions\Brand\BrandNotFoundValidationException;
use App\Exports\BrandExport;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\PageSortSettingRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Theme\Brand\ThemeBrandManager;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

final class ThemeBrandController extends Controller
{
    public function __construct(
        private readonly BrandRepository $brandRepository,
        private readonly ThemeBrandManager $themeBrandManager,
        private readonly AttributeRepository $attributeRepository,
        private readonly ProductRepository $productRepository,
        private readonly PageSortSettingRepository $pageSortSettingRepository,
    ) {
    }

    public function index(Request $request, string $onecId)
    {
        $query = $request->query('filter');

        $existedBrand = $this->brandRepository->getByOnecId($onecId);

        if ($existedBrand === null) {
            throw new BrandNotFoundValidationException();
        }

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForBrandPage();
        $products = $this->brandRepository->getAllPaginatedWithFiltersToFrontEnd($existedBrand, $request, $defaultSort);

        $breadcrumbs = $this->themeBrandManager->getBreadcrumbsForBrand($existedBrand);
        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($existedBrand->products);

        return view('frontend.v1.pages.brand.index', compact([
            'existedBrand',
            'products',
            'breadcrumbs',
            'query',
            'brands',
            'attributes',
            'defaultSort',
        ]));
    }

    public function export(Brand $brand)
    {
        $products = $this->productRepository->getAllByBrandOnceId((int)$brand->onec_id);

        return Excel::download(new BrandExport($products), 'radop_brands_' . $brand->onec_id . '.xlsx');
    }
}

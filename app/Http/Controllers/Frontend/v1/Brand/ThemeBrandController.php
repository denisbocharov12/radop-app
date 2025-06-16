<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Brand;

use App\Excel\Brand\BrandExport;
use App\Exceptions\Brand\BrandNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
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
    )
    {
    }

    public function index(Request $request, string $onecId)
    {
        $query = $request->query('filter');

        $existedBrand = $this->brandRepository->getByOnecId($onecId);

        if ($existedBrand === null) {
            throw new BrandNotFoundValidationException();
        }

        $products = $this->brandRepository->getAllPaginatedWithFiltersToFrontEnd($existedBrand, $request);

        $breadcrumbs = $this->themeBrandManager->getBreadcrumbsForBrand($existedBrand);
        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllByCategoryId($existedBrand->onec_id);

        return view('frontend.v1.pages.brand.index', compact([
            'existedBrand',
            'products',
            'breadcrumbs',
            'query',
            'brands',
            'attributes'
        ]));
    }

    public function export(Brand $brand)
    {
//        dd($brand->onec_id);
        $products = $this->productRepository->getAllByBrandOnceId((int)$brand->onec_id);
//dd($products);
        return Excel::download(new BrandExport($products), 'brands.xlsx');
    }
}

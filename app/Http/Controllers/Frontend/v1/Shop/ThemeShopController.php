<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\PageSortSettingRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use App\Exports\BrandExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PageSortSetting;

final class ThemeShopController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository,
        private readonly AttributeRepository $attributeRepository,
        private readonly PageSortSettingRepository $pageSortSettingRepository,
    ) {
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $products = $this->productRepository->getAllPaginatedWithFiltersToFrontEnd($request);
        $allProducts = $this->productRepository->getAll();
        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllToShop();

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'brands',
            'attributes',
            'allProducts',
        ]));
    }

    public function newProducts(Request $request)
    {
        $query = $request->query('filter');

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForShopPage();
        $products = $this->productRepository->getAllNewProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $allNewProducts = $this->productRepository->getAllNewProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allNewProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allNewProducts);

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'attributes',
            'brands',
            'defaultSort',
        ]));
    }

    public function popularProducts(Request $request)
    {
        $query = $request->query('filter');

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForShopPage();
        $products = $this->productRepository->getAllPopularProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $allPopularProducts = $this->productRepository->getAllPopularProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allPopularProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allPopularProducts);

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'attributes',
            'brands',
            'defaultSort',
        ]));
    }

    public function saleProducts(Request $request)
    {
        $query = $request->query('filter');

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForShopPage();
        $products = $this->productRepository->getAllDiscountProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $allSaleProducts = $this->productRepository->getAllDiscountProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allSaleProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allSaleProducts);

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'attributes',
            'brands',
            'defaultSort',
        ]));
    }

    public function catalog(Request $request)
    {
        return view('frontend.v1.pages.shop.catalog');
    }

    public function exportNewProducts()
    {
        $products = $this->productRepository->getAllNewProducts();
        return Excel::download(new BrandExport($products), 'radop_new_products.xlsx');
    }

    public function exportPopularProducts()
    {
        $products = $this->productRepository->getAllPopularProducts();
        return Excel::download(new BrandExport($products), 'radop_popular_products.xlsx');
    }

    public function exportSaleProducts()
    {
        $products = $this->productRepository->getAllDiscountProducts();
        return Excel::download(new BrandExport($products), 'radop_sale_products.xlsx');
    }
}

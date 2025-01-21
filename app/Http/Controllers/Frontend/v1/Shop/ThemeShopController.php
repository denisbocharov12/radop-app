<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Shop;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

final class ThemeShopController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository,
        private readonly AttributeRepository $attributeRepository,
    )
    {
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $products = $this->productRepository->getAllPaginatedWithFiltersToFrontEnd();
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

        $products = $this->productRepository->getAllNewProductsPaginatedWithFiltersAndSort();
        $allNewProducts = $this->productRepository->getAllNewProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allNewProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allNewProducts);

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'attributes',
            'brands',
        ]));
    }

    public function popularProducts(Request $request)
    {
        $query = $request->query('filter');

        $products = $this->productRepository->getAllPopularProductsPaginatedWithFiltersAndSort();
        $allPopularProducts = $this->productRepository->getAllPopularProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allPopularProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allPopularProducts);

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'attributes',
            'brands',
        ]));
    }

    public function saleProducts(Request $request)
    {
        $query = $request->query('filter');

        $products = $this->productRepository->getAllDiscountProductsPaginatedWithFiltersAndSort();
        $allSaleProducts = $this->productRepository->getAllDiscountProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allSaleProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allSaleProducts);

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'attributes',
            'brands',
        ]));
    }
}

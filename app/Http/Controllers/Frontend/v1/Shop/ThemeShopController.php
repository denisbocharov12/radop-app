<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Shop;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\PageSortSettingRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use App\Exports\BrandExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PageSortSetting;

final class ThemeShopController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository,
        private readonly AttributeRepository $attributeRepository,
        private readonly PageSortSettingRepository $pageSortSettingRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    ) {
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForShopPage();
        $products = $this->productRepository->getAllPaginatedWithFiltersToFrontEnd($request);
        $allProducts = $this->productRepository->getAll();
        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllToShop();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getShopType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.shop.index'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'brands',
            'attributes',
            'allProducts',
            'defaultSort',
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

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getNewProductsType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));
            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());
            SEOMeta::setKeywords($seoKeywords);
            $this->seo()->opengraph()->setUrl(route('theme.shop.new'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

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

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getPopularProductsType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));
            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());
            SEOMeta::setKeywords($seoKeywords);
            $this->seo()->opengraph()->setUrl(route('theme.shop.popular'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

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

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getSaleProductsType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));
            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());
            SEOMeta::setKeywords($seoKeywords);
            $this->seo()->opengraph()->setUrl(route('theme.shop.sale'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

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
        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForShopPage();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getShopCatalogType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));
            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());
            SEOMeta::setKeywords($seoKeywords);
            $this->seo()->opengraph()->setUrl(route('theme.shop.sale'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.shop.catalog', compact([
            'defaultSort',
        ]));
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

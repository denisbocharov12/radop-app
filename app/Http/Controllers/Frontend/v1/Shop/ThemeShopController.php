<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Shop;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Exceptions\Category\CategoryNotFoundValidationException;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\PageSortSettingRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PageSortSetting;
use App\Jobs\GeneratePersonalizedExcelExportJob;
use App\Exceptions\User\UserNoDiscountException;

final class ThemeShopController extends Controller
{
    use SEOTools;

    /**
     * @param ProductRepository $productRepository
     * @param BrandRepository $brandRepository
     * @param AttributeRepository $attributeRepository
     * @param CategoryRepository $categoryRepository
     * @param PageSortSettingRepository $pageSortSettingRepository
     * @param SeoMetaRepository $seoMetaRepository
     * @param PageTypes $pageTypes
     */
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository,
        private readonly AttributeRepository $attributeRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly PageSortSettingRepository $pageSortSettingRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    ) {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function newProducts(Request $request)
    {
        $query = $request->query('filter');

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForNewProductsPage();
        $products = $this->productRepository->getAllNewProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $allNewProducts = $this->productRepository->getAllNewProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allNewProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allNewProducts);
        $categories = $this->categoryRepository->getLastNestedCategoriesWithProductCount($allNewProducts);

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
            'categories',
            'defaultSort',
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function popularProducts(Request $request)
    {
        $query = $request->query('filter');

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForPopularProductsPage();
        $products = $this->productRepository->getAllPopularProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $allPopularProducts = $this->productRepository->getAllPopularProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allPopularProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allPopularProducts);
        $categories = $this->categoryRepository->getLastNestedCategoriesWithProductCount($allPopularProducts);

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
            'categories',
            'defaultSort',
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function saleProducts(Request $request)
    {
        $query = $request->query('filter');

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForSaleProductsPage();
        $products = $this->productRepository->getAllDiscountProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $allSaleProducts = $this->productRepository->getAllDiscountProducts();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($allSaleProducts);
        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allSaleProducts);
        $categories = $this->categoryRepository->getLastNestedCategoriesWithProductCount($allSaleProducts);

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
            'categories',
            'defaultSort',
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportNewProducts()
    {
        $locale = app()->getLocale();
        $fileName = "radop_new_products_new_{$locale}.xlsx";

        if (Storage::disk('export')->exists($fileName)) {
            $url = asset("export/{$fileName}");

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => __('theme.export-file-ready'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('theme.export-file-not-found'),
        ], 404);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportPopularProducts()
    {
        $locale = app()->getLocale();
        $fileName = "radop_popular_products_popular_{$locale}.xlsx";

        if (Storage::disk('export')->exists($fileName)) {
            $url = asset("export/{$fileName}");

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => __('theme.export-file-ready'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('theme.export-file-not-found'),
        ], 404);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportSaleProducts()
    {
        $locale = app()->getLocale();
        $fileName = "radop_sale_products_sale_{$locale}.xlsx";

        if (Storage::disk('export')->exists($fileName)) {
            $url = asset("export/{$fileName}");

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => __('theme.export-file-ready'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('theme.export-file-not-found'),
        ], 404);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportNewProductsPersonalized()
    {
        if (!auth()->guard('user')->check()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.export-auth-required'),
            ], 401);
        }

        $user = auth()->guard('user')->user();

        if (!$user->sale) {
            throw new UserNoDiscountException();
        }

        $products = $this->productRepository->getAllNewProducts();
        
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.export-no-products'),
            ], 404);
        }

        $locale = app()->getLocale();

        GeneratePersonalizedExcelExportJob::dispatch(
            $products,
            'new_products',
            'new',
            $locale,
            $user
        )->onQueue('high');

        return response()->json([
            'success' => true,
            'message' => __('theme.personalized-export-started'),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportPopularProductsPersonalized()
    {
        if (!auth()->guard('user')->check()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.export-auth-required'),
            ], 401);
        }

        $user = auth()->guard('user')->user();

        if (!$user->sale) {
            throw new UserNoDiscountException();
        }

        $products = $this->productRepository->getAllPopularProducts();
        
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.export-no-products'),
            ], 404);
        }

        $locale = app()->getLocale();

        GeneratePersonalizedExcelExportJob::dispatch(
            $products,
            'popular_products',
            'popular',
            $locale,
            $user
        )->onQueue('high');

        return response()->json([
            'success' => true,
            'message' => __('theme.personalized-export-started'),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportSaleProductsPersonalized()
    {
        if (!auth()->guard('user')->check()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.export-auth-required'),
            ], 401);
        }

        $user = auth()->guard('user')->user();

        if (!$user->sale) {
            throw new UserNoDiscountException();
        }

        $products = $this->productRepository->getAllDiscountProducts();
        
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.export-no-products'),
            ], 404);
        }

        $locale = app()->getLocale();

        GeneratePersonalizedExcelExportJob::dispatch(
            $products,
            'sale_products', 
            'sale',
            $locale,
            $user
        )->onQueue('high');

        return response()->json([
            'success' => true,
            'message' => __('theme.personalized-export-started'),
        ]);
    }

    /**
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterByCategory(Request $request, string $type)
    {
        $categoryId = $request->input('category_id');
        
        if ($categoryId === null) {
            throw new CategoryNotFoundValidationException();
        }
        
        $category = $this->categoryRepository->getByOnecId($categoryId);
        
        if ($category === null) {
            throw new CategoryNotFoundValidationException();
        }
        
        $existingFilters = $request->input('filter', []);
        $existingFilters['category'] = $categoryId;
        $request->merge(['filter' => $existingFilters]);
        
        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForShopPage();
        
        if ($type === 'new') {
            $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForNewProductsPage();
            $products = $this->productRepository->getAllNewProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        } elseif ($type === 'popular') {
            $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForPopularProductsPage();
            $products = $this->productRepository->getAllPopularProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        } elseif ($type === 'sale') {
            $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForSaleProductsPage();
            $products = $this->productRepository->getAllDiscountProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        } else {
            $products = $this->productRepository->getAllPaginatedWithFiltersToFrontEnd($request);
        }

        $tableView = view('frontend.v1.pages.brand.parts.list', compact('products'))->render();
        $listView = view('frontend.v1.pages.brand.parts.list-view', compact('products'))->render();

        $pagination = '';
        if ($products->hasPages()) {
            $pagination = $products->appends(request()->except('page'))->links()->render();
        }

        return response()->json([
            'success' => true,
            'tableView' => $tableView,
            'listView' => $listView,
            'pagination' => $pagination,
            'hasPages' => $products->hasPages(),
        ]);
    }
}

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
use App\Jobs\WarmShopFilterCountsJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
        $requestStart = microtime(true);
        $query = $request->query('filter');
        $locale = app()->getLocale();
        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForNewProductsPage();

        $t0 = microtime(true);
        $products = $this->productRepository->getAllNewProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $productsMs = round((microtime(true) - $t0) * 1000);

        $t0 = microtime(true);
        $filters = $this->getCachedShopFilters('new', $locale);
        $filtersMs = round((microtime(true) - $t0) * 1000);

        $this->applySeoForShopPage(
            $this->pageTypes->getNewProductsType(),
            $locale,
            route('theme.shop.new')
        );

        $totalMs = round((microtime(true) - $requestStart) * 1000);
        Log::info('[Shop] newProducts', [
            'page' => $request->input('page', 1),
            'products_ms' => $productsMs,
            'filters_ms' => $filtersMs,
            'total_ms' => $totalMs,
        ]);

        return view('frontend.v1.pages.shop.index', array_merge(
            compact('products', 'query', 'defaultSort'),
            $filters
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function popularProducts(Request $request)
    {
        $query = $request->query('filter');
        $locale = app()->getLocale();
        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForPopularProductsPage();
        $products = $this->productRepository->getAllPopularProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $filters = $this->getCachedShopFilters('popular', $locale);

        $this->applySeoForShopPage(
            $this->pageTypes->getPopularProductsType(),
            $locale,
            route('theme.shop.popular')
        );

        return view('frontend.v1.pages.shop.index', array_merge(
            compact('products', 'query', 'defaultSort'),
            $filters
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function saleProducts(Request $request)
    {
        $requestStart = microtime(true);
        $query = $request->query('filter');
        $locale = app()->getLocale();
        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForSaleProductsPage();

        $t0 = microtime(true);
        $products = $this->productRepository->getAllDiscountProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $productsMs = round((microtime(true) - $t0) * 1000);

        $t0 = microtime(true);
        $filters = $this->getCachedShopFilters('sale', $locale);
        $filtersMs = round((microtime(true) - $t0) * 1000);

        $this->applySeoForShopPage(
            $this->pageTypes->getSaleProductsType(),
            $locale,
            route('theme.shop.sale')
        );

        $totalMs = round((microtime(true) - $requestStart) * 1000);
        Log::info('[Shop] saleProducts', [
            'page' => $request->input('page', 1),
            'products_ms' => $productsMs,
            'filters_ms' => $filtersMs,
            'total_ms' => $totalMs,
        ]);

        return view('frontend.v1.pages.shop.index', array_merge(
            compact('products', 'query', 'defaultSort'),
            $filters
        ));
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
        if (config('filter_ajax.version', 'v1') !== 'v2') {
            abort(404);
        }

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
            'currentPage' => $products->currentPage(),
            'lastPage' => $products->lastPage(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request, string $type): \Illuminate\Http\JsonResponse
    {
        $requestStart = microtime(true);

        if (config('filter_ajax.version', 'v1') !== 'v2') {
            abort(404);
        }

        try {
            $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForShopPage();

            $t0 = microtime(true);
            if ($type === 'new') {
                $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForNewProductsPage();
                $products = $this->productRepository->getAllNewProductsPaginatedWithFiltersAndSort($request, $defaultSort);
                $productOnecIds = $this->productRepository->getNewProductOnecIds();
            } elseif ($type === 'popular') {
                $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForPopularProductsPage();
                $products = $this->productRepository->getAllPopularProductsPaginatedWithFiltersAndSort($request, $defaultSort);
                $productOnecIds = $this->productRepository->getPopularProductOnecIds();
            } elseif ($type === 'sale') {
                $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForSaleProductsPage();
                $products = $this->productRepository->getAllDiscountProductsPaginatedWithFiltersAndSort($request, $defaultSort);
                $productOnecIds = $this->productRepository->getDiscountProductOnecIds();
            } else {
                $products = $this->productRepository->getAllPaginatedWithFiltersToFrontEnd($request);
                $productOnecIds = [];
            }
            $productsMs = round((microtime(true) - $t0) * 1000);

            $categoryCounts = [];
            $brandCounts = [];
            $attributeCounts = [];
            $countsCacheHit = false;
            $countsMs = 0;

            if ($productOnecIds !== []) {
                $t0 = microtime(true);
                $countsCacheKey = 'theme_shop_filter_counts_' . $type . '_' . app()->getLocale();
                $cachedCounts = Cache::get($countsCacheKey);

                if ($cachedCounts !== null) {
                    $categoryCounts = $cachedCounts['categoryCounts'] ?? [];
                    $brandCounts = $cachedCounts['brandCounts'] ?? [];
                    $attributeCounts = $cachedCounts['attributeCounts'] ?? [];
                    $countsCacheHit = true;
                } else {
                    WarmShopFilterCountsJob::dispatch($type, app()->getLocale())->onQueue('default');
                }
                $countsMs = round((microtime(true) - $t0) * 1000);
            }

            $t0 = microtime(true);
            $tableView = view('frontend.v1.pages.brand.parts.list', compact('products'))->render();
            $listView = view('frontend.v1.pages.brand.parts.list-view', compact('products'))->render();

            $pagination = '';
            if ($products->hasPages()) {
                $pagination = $products->appends($request->except('page'))->links()->render();
            }
            $viewsMs = round((microtime(true) - $t0) * 1000);

            $totalMs = round((microtime(true) - $requestStart) * 1000);
            Log::info('[Shop] filter', [
                'type' => $type,
                'page' => $request->input('page', 1),
                'products_ms' => $productsMs,
                'counts_cache_hit' => $countsCacheHit,
                'counts_ms' => $countsMs,
                'views_ms' => $viewsMs,
                'total_ms' => $totalMs,
            ]);

            return response()->json([
                'success' => true,
                'tableView' => $tableView,
                'listView' => $listView,
                'pagination' => $pagination,
                'hasPages' => $products->hasPages(),
                'currentPage' => $products->currentPage(),
                'lastPage' => $products->lastPage(),
                'filtersCounts' => [
                    'categories' => $categoryCounts,
                    'attributes' => $attributeCounts,
                    'brands' => $brandCounts,
                ],
            ]);
        } catch (\Throwable $e) {
            $totalMs = round((microtime(true) - $requestStart) * 1000);
            Log::error('[Shop] filter error', [
                'type' => $type,
                'page' => $request->input('page', 1),
                'total_ms' => $totalMs,
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    /**
     * @param string $type
     * @param string $locale
     * @return array{attributes: array|null, brands: \Illuminate\Support\Collection, categories: \Illuminate\Support\Collection}
     */
    private function getCachedShopFilters(string $type, string $locale): array
    {
        $cacheKey = "theme_shop_filters_{$type}_{$locale}";

        return Cache::remember($cacheKey, 7200, function () use ($type, $locale) {
            $closureStart = microtime(true);
            Log::info('[Shop] getCachedShopFilters cache miss', ['type' => $type, 'locale' => $locale]);

            $productOnecIds = match ($type) {
                'new' => $this->productRepository->getNewProductOnecIds(),
                'popular' => $this->productRepository->getPopularProductOnecIds(),
                'sale' => $this->productRepository->getDiscountProductOnecIds(),
                default => [],
            };

            $t0 = microtime(true);
            $attributes = $this->attributeRepository->getAllAttributesByProductOnecIdsToFrontEnd($productOnecIds);
            $brands = $this->brandRepository->getAllBrandsByProductOnecIdsToFrontEnd($productOnecIds);
            $categories = $this->categoryRepository->getLastNestedCategoriesWithProductCountByOnecIds($productOnecIds);
            $filtersMs = round((microtime(true) - $t0) * 1000);

            $totalMs = round((microtime(true) - $closureStart) * 1000);
            Log::info('[Shop] getCachedShopFilters built', [
                'type' => $type,
                'locale' => $locale,
                'filters_ms' => $filtersMs,
                'total_ms' => $totalMs,
            ]);

            return [
                'attributes' => $attributes,
                'brands' => $brands,
                'categories' => $categories,
            ];
        });
    }

    /**
     * @param string $pageType
     * @param string $locale
     * @param string $url
     */
    private function applySeoForShopPage(string $pageType, string $locale, string $url): void
    {
        $seo = $this->seoMetaRepository->getStatic($pageType, $locale);

        if ($seo === null) {
            return;
        }

        $this->seo()->setTitle($seo->title ?? trans('seo.title', [], $locale));
        $this->seo()->setDescription($seo->description ?? trans('seo.description', [], $locale));
        $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));
        $seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], $locale);
        SEOMeta::setKeywords((array) $seoKeywords);
        $this->seo()->opengraph()->setUrl($url);
        $this->seo()->opengraph()->addProperty('type', 'page');
        $this->seo()->jsonLd()->setType('WebPage');
    }
}

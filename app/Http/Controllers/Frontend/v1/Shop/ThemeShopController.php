<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Shop;

use App\Support\Catalog\FacetProductIds;
use App\Support\Catalog\PriceBounds;
use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Services\Analytics\Ga4EcommercePayloadBuilder;
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
     * @param Ga4EcommercePayloadBuilder $ga4EcommercePayloadBuilder
     */
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository,
        private readonly AttributeRepository $attributeRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly PageSortSettingRepository $pageSortSettingRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
        private readonly Ga4EcommercePayloadBuilder $ga4EcommercePayloadBuilder,
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

        // Количество товаров у значений фильтра; группы с выбором — без своего условия (ТЗ 49).
        $filteredProductIds = $this->productRepository->getFilteredProductOnecIdsToFrontEnd($request);
        $facetProductIds = FacetProductIds::forSelectedGroups(
            $request,
            fn (Request $scoped) => $this->productRepository->getFilteredProductOnecIdsToFrontEnd($scoped)
        );
        $priceBounds = PriceBounds::for(
            $this->productRepository->getFilteredProductOnecIdsToFrontEnd(
                FacetProductIds::requestWithoutGroup($request, 'price')
            )
        );
        $brandCounts = $this->brandRepository->getBrandProductCounts(
            $brands,
            $facetProductIds['brand'] ?? $filteredProductIds
        );

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

        $ga4ItemList = $this->ga4EcommercePayloadBuilder->buildViewItemListFromPaginator($products, 'shop', 'Shop');
        $ga4ItemLists = $ga4ItemList !== null ? [$ga4ItemList] : [];

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'brands',
            'brandCounts',
            'attributes',
            'filteredProductIds',
            'facetProductIds',
            'priceBounds',
            'allProducts',
            'defaultSort',
            'ga4ItemLists',
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function newProducts(Request $request)
    {
        $query = $request->query('filter');
        $locale = app()->getLocale();
        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForNewProductsPage();
        $products = $this->productRepository->getAllNewProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $filters = $this->getCachedShopFilters('new', $locale);

        $this->applySeoForShopPage(
            $this->pageTypes->getNewProductsType(),
            $locale,
            route('theme.shop.new')
        );

        $ga4ItemList = $this->ga4EcommercePayloadBuilder->buildViewItemListFromPaginator($products, 'shop_new', 'Shop new');
        $ga4ItemLists = $ga4ItemList !== null ? [$ga4ItemList] : [];

        return view('frontend.v1.pages.shop.index', array_merge(
            compact('products', 'query', 'defaultSort', 'ga4ItemLists'),
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

        $ga4ItemList = $this->ga4EcommercePayloadBuilder->buildViewItemListFromPaginator($products, 'shop_popular', 'Shop popular');
        $ga4ItemLists = $ga4ItemList !== null ? [$ga4ItemList] : [];

        return view('frontend.v1.pages.shop.index', array_merge(
            compact('products', 'query', 'defaultSort', 'ga4ItemLists'),
            $filters
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function saleProducts(Request $request)
    {
        $query = $request->query('filter');
        $locale = app()->getLocale();
        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForSaleProductsPage();
        $products = $this->productRepository->getAllDiscountProductsPaginatedWithFiltersAndSort($request, $defaultSort);
        $filters = $this->getCachedShopFilters('sale', $locale);

        $this->applySeoForShopPage(
            $this->pageTypes->getSaleProductsType(),
            $locale,
            route('theme.shop.sale')
        );

        $ga4ItemList = $this->ga4EcommercePayloadBuilder->buildViewItemListFromPaginator($products, 'shop_sale', 'Shop sale');
        $ga4ItemLists = $ga4ItemList !== null ? [$ga4ItemList] : [];

        return view('frontend.v1.pages.shop.index', array_merge(
            compact('products', 'query', 'defaultSort', 'ga4ItemLists'),
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

        $categoryIdInput = $request->input('category_id');

        if ($categoryIdInput === null || $categoryIdInput === '') {
            throw new CategoryNotFoundValidationException();
        }

        $categoryIds = is_array($categoryIdInput)
            ? array_values(array_filter($categoryIdInput))
            : array_values(array_filter(explode(',', (string) $categoryIdInput)));

        if ($categoryIds === []) {
            throw new CategoryNotFoundValidationException();
        }

        foreach ($categoryIds as $cid) {
            if ($this->categoryRepository->getByOnecId($cid) === null) {
                throw new CategoryNotFoundValidationException();
            }
        }

        $existingFilters = $request->input('filter', []);
        $existingFilters['category'] = count($categoryIds) === 1 ? $categoryIds[0] : $categoryIds;
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
        if (config('filter_ajax.version', 'v1') !== 'v2') {
            abort(404);
        }

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForShopPage();

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

        $categoryCounts = [];
        $brandCounts = [];
        $attributeCounts = [];

        if ($productOnecIds !== []) {
            $countsCacheKey = 'theme_shop_filter_counts_' . $type . '_' . app()->getLocale();
            $cachedCounts = Cache::get($countsCacheKey);

            if ($cachedCounts !== null) {
                $categoryCounts = $cachedCounts['categoryCounts'] ?? [];
                $brandCounts = $cachedCounts['brandCounts'] ?? [];
                $attributeCounts = $cachedCounts['attributeCounts'] ?? [];
            } else {
                WarmShopFilterCountsJob::dispatch($type, app()->getLocale());
            }
        }

        $tableView = view('frontend.v1.pages.brand.parts.list', compact('products'))->render();
        $listView = view('frontend.v1.pages.brand.parts.list-view', compact('products'))->render();

        $pagination = '';
        if ($products->hasPages()) {
            $pagination = $products->appends($request->except('page'))->links()->render();
        }

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
            $productOnecIds = match ($type) {
                'new' => $this->productRepository->getNewProductOnecIds(),
                'popular' => $this->productRepository->getPopularProductOnecIds(),
                'sale' => $this->productRepository->getDiscountProductOnecIds(),
                default => [],
            };

            $attributes = $this->attributeRepository->getAllAttributesByProductOnecIdsToFrontEndSorted($productOnecIds);
            $brands = $this->brandRepository->getAllBrandsByProductOnecIdsToFrontEnd($productOnecIds);
            $categories = $this->categoryRepository->getLastNestedCategoriesWithProductCountByOnecIds($productOnecIds, $locale);

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

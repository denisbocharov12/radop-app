<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Category;

use App\Support\Catalog\FacetProductIds;
use App\Enums\PageTypes;
use App\Exceptions\Category\CategoryNotFoundValidationException;
use App\Exceptions\Category\ThemeCategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\PageSortSettingRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Analytics\Ga4EcommercePayloadBuilder;
use App\Services\Seo\SeoFallbackGenerator;
use App\Services\Theme\Category\ThemeCategoryManager;
use App\Services\ViewCount\ViewCountManager;
use App\Jobs\GeneratePersonalizedExcelExportJob;
use App\Exceptions\User\UserNoDiscountException;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

final class ThemeCategoryController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly ProductRepository $productRepository,
        private readonly ThemeCategoryManager $themeCategoryManager,
        private readonly BrandRepository $brandRepository,
        private readonly AttributeRepository $attributeRepository,
        private readonly PageSortSettingRepository $pageSortSettingRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
        private readonly ViewCountManager $viewCountManager,
        private readonly Ga4EcommercePayloadBuilder $ga4EcommercePayloadBuilder,
        private readonly SeoFallbackGenerator $seoFallback,
    ) {
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

        $locale = app()->getLocale();
        $seo = $this->seoMetaRepository->get($this->pageTypes->getCategoryType(), (string)$existedCategory->onec_id, $locale);

        $seoTitle = ($seo?->title !== null && $seo->title !== '')
            ? $seo->title
            : $this->seoFallback->categoryTitle($existedCategory, $locale);
        $seoDescription = ($seo?->description !== null && $seo->description !== '')
            ? $seo->description
            : $this->seoFallback->categoryDescription($existedCategory, $locale);

        $this->seo()->setTitle($seoTitle);
        $this->seo()->setDescription($seoDescription);

        $seoContent = is_string($seo?->content) && trim($seo->content) !== '' ? $seo->content : null;

        $imageUrl = config('seotools.meta.defaults.default_image');

        if ($seo !== null) {
            if ($seo->hasMedia('files')) {
                $imageUrl = $seo->getFirstMediaUrl('files');
            } else {
                $imageUrl = $existedCategory->getFirstMediaUrl('media') ?: config('seotools.meta.defaults.default_image');
            }
        } else {
            if ($existedCategory->hasMedia('media')) {
                $imageUrl = $existedCategory->getFirstMediaUrl('media');
            }
        }

        $this->seo()->addImages($imageUrl);

        $this->seo()->opengraph()->setUrl(route('theme.category.index', $existedCategory->onec_id));
        $this->seo()->opengraph()->addProperty('type', 'category');
        $this->seo()->jsonLd()->setType('CollectionPage');
        $this->seo()->jsonLd()->setTitle($seoTitle);
        $this->seo()->jsonLd()->setDescription($seoDescription);
        $this->seo()->jsonLd()->setUrl(route('theme.category.index', $existedCategory->onec_id));

        $this->viewCountManager->incrementCategoryViewCount($existedCategory, $request);

        if ($existedCategory->children->isNotEmpty()) {
            $existedCategory->load(['childrenOrderedByColumn.childrenOrderedByColumn']);

            return view('frontend.v1.pages.category.category', compact([
                'existedCategory',
                'breadcrumbs',
                'themeBrands',
            ]));
        }

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForCategoryPage();

        $products = $this->categoryRepository->getAllPaginatedWithFiltersToFrontEnd($existedCategory, $request, $defaultSort);
        $productsByCategory = $this->productRepository->getAllProductsByCategory($existedCategory);

        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllByCategoryIdSortedForFrontEnd($existedCategory->onec_id);
        $filteredProductIds = $this->categoryRepository->getFilteredProductOnecIdsToFrontEnd($existedCategory, $request);
        // Группы, в которых выбор уже сделан, считаются без своего условия (ТЗ 49).
        $facetProductIds = FacetProductIds::forSelectedGroups(
            $request,
            fn (Request $scoped) => $this->categoryRepository->getFilteredProductOnecIdsToFrontEnd($existedCategory, $scoped)
        );
        $brandCounts = $this->brandRepository->getBrandProductCounts(
            $brands,
            $facetProductIds['brand'] ?? $filteredProductIds
        );

        $listId = 'category_' . $existedCategory->onec_id;
        $listName = $this->categoryListDisplayName($existedCategory);
        $ga4ItemList = $this->ga4EcommercePayloadBuilder->buildViewItemListFromPaginator($products, $listId, $listName);
        $ga4ItemLists = $ga4ItemList !== null ? [$ga4ItemList] : [];

        return view('frontend.v1.pages.category.index', compact([
            'existedCategory',
            'products',
            'productsByCategory',
            'breadcrumbs',
            'query',
            'brands',
            'brandCounts',
            'attributes',
            'filteredProductIds',
            'facetProductIds',
            'defaultSort',
            'ga4ItemLists',
            'seoContent',
        ]));
    }

    private function categoryListDisplayName(Category $category): string
    {
        $n = $category->getTranslation('name', app()->getLocale(), false);
        if (is_string($n) && $n !== '') {
            return strip_tags($n);
        }

        return strip_tags((string) $category->name);
    }

    /**
     * @param string $onecId
     * @return \Illuminate\Http\JsonResponse
     * @throws ThemeCategoryNotFoundException
     */
    public function export(string $onecId): JsonResponse
    {
        $existedCategory = $this->categoryRepository->getByOnecId($onecId);

        if ($existedCategory === null) {
            throw new ThemeCategoryNotFoundException();
        }

        $locale = app()->getLocale();
        $isParent = $existedCategory->children()->exists();
        $fileName = $isParent
            ? "radop_categories_grouped_{$onecId}_{$locale}.xlsx"
            : "radop_categories_{$onecId}_{$locale}.xlsx";

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
     * @param string $onecId
     * @return \Illuminate\Http\JsonResponse
     * @throws ThemeCategoryNotFoundException
     */
    public function exportPersonalized(string $onecId)
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

        $existedCategory = $this->categoryRepository->getByOnecId($onecId);

        if ($existedCategory === null) {
            throw new ThemeCategoryNotFoundException();
        }

        $products = $existedCategory->children()->exists()
            ? $this->productRepository->getAllProductsByCategorySubtreeSortedByTitle($existedCategory)
            : $this->productRepository->getAllProductsByCategorySortedByTitle($existedCategory);

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.export-no-products'),
            ], 404);
        }

        $locale = app()->getLocale();

        GeneratePersonalizedExcelExportJob::dispatch(
            $products,
            'categories',
            $onecId,
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
     * @param string $onecId
     * @return \Illuminate\Http\JsonResponse
     * @throws ThemeCategoryNotFoundException
     */
    public function filterByCategory(Request $request, string $onecId): \Illuminate\Http\JsonResponse
    {
        if (config('filter_ajax.version', 'v1') !== 'v2') {
            abort(404);
        }

        $categoryIdInput = $request->input('category_id');

        if ($categoryIdInput !== null && $categoryIdInput !== '') {
            $categoryIds = is_array($categoryIdInput)
                ? array_values(array_filter($categoryIdInput))
                : array_values(array_filter(explode(',', (string) $categoryIdInput)));

            if ($categoryIds !== []) {
                foreach ($categoryIds as $cid) {
                    if ($this->categoryRepository->getByOnecId($cid) === null) {
                        throw new CategoryNotFoundValidationException();
                    }
                }
                $existingFilters = $request->input('filter', []);
                $existingFilters['category'] = count($categoryIds) === 1 ? $categoryIds[0] : $categoryIds;
                $request->merge(['filter' => $existingFilters]);
            }
        }

        return $this->processFilter($request, $onecId);
    }

    /**
     * @param Request $request
     * @param string $onecId
     * @return \Illuminate\Http\JsonResponse
     * @throws ThemeCategoryNotFoundException
     */
    public function filter(Request $request, string $onecId): \Illuminate\Http\JsonResponse
    {
        if (config('filter_ajax.version', 'v1') !== 'v2') {
            abort(404);
        }

        return $this->processFilter($request, $onecId);
    }

    /**
     * @param Request $request
     * @param string $onecId
     * @return \Illuminate\Http\JsonResponse
     * @throws ThemeCategoryNotFoundException
     */
    private function processFilter(Request $request, string $onecId): \Illuminate\Http\JsonResponse
    {
        $existedCategory = $this->categoryRepository->getByOnecId($onecId);

        if ($existedCategory === null) {
            throw new ThemeCategoryNotFoundException();
        }

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForCategoryPage();
        $products = $this->categoryRepository->getAllPaginatedWithFiltersToFrontEnd($existedCategory, $request, $defaultSort);

        $allCategoryProducts = $this->productRepository->getAllProductsByCategory($existedCategory);
        $categories = $this->categoryRepository->getLastNestedCategoriesWithProductCount($allCategoryProducts, app()->getLocale());
        $categoryCounts = $categories->pluck('products_count', 'onec_id')->toArray();

        $brands = $this->brandRepository->getAllBrandsByProductsIdsToFrontEnd($allCategoryProducts);
        $productOnecIds = $allCategoryProducts->pluck('onec_id')->toArray();
        $brandCounts = $this->brandRepository->getBrandProductCounts($brands, $productOnecIds);

        $attributes = $this->attributeRepository->getAllByCategoryIdSortedForFrontEnd($existedCategory->onec_id);
        $attributeCounts = $this->attributeRepository->getAttributeProductCounts($productOnecIds, $attributes);

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

}

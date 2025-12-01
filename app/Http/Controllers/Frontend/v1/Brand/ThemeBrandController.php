<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Brand;

use App\Enums\PageTypes;
use App\Exceptions\Brand\BrandNotFoundValidationException;
use App\Exceptions\Category\CategoryNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\PageSortSettingRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Brand\ThemeBrandManager;
use App\Services\ViewCount\ViewCountManager;
use App\Jobs\GeneratePersonalizedExcelExportJob;
use App\Exceptions\User\UserNoDiscountException;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

final class ThemeBrandController extends Controller
{
    use SEOTools;
    private const PUBLIC_DISK = 'public';

    public function __construct(
        private readonly BrandRepository $brandRepository,
        private readonly ThemeBrandManager $themeBrandManager,
        private readonly AttributeRepository $attributeRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly ProductRepository $productRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
        private readonly PageSortSettingRepository $pageSortSettingRepository,
        private readonly ViewCountManager $viewCountManager,
    ) {
    }

    /**
     * @param Request $request
     * @param string $onecId
     * @return \Illuminate\Contracts\View\View
     * @throws BrandNotFoundValidationException
     */
    public function index(Request $request, string $onecId)
    {
        $query = $request->query('filter');

        $existedBrand = $this->brandRepository->getByOnecId($onecId);

        if ($existedBrand === null) {
            throw new BrandNotFoundValidationException();
        }

        $seo = $this->seoMetaRepository->get($this->pageTypes->getBrandType(), $existedBrand->onec_id, app()->getLocale());

        $this->seo()->setTitle($seo->title ?? $existedBrand->title);
        $this->seo()->setDescription($seo?->description ? $existedBrand->description : trans('seo.description', [], app()->getLocale()));

        $imageUrl = config('seotools.meta.defaults.default_image');

        if ($seo !== null) {
            if ($seo->hasMedia('files')) {
                $imageUrl = $seo->getFirstMediaUrl('files');
            } else {
                $imageUrl = $existedBrand->getFirstMediaUrl('media') ?: config('seotools.meta.defaults.default_image');
            }
        } else {
            if ($existedBrand->hasMedia('media')) {
                $imageUrl = $existedBrand->getFirstMediaUrl('media');
            }
        }

        $this->seo()->addImages($imageUrl);

        (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

        SeoMeta::setKeywords($seoKeywords);

        $this->seo()->opengraph()->setUrl(route('theme.brand.index', $existedBrand->onec_id));
        $this->seo()->opengraph()->addProperty('type', 'articles');
        $this->seo()->jsonLd()->setType('Article');

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForBrandPage();
        $products = $this->brandRepository->getAllPaginatedWithFiltersToFrontEnd($existedBrand, $request, $defaultSort);

        $breadcrumbs = $this->themeBrandManager->getBreadcrumbsForBrand($existedBrand);
        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($existedBrand->products);
        $categories = $this->categoryRepository->getLastNestedCategoriesWithProductCount($existedBrand->products);

        $this->viewCountManager->incrementBrandViewCount($existedBrand, $request);

        return view('frontend.v1.pages.brand.index', compact([
            'existedBrand',
            'products',
            'breadcrumbs',
            'query',
            'brands',
            'attributes',
            'categories',
            'defaultSort',
        ]));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function catalog()
    {
        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForBrandCatalogPage();
        $brands = $this->brandRepository->getAllForCatalog($defaultSort);

        $seo = $this->seoMetaRepository->get($this->pageTypes->getBrandsCatalogType(), null, app()->getLocale());

        $this->seo()->setTitle($seo?->title ?? __('theme.brands-catalog-title'));
        $this->seo()->setDescription($seo?->description ?? __('theme.brands-catalog-description'));

        $imageUrl = config('seotools.meta.defaults.default_image');

        if ($seo !== null) {
            if ($seo->hasMedia('files')) {
                $imageUrl = $seo->getFirstMediaUrl('files');
            }
        }

        $this->seo()->addImages($imageUrl);

        (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

        SEOMeta::setKeywords($seoKeywords);

        $this->seo()->opengraph()->setUrl(route('theme.brand.catalog'));
        $this->seo()->opengraph()->addProperty('type', 'website');
        $this->seo()->jsonLd()->setType('CollectionPage');

        return view('frontend.v1.pages.brand.catalog', compact('brands'));
    }

    /**
     * @param Brand $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function export(Brand $brand)
    {
        $locale = app()->getLocale();
        $fileName = "radop_brands_{$brand->onec_id}_{$locale}.xlsx";

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
     * @param Brand $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportPersonalized(Brand $brand)
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

        $products = $this->productRepository->getAllByBrandOnceId((int)$brand->onec_id);

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => __('theme.export-no-products'),
            ], 404);
        }

        $locale = app()->getLocale();

        GeneratePersonalizedExcelExportJob::dispatch(
            $products,
            'brands',
            $brand->onec_id,
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
     */
    public function filterByCategory(Request $request, string $onecId)
    {
        $categoryId = $request->input('category_id');
        
        if ($categoryId === null) {
            throw new CategoryNotFoundValidationException();
        }
        
        $category = $this->categoryRepository->getByOnecId($categoryId);
        
        if ($category === null) {
            throw new CategoryNotFoundValidationException();
        }
        
        $existedBrand = $this->brandRepository->getByOnecId($onecId);

        if ($existedBrand === null) {
            return response()->json([
                'success' => false,
                'message' => __('theme.brand-not-found'),
            ], 404);
        }

        $existingFilters = $request->input('filter', []);
        $existingFilters['category'] = $categoryId;
        
        $request->merge(['filter' => $existingFilters]);

        $defaultSort = $this->pageSortSettingRepository->getDefaultSortValueForBrandPage();
        $products = $this->brandRepository->getAllPaginatedWithFiltersToFrontEnd($existedBrand, $request, $defaultSort);

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

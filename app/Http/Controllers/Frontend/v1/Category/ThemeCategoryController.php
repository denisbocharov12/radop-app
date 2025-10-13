<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Category;

use App\Enums\PageTypes;
use App\Exceptions\Category\ThemeCategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\PageSortSettingRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Category\ThemeCategoryManager;
use App\Services\ViewCount\ViewCountManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
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

        $seo = $this->seoMetaRepository->get($this->pageTypes->getCategoryType(), (string)$existedCategory->onec_id, app()->getLocale());

        $this->seo()->setTitle($seo->title ?? $existedCategory->name);
        $this->seo()->setDescription($seo?->description ?? strip_tags((string)$existedCategory->summary));

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

        (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

        SEOMeta::setKeywords($seoKeywords);

        $this->seo()->opengraph()->setUrl(route('theme.category.index', $existedCategory->onec_id));
        $this->seo()->opengraph()->addProperty('type', 'category');
        $this->seo()->jsonLd()->setType('Article');

        $this->viewCountManager->incrementCategoryViewCount($existedCategory, $request);

        if ($existedCategory->children->isNotEmpty()) {
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
        $attributes = $this->attributeRepository->getAllByCategoryId($existedCategory->onec_id);

        return view('frontend.v1.pages.category.index', compact([
            'existedCategory',
            'products',
            'productsByCategory',
            'breadcrumbs',
            'query',
            'brands',
            'attributes',
            'defaultSort',
        ]));
    }

    /**
     * @param string $onecId
     * @return \Illuminate\Http\JsonResponse
     * @throws ThemeCategoryNotFoundException
     */
    public function export(string $onecId)
    {
        $existedCategory = $this->categoryRepository->getByOnecId($onecId);

        if ($existedCategory === null) {
            throw new ThemeCategoryNotFoundException();
        }

        $locale = app()->getLocale();
        $fileName = "radop_categories_{$onecId}_{$locale}.xlsx";
        
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
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Brand;

use App\Enums\PageTypes;
use App\Exceptions\Brand\BrandNotFoundValidationException;
use App\Exports\BrandExport;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\PageSortSettingRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Brand\ThemeBrandManager;
use App\Services\ViewCount\ViewCountManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

final class ThemeBrandController extends Controller
{
    use SEOTools;
    private const PUBLIC_DISK = 'public';

    public function __construct(
        private readonly BrandRepository $brandRepository,
        private readonly ThemeBrandManager $themeBrandManager,
        private readonly AttributeRepository $attributeRepository,
        private readonly ProductRepository $productRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
        private readonly PageSortSettingRepository $pageSortSettingRepository,
        private readonly ViewCountManager $viewCountManager,
    ) {
    }

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

        $this->viewCountManager->incrementBrandViewCount($existedBrand, $request);

        return view('frontend.v1.pages.brand.index', compact([
            'existedBrand',
            'products',
            'breadcrumbs',
            'query',
            'brands',
            'attributes',
            'defaultSort',
        ]));
    }

    public function export(Brand $brand)
    {
        $products = $this->productRepository->getAllByBrandOnceId((int)$brand->onec_id);

        return Excel::download(new BrandExport($products), 'radop_brands_' . $brand->onec_id . '.xlsx');
    }
}

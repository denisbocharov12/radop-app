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
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Brand\ThemeBrandManager;
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
    )
    {
    }

    public function index(Request $request, string $onecId)
    {
        $query = $request->query('filter');

        $existedBrand = $this->brandRepository->getByOnecId($onecId);

        if ($existedBrand === null) {
            throw new BrandNotFoundValidationException();
        }

        $seo = $this->seoMetaRepository->get($this->pageTypes->getBrandType(), $existedBrand->onec_id, app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? $existedBrand->title);
            $this->seo()->setDescription($seo->description ?? $existedBrand->description);
            $this->seo()->addImages($seo->getFirstMediaUrl('files') ? $existedBrand->getFirstMediaUrl('media') : config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords === null ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SeoMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.brand.index', $existedBrand->onec_id));
            $this->seo()->opengraph()->addProperty('type', 'articles');
            $this->seo()->jsonLd()->setType('Article');
        }

        $products = $this->brandRepository->getAllPaginatedWithFiltersToFrontEnd($existedBrand, $request);

        $breadcrumbs = $this->themeBrandManager->getBreadcrumbsForBrand($existedBrand);
        $brands = $this->brandRepository->getAllToFrontEnd();
        $attributes = $this->attributeRepository->getAllAttributesByProductsIdsToFrontEnd($existedBrand->products);

        return view('frontend.v1.pages.brand.index', compact([
            'existedBrand',
            'products',
            'breadcrumbs',
            'query',
            'brands',
            'attributes'
        ]));
    }

    public function export(Brand $brand)
    {
        $products = $this->productRepository->getAllByBrandOnceId((int)$brand->onec_id);

        return Excel::download(new BrandExport($products), 'radop_brands_' . $brand->onec_id . '.xlsx');
    }
}

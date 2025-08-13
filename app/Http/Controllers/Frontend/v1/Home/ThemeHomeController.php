<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Home;

use App\Enums\PageTypes;
use App\Enums\ProductConditions;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerSetting;
use App\Repositories\Banner\BannerRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;

final class ThemeHomeController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly BrandRepository $brandRepository,
        private readonly ProductRepository $productRepository,
        private readonly BannerRepository $bannerRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    ) {
    }

    public function index()
    {
        $popularProducts = $this->productRepository->getPopularProductsForHomePage();
        $newProducts = $this->productRepository->getNewProductsForHomePage();
        $discountProducts = $this->productRepository->getDiscountProductsForHomePage();
        $banners = $this->bannerRepository->getAllActiveForFront();
        $locale = app()->getLocale();
        $autoplaySpeed = BannerSetting::first()?->rotation_speed ?? 3000;

        $themeBrands = $this->brandRepository->getLimited();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getHomeType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo->getFirstMediaUrl('files') ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.home'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.home.index', compact([
            'themeBrands',
            'popularProducts',
            'newProducts',
            'discountProducts',
            'banners',
            'locale',
            'autoplaySpeed',
        ]));
    }
}

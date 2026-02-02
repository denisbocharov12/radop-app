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
use Illuminate\Support\Facades\Cache;

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
        $locale = app()->getLocale();
        $cacheKey = 'home_page_autoplay_speed_' . $locale;

        $autoplaySpeed = Cache::remember($cacheKey, now()->addDay(), function () {
            return BannerSetting::first()?->rotation_speed ?? 3000;
        });

        $popularProducts = $this->productRepository->getPopularProductsForHomePage();
        $newProducts = $this->productRepository->getNewProductsForHomePage();
        $discountProducts = $this->productRepository->getDiscountProductsForHomePage();
        $banners = $this->bannerRepository->getAllActiveForFront();
        $themeBrands = $this->brandRepository->getLimited();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getHomeType(), $locale);

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], $locale));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], $locale));
            $this->seo()->addImages($seo->getFirstMediaUrl('files') ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], $locale);

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

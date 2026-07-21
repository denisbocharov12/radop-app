<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Home;

use App\Enums\PageTypes;
use App\Enums\ProductConditions;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerSetting;
use App\Repositories\Banner\BannerRepository;
use App\Services\Analytics\Ga4EcommercePayloadBuilder;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Seo\SeoFallbackGenerator;
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
        private readonly Ga4EcommercePayloadBuilder $ga4EcommercePayloadBuilder,
        private readonly SeoFallbackGenerator $seoFallback,
    ) {
    }

    public function index()
    {
        $locale = app()->getLocale();
        $cacheKey = 'home_page_slider_speeds';

        $speeds = Cache::remember($cacheKey, now()->addDay(), function () {
            $settings = BannerSetting::first();

            return [
                'banner'  => $settings?->rotation_speed ?? 3000,
                'new'     => $settings?->new_slider_speed ?? 3000,
                'popular' => $settings?->popular_slider_speed ?? 3000,
                'sale'    => $settings?->sale_slider_speed ?? 3000,
            ];
        });

        $autoplaySpeed = $speeds['banner'];
        $newSliderSpeed = $speeds['new'];
        $popularSliderSpeed = $speeds['popular'];
        $saleSliderSpeed = $speeds['sale'];

        $popularProducts = $this->productRepository->getPopularProductsForHomePage();
        $newProducts = $this->productRepository->getNewProductsForHomePage();
        $discountProducts = $this->productRepository->getDiscountProductsForHomePage();
        $banners = $this->bannerRepository->getAllActiveForFront();
        $themeBrands = $this->brandRepository->getLimited();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getHomeType(), $locale);

        $title = ($seo?->title !== null && $seo->title !== '')
            ? $seo->title
            : $this->seoFallback->homeTitle($locale);
        $description = ($seo?->description !== null && $seo?->description !== '')
            ? $seo->description
            : $this->seoFallback->homeDescription($locale);

        $this->seo()->setTitle($title);
        $this->seo()->setDescription($description);
        $this->seo()->addImages($seo?->getFirstMediaUrl('files') ?: config('seotools.meta.defaults.default_image'));

        $this->seo()->opengraph()->setUrl(route('theme.home'));
        $this->seo()->opengraph()->addProperty('type', 'page');
        $this->seo()->jsonLd()->setType('WebPage');

        $ga4ItemLists = array_values(array_filter([
            $this->ga4EcommercePayloadBuilder->buildViewItemListFromCollection($popularProducts, 'home_popular', 'Home popular'),
            $this->ga4EcommercePayloadBuilder->buildViewItemListFromCollection($newProducts, 'home_new', 'Home new'),
            $this->ga4EcommercePayloadBuilder->buildViewItemListFromCollection($discountProducts, 'home_sale', 'Home sale'),
        ]));

        return view('frontend.v1.pages.home.index', compact([
            'themeBrands',
            'popularProducts',
            'newProducts',
            'discountProducts',
            'banners',
            'locale',
            'autoplaySpeed',
            'newSliderSpeed',
            'popularSliderSpeed',
            'saleSliderSpeed',
            'ga4ItemLists',
        ]));
    }
}

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
use App\Services\Home\HomeSectionsRenderer;
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
        private readonly HomeSectionsRenderer $homeSections,
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

        // Состав и порядок блоков задаются в админке, а не в шаблоне.
        $homeSections = $this->homeSections->sections();
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

        // Списки для аналитики — по тем же секциям, что увидит посетитель.
        $ga4ItemLists = $homeSections
            ->filter(static fn (array $section) => $section['products']->isNotEmpty())
            ->map(fn (array $section) => $this->ga4EcommercePayloadBuilder->buildViewItemListFromCollection(
                $section['products'],
                (string) ($section['settings']['list_id'] ?? 'home_' . $section['id']),
                (string) ($section['settings']['list_name'] ?? ($section['title'] ?? 'Home')),
            ))
            ->filter()
            ->values()
            ->all();

        return view('frontend.v1.pages.home.index', compact([
            'themeBrands',
            'homeSections',
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

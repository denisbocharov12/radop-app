<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\AboutUs;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\SeoMetaRepository;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;

final class ThemeAboutUsController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly BrandRepository $brandRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    ) {
    }

    public function index()
    {
        $themeBrands = $this->brandRepository->getLimited();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getAboutType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo->getFirstMediaUrl('files') ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.about.index'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.about-us.index', compact([
            'themeBrands',
        ]));
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Search;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeSearchDataMapper;
use App\Http\Requests\Theme\Search\ThemeSearchRequest;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Search\ThemeSearchManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;

final class ThemeSearchController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly ThemeSearchManager $themeSearchManager,
        private readonly ThemeSearchDataMapper $themeSearchDataMapper,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    )
    {
    }

    public function index(ThemeSearchRequest $request)
    {
        $themeSearchData = $this->themeSearchDataMapper->mapFromRequestToNormalized($request);

        $products = $this->themeSearchManager->index($themeSearchData);
        $categories = $this->themeSearchManager->getCategoriesFromQuery($themeSearchData);

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getSearchType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo->getFirstMediaUrl('files') ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.search.index'));
            $this->seo()->opengraph()->addProperty('type', 'search');
            $this->seo()->jsonLd()->setType('SearchResultsPage');
        }

        return view('frontend.v1.pages.search.index', compact([
            'products',
            'themeSearchData',
            'categories'
        ]));
    }
}

<?php

namespace App\Http\Controllers\Frontend\v1\Filial;

use App\Enums\PageTypes;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\ThemeCityNotFoundValidationException;
use App\Exceptions\Filial\FilialNotPermittedToViewException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeFilialDataMapper;
use App\Http\Requests\Theme\Filial\ThemeFilialRequest;
use App\Models\Filial;
use App\Repositories\City\CityRepository;
use App\Repositories\Filial\FilialRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Filial\ThemeFilialManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Auth;

class ThemeFilialController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly ThemeFilialDataMapper $themeFilialDataMapper,
        private readonly FilialRepository $filialRepository,
        private readonly ThemeFilialManager $themeFilialManager,
        private readonly CityRepository $cityRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    ) {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $cities = $this->cityRepository->getAll();

        $filials = $this->filialRepository->getAllByUserId($user->id);

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getFilialType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.user.filial.index'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('CollectionPage');
        }

        return view('frontend.v1.pages.filial.index', compact([
            'filials',
            'user',
            'cities',
        ]));
    }

    public function store(ThemeFilialRequest $request)
    {
        $user = Auth::guard('user')->user();
        $filialData = $this->themeFilialDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeFilialManager->store($filialData, $user);

            return redirect()->route('theme.user.filial.index');

        } catch (CityNotFoundException) {
            throw new ThemeCityNotFoundValidationException();
        } catch (FilialNotPermittedToViewException) {
            return redirect()->back()->withErrors(['user_not_permitted_to_view_filial' => __('theme.user_not_permitted_to_view_filial')]);
        }
    }

    public function update(Filial $filial, ThemeFilialRequest $request)
    {
        $user = Auth::guard('user')->user();

        $filialData = $this->themeFilialDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeFilialManager->update($filial, $filialData, $user);

            return redirect()->route('theme.user.filial.index');

        } catch (FilialNotPermittedToViewException) {
            return redirect()->back()->withErrors(['user_not_permitted_to_view_filial' => __('theme.user_not_permitted_to_view_filial')]);
        } catch (CityNotFoundException) {
            throw new ThemeCityNotFoundValidationException();
        }
    }

    public function edit(Filial $filial)
    {
        $user = Auth::guard('user')->user();

        if (!$user->can('view', $filial)) {
            return redirect()->back()->withErrors(['user_not_permitted_to_view_filial' => __('theme.user_not_permitted_to_view_filial')]);
        }

        $cities = $this->cityRepository->getAll();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getFilialType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.user.filial.edit', $filial));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.filial.edit', compact([
            'filial',
            'cities'
        ]));
    }

    public function create()
    {
        $cities = $this->cityRepository->getAll();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getFilialType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.user.filial.create'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.filial.create', compact(['cities']));
    }

    public function destroy(Filial $filial)
    {

        $user = Auth::guard('user')->user();

        try {
            $this->themeFilialManager->delete($filial, $user);

            return redirect()->route('theme.user.filial.index');
        } catch (FilialNotPermittedToViewException) {
            return redirect()->back()->withErrors(['user_not_permitted_to_delete_filial' => __('theme.user_not_permitted_to_delete_filial')]);
        }
    }
}

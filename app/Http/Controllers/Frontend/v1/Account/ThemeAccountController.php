<?php

namespace App\Http\Controllers\Frontend\v1\Account;

use App\Enums\PageTypes;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\ThemeCityNotFoundValidationException;
use App\Exceptions\User\DuplicatedUserEmailException;
use App\Exceptions\User\DuplicatedUserEmailValidationException;
use App\Exceptions\User\UserNewPasswordDoesNotMatch;
use App\Exceptions\User\UserNewPasswordDoesNotMatchException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\ThemeAccountChangePasswordDataMapper;
use App\Http\Mappers\Theme\ThemeAccountDataMapper;
use App\Http\Requests\Theme\Account\ThemeAccountChangePasswordRequest;
use App\Http\Requests\Theme\Account\ThemeAccountRequest;
use App\Models\User;
use App\Repositories\City\CityRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Account\ThemeAccountManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Auth;

final class ThemeAccountController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly ThemeAccountDataMapper $themeAccountDataMapper,
        private readonly ThemeAccountManager $themeAccountManager,
        private readonly ThemeAccountChangePasswordDataMapper $themeAccountChangePasswordDataMapper,
        private readonly CityRepository $cityRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $cities = $this->cityRepository->getAllSorted();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getAccountType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.user.account.index'));
            $this->seo()->opengraph()->addProperty('type', 'account');
            $this->seo()->jsonLd()->setType('ProfilePage');
        }

        return view('frontend.v1.pages.account.index', compact([
            'user',
            'cities',
        ]));
    }

    public function update(User $user, ThemeAccountRequest $request)
    {
        $clientData = $this->themeAccountDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeAccountManager->update($clientData, $user);

            return redirect()->route('theme.user.account.index');

        } catch (DuplicatedUserEmailException $e) {
            throw new DuplicatedUserEmailValidationException();
        } catch (CityNotFoundException $e) {
            throw new ThemeCityNotFoundValidationException();
        }
    }

    public function changePassword(ThemeAccountChangePasswordRequest $request)
    {
        $user = Auth::guard('user')->user();

        $passwordData = $this->themeAccountChangePasswordDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->themeAccountManager->changePassword($user, $passwordData);

            return redirect()->route('theme.user.account.index')->with('success', __('theme.password_was_updated'));
        } catch (UserNewPasswordDoesNotMatch $e) {
            throw new UserNewPasswordDoesNotMatchException();
        }

    }
}

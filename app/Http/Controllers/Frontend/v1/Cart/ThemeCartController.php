<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Cart;
use App\Enums\ProductConditions;
use App\Enums\PageTypes;
use App\Exceptions\Coupon\CouponMinimalValueException;
use App\Exceptions\Coupon\CouponMinimalValueValidationException;
use App\Exceptions\Coupon\CouponNotFoundException;
use App\Exceptions\Coupon\CouponNotFoundValidationException;
use App\Exceptions\Coupon\CouponOwnerException;
use App\Exceptions\Coupon\CouponOwnerValidationException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserTypeNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\v1\Product\ThemeProductController;
use App\Http\Mappers\Theme\ThemeCouponDataMapper;
use App\Http\Requests\Theme\Coupon\ThemeCouponRequest;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Analytics\Ga4EcommercePayloadBuilder;
use App\Services\Theme\Cart\ThemeCartManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Auth;

final class ThemeCartController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly ThemeCartManager $themeCartManager,
        private readonly ThemeCouponDataMapper $themeCouponDataMapper,
        private readonly ProductRepository $productRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
        private readonly Ga4EcommercePayloadBuilder $ga4EcommercePayloadBuilder,
    )
    {
    }

    public function index()
    {
        $popularProducts = $this->productRepository->getAllPopularProducts();
        $discountProducts = $this->productRepository->getAllDiscountProducts();
        $featuredProducts = $this->productRepository->getAllFeaturedProducts();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getCartType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.cart.index'));
            $this->seo()->opengraph()->addProperty('type', 'cart');
            $this->seo()->jsonLd()->setType('CollectionPage');
        }

        $sessionId = config('shopping_cart.default_session_id');
        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }
        $ga4ViewCart = $this->ga4EcommercePayloadBuilder->buildViewCart($sessionId);

        return view('frontend.v1.pages.cart.index', compact([
            'popularProducts',
            'discountProducts',
            'featuredProducts',
            'ga4ViewCart',
        ]));
    }

    public function coupon(ThemeCouponRequest $request)
    {
        $couponData = $this->themeCouponDataMapper->mapFromRequestToNormalized($request);
        $user = Auth::guard('user')->user();

        try {
            $this->themeCartManager->coupon($couponData, $user);

        } catch (UserNotFoundException) {
            throw new UserTypeNotFoundValidationException();
        } catch (CouponNotFoundException) {
            throw new CouponNotFoundValidationException();
        } catch (CouponMinimalValueException) {
            throw new CouponMinimalValueValidationException();
        } catch (CouponOwnerException) {
            throw new CouponOwnerValidationException();
        }

        toastr()->success('Купон успешно применен!','Успех');
        return redirect()->back();
    }

    public function destroy()
    {
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        \Cart::session($sessionId)->clear();

        return redirect()->route('theme.cart.index');
    }
}

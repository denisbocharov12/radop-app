<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Checkout;

use App\Enums\OrderPaymentMethods;
use App\Events\OrderCreatedSendEmailEvent;
use App\Exceptions\Checkout\ManagerNotFoundException;
use App\Exceptions\Checkout\ManagerNotFoundValidationException;
use App\Exceptions\Checkout\MinOrderSumException;
use App\Exceptions\Checkout\MinOrderSumValidationException;
use App\Exceptions\Checkout\OrderErrorException;
use App\Exceptions\Checkout\OrderErrorValidationException;
use App\Exceptions\City\CityNotFoundException;
use App\Exceptions\City\ThemeCityErrorRequiredSumException;
use App\Exceptions\City\ThemeCityErrorRequiredSumValidationException;
use App\Exceptions\City\ThemeCityNotFoundValidationException;
use App\Exceptions\Order\ThemeOrderMakeException;
use App\Exceptions\Order\ThemeOrderMakeValidationException;
use App\Exceptions\User\UserIsNotAuthenticatedException;
use App\Http\Mappers\Theme\ThemeOrderDataMapper;
use App\Http\Requests\Theme\Checkout\ThemeOrderRequest;
use App\Repositories\City\CityRepository;
use App\Repositories\DeliveryMethod\DeliveryMethodRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Theme\Checkout\ThemeCheckoutManager;
use Illuminate\Support\Facades\Auth;

final class ThemeCheckoutController
{
    public function __construct(
        private readonly ThemeCheckoutManager $themeCheckoutManager,
        private readonly ThemeOrderDataMapper $themeOrderDataMapper,
        private readonly OrderPaymentMethods $orderPaymentMethods,
        private readonly ProductRepository $productRepository,
        private readonly CityRepository $cityRepository,
        private readonly DeliveryMethodRepository $deliveryMethodRepository,
    ) {
    }

    /**
     * @throws UserIsNotAuthenticatedException
     */
    public function index()
    {
        $user = Auth::guard('user')->user();

        if (!$user) {
            throw new UserIsNotAuthenticatedException();
        }

        $userType = $user->type->key_name;
        $paymentMethods = $this->orderPaymentMethods->getAllByUserType($userType);
        $popularProducts = $this->productRepository->getAllPopularProducts();
        $discountProducts = $this->productRepository->getAllDiscountProducts();
        $featuredProducts = $this->productRepository->getAllFeaturedProducts();
        $deliveryMethods = $this->deliveryMethodRepository->getAllActive();
        $cities = $this->cityRepository->getAllSorted();

        return view('frontend.v1.pages.checkout.index', compact([
            'paymentMethods',
            'popularProducts',
            'discountProducts',
            'featuredProducts',
            'deliveryMethods',
            'cities',
            'user',
        ]));
    }

    public function store(ThemeOrderRequest $request)
    {
        $orderData = $this->themeOrderDataMapper->mapFromRequestToNormalized($request);
        $user = Auth::guard('user')->user();

        try {
            $order = $this->themeCheckoutManager->store($orderData, $user);

            event(new OrderCreatedSendEmailEvent($order));

            return redirect()->route('theme.thankyou.index');
        } catch (ManagerNotFoundException) {
            throw new ManagerNotFoundValidationException();
        } catch (OrderErrorException) {
            throw new OrderErrorValidationException();
        } catch (CityNotFoundException) {
            throw new ThemeCityNotFoundValidationException();
        } catch (ThemeCityErrorRequiredSumException) {
            throw new ThemeCityErrorRequiredSumValidationException();
        }  catch (ThemeOrderMakeException) {
            throw new ThemeOrderMakeValidationException();
        } catch (MinOrderSumException) {
            throw new MinOrderSumValidationException();
        }
    }

    public function thank()
    {
        $popularProducts = $this->productRepository->getAllPopularProducts();
        $discountProducts = $this->productRepository->getAllDiscountProducts();
        $featuredProducts = $this->productRepository->getAllFeaturedProducts();

        return view('frontend.v1.pages.thankyou.index', compact([
            'popularProducts',
            'discountProducts',
            'featuredProducts'
        ]));
    }

}

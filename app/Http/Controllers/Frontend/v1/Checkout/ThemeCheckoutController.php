<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Checkout;

use App\Enums\OrderPaymentMethods;
use App\Events\OrderCreatedSendEmailEvent;
use App\Exceptions\Checkout\ManagerNotFoundException;
use App\Exceptions\Checkout\ManagerNotFoundValidationException;
use App\Exceptions\Checkout\OrderErrorException;
use App\Exceptions\Checkout\OrderErrorValidationException;
use App\Http\Mappers\Theme\ThemeOrderDataMapper;
use App\Http\Requests\Theme\Checkout\ThemeOrderRequest;
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
    )
    {
    }

    public function index()
    {
        $paymentMethods = $this->orderPaymentMethods->getAll();
        $popularProducts = $this->productRepository->getAllPopularProducts();
        $discountProducts = $this->productRepository->getAllDiscountProducts();
        $featuredProducts = $this->productRepository->getAllFeaturedProducts();

        return view('frontend.v1.pages.checkout.index', compact([
            'paymentMethods',
            'popularProducts',
            'discountProducts',
            'featuredProducts'
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

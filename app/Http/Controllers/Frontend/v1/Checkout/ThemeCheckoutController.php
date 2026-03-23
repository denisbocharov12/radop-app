<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Checkout;

use App\Enums\OrderPaymentMethods;
use App\Enums\PageTypes;
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
use App\Models\Order;
use App\Models\Product;
use App\Repositories\City\CityRepository;
use App\Repositories\DeliveryMethod\DeliveryMethodRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Checkout\ThemeCheckoutManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class ThemeCheckoutController
{
    use SEOTools;

    public function __construct(
        private readonly ThemeCheckoutManager $themeCheckoutManager,
        private readonly ThemeOrderDataMapper $themeOrderDataMapper,
        private readonly OrderPaymentMethods $orderPaymentMethods,
        private readonly ProductRepository $productRepository,
        private readonly CityRepository $cityRepository,
        private readonly DeliveryMethodRepository $deliveryMethodRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
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

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getCheckoutType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.checkout.index'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        $sessionId = $user->id;
        $ga4Checkout = null;
        if (!\Cart::session($sessionId)->isEmpty()) {
            $ga4Checkout = [
                'currency' => (string) config('analytics.currency', 'MDL'),
                'value' => (float) \Cart::session($sessionId)->getSubTotal(),
                'items' => $this->buildGa4CheckoutCartItems($sessionId),
            ];
        }

        return view('frontend.v1.pages.checkout.index', compact([
            'paymentMethods',
            'popularProducts',
            'discountProducts',
            'featuredProducts',
            'deliveryMethods',
            'cities',
            'user',
            'ga4Checkout',
        ]));
    }

    public function store(ThemeOrderRequest $request)
    {
        $orderData = $this->themeOrderDataMapper->mapFromRequestToNormalized($request);
        $user = Auth::guard('user')->user();

        try {
            $order = $this->themeCheckoutManager->store($orderData, $user);
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

        try {
            event(new OrderCreatedSendEmailEvent($order));
        } catch (\Throwable $e) {
            Log::error('Order created but user confirmation email failed', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
            ]);
        }

        $order->load(['products.product']);
        $request->session()->flash('ga4_purchase', $this->buildGa4PurchasePayload($order));

        return redirect()->route('theme.thankyou.index');
    }

    public function thank()
    {
        $popularProducts = $this->productRepository->getAllPopularProducts();
        $discountProducts = $this->productRepository->getAllDiscountProducts();
        $featuredProducts = $this->productRepository->getAllFeaturedProducts();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getOrderType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.thankyou.index'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.thankyou.index', compact([
            'popularProducts',
            'discountProducts',
            'featuredProducts'
        ]));
    }

    /**
     * @param int|string $sessionId
     * @return list<array<string, mixed>>
     */
    private function buildGa4CheckoutCartItems(int|string $sessionId): array
    {
        $rows = [];
        foreach (\Cart::session($sessionId)->getContent() as $row) {
            $model = $row->associatedModel;
            if (!$model instanceof Product) {
                continue;
            }
            $rows[] = [
                'item_id' => (string) ($model->onec_id ?? $model->id),
                'item_name' => $this->productDisplayName($model),
                'price' => (float) $row->price,
                'quantity' => (int) $row->quantity,
            ];
        }

        return $rows;
    }

    /**
     * @return array<string, mixed>
     */
    private function buildGa4PurchasePayload(Order $order): array
    {
        $order->loadMissing(['products.product']);
        $items = [];
        foreach ($order->products as $line) {
            $p = $line->product;
            $items[] = [
                'item_id' => (string) ($p?->onec_id ?? $line->product_id),
                'item_name' => $p !== null ? $this->productDisplayName($p) : 'item',
                'price' => (float) (string) $line->price,
                'quantity' => (int) $line->quantity,
            ];
        }

        return [
            'transaction_id' => (string) ($order->order_number ?? $order->id),
            'currency' => (string) config('analytics.currency', 'MDL'),
            'value' => (float) (string) $order->total,
            'items' => $items,
        ];
    }

    private function productDisplayName(Product $product): string
    {
        $t = $product->getTranslation('title', app()->getLocale(), false);
        if (is_string($t) && $t !== '') {
            return strip_tags($t);
        }
        $raw = $product->title;
        if (is_string($raw)) {
            return strip_tags($raw);
        }

        return 'item';
    }

}

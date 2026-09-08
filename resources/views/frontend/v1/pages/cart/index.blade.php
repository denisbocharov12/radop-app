@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        use App\Services\Product\ProductImagesManager;
        use App\Services\Theme\Product\ThemeProductManager;
        use Illuminate\Support\Str;

        $user = auth()->guard('user')->user();
        $cartSession = $user ? $user->id : config('shopping_cart.default_session_id');
        $cart = \Cart::session($cartSession);

        $lines = $cart->getContent()
            ->sortBy('attributes.added_at')
            ->map(function ($item) {
                $product = $item->associatedModel;

                $image = $product->hasMedia('products')
                    ? $product->getFirstMediaUrl('products', 'medium')
                    : (ProductImagesManager::getProductImagesFromAbsolutePath($product->onec_id)[0] ?? null);

                if ($image && ! Str::startsWith($image, ['http://', 'https://'])) {
                    $image = config('app.url') . '/' . ltrim($image, '/');
                }

                return [
                    'id' => (int) $item->id,
                    'title' => (string) $product->title,
                    'code' => (string) $product->onec_id,
                    'url' => route('theme.product.index', $product->slug),
                    'image' => $image,
                    'qty' => (int) $item->quantity,
                    'step' => (int) ($product->min_order ?: 1),
                    'stock' => (int) $product->stock,
                    'price' => (float) ThemeProductManager::getProductTotalSum($product),
                ];
            })
            ->values()
            ->all();

        $minOrderSum = $user
            ? ($user->isSupplementWindowOpen() ? 0 : (float) $user->minOrderSum())
            : (float) config('app.min_delivery_sum');

        $props = json_encode([
            'lines' => $lines,
            'total' => number_format($cart->getTotal(), 2, ',', ''),
            'currency' => __('theme.MDL'),
            'minOrderSum' => $minOrderSum,
            'checkoutUrl' => route('theme.checkout.index'),
            'continueUrl' => route('theme.shop.catalog'),
            'destroyUrl' => route('theme.cart.destroy'),
            'authenticated' => $user !== null,
            't' => [
                'code' => __('theme.code'),
                'empty' => __('theme.empty-cart'),
                'remove' => __('theme.cart-destroy'),
                'destroy' => __('theme.cart-destroy'),
                'payable' => __('theme.invoice-payable'),
                'quantity' => __('theme.quantity-shortly'),
                'summary' => __('theme.summary'),
                'forPayment' => __('theme.for-payment'),
                'minOrder' => __('theme.min_order_sum_warning_message'),
                'checkout' => __('theme.place-order'),
                'continue' => __('theme.сontinue-shopping'),
            ],
        ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('theme.cart')]]" />

    <div class="sf-container pb-12">
        <h1 class="mb-5 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">{{ __('theme.cart') }}</h1>

        <div data-sf-island="cart-table" data-sf-props="{{ $props }}" v-cloak>
            {{-- Pre-hydration placeholder keeps the page from jumping. --}}
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
                <div class="space-y-2">
                    @foreach($lines as $line)
                        <div class="sf-skeleton h-20 w-full"></div>
                    @endforeach
                </div>
                <div class="sf-skeleton h-56 w-full"></div>
            </div>
        </div>
    </div>

    {{-- The checkout button carries the legacy `.cart-auth-modal-btn` hook, which
         the shared auth dialog (rendered in the footer for guests) listens for,
         so the page no longer needs its own copy of that modal. --}}
    @include('frontend.v1.pages.cart.parts.tabs')
@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-view-cart')
@endsection

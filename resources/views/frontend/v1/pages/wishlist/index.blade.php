@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        /*
         * ThemeWishListController::add passes the product as the 6th argument
         * of Cart::add, which is `conditions`, not `associatedModel` — the
         * legacy list read `$item->conditions`. Accept either so the page
         * does not render an empty grid for every stored item.
         */
        $products = app('wishlist')->getContent()
            ->sortByDesc('attributes.added_at')
            ->map(static function ($item) {
                foreach ([$item->associatedModel ?? null, $item->conditions ?? null] as $candidate) {
                    if ($candidate instanceof \App\Models\Product) {
                        return $candidate;
                    }
                }

                return \App\Models\Product::query()->find($item->id);
            })
            ->filter()
            ->values();
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('theme.wishlist')]]" />

    <div class="sf-container sf-page-body">
        <div class="mb-5 mt-2 flex flex-wrap items-baseline gap-x-3 gap-y-1 lg:mb-6">
            <h1 class="text-2xl font-bold text-ink-900 lg:text-3xl">{{ __('theme.wishlist') }}</h1>
            @if($products->isNotEmpty())
                <span class="text-sm text-ink-500">
                    <b class="font-semibold text-ink-800">{{ $products->count() }}</b> {{ __('theme.sort-products') }}
                </span>
            @endif
        </div>

        @if($products->isEmpty())
            <div class="mx-auto max-w-md rounded-xl border border-dashed border-ink-200 bg-white px-6 py-12 text-center sm:py-16">
                <span class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                    <x-sf-icon name="heart" :size="30" />
                </span>
                <p class="text-lg font-semibold text-ink-900">{{ __('theme.sf-wishlist-empty') }}</p>
                <p class="mx-auto mt-2 max-w-sm text-sm text-ink-500">{{ __('theme.sf-wishlist-empty-hint') }}</p>
                <a href="{{ route('theme.shop.catalog') }}" class="sf-btn-primary mt-6 inline-flex">
                    <x-sf-icon name="grid" :size="16" />
                    {{ __('theme.go-to-catalog') }}
                </a>
            </div>
        @else
            <div class="sf-grid-products" data-sf-view="grid">
                @foreach($products as $product)
                    <x-sf-product-card
                        :product="$product"
                        list-id="wishlist"
                        list-name="Wishlist"
                    />
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.radopGa4EventPush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                window.radopGa4EventPush(
                    window.radopAnalyticsDataLayerEventNames.wishlist_page_viewed,
                    @json($ga4ViewWishlist ?? ['wishlist_item_count' => 0])
                );
            }
        });
    </script>
@endsection

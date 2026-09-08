@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        $items = app('wishlist')->getContent();
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('theme.wishlist')]]" />

    <div class="sf-container pb-12">
        <h1 class="mb-5 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">{{ __('theme.wishlist') }}</h1>

        @if($items->isEmpty())
            <div class="py-16 text-center">
                <x-sf-icon name="heart" :size="40" class="mx-auto mb-3 text-ink-300" />
                <p class="text-md font-medium text-ink-700">{{ __('theme.found-products') }}</p>
                <p class="mt-2 text-sm text-ink-500">{!! __('theme.not-found-product') !!}</p>
                <a href="{{ route('theme.shop.catalog') }}" class="sf-btn-primary mt-5 inline-flex">
                    {{ __('theme.go-to-catalog') }}
                </a>
            </div>
        @else
            <div class="sf-grid-products">
                @foreach($items as $item)
                    @continue($item->associatedModel === null)
                    <x-sf-product-card
                        :product="$item->associatedModel"
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

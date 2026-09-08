@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        // /shop, /shop/new, /shop/popular and /shop/sale all render this view.
        $heading = match (request()->route()?->getName()) {
            'theme.shop.new' => __('theme.new-products'),
            'theme.shop.popular' => __('theme.popular-products'),
            'theme.shop.sale' => __('theme.on-discount'),
            default => __('theme.shop'),
        };

        $ga4ListId = data_get($ga4ItemLists ?? [], '0.item_list_id', '');
        $ga4ListName = data_get($ga4ItemLists ?? [], '0.item_list_name', '');
    @endphp

    <x-sf-breadcrumbs :items="[['url' => null, 'name' => $heading]]" />

    <x-sf-catalog
        :products="$products"
        :action="url()->current()"
        :default-sort="$defaultSort ?? 'price'"
        :heading="$heading"
    >
        <x-slot:filters>
            <x-sf-catalog-filters
                :action="url()->current()"
                :groups="$attributes ?? []"
                :brands="$brands ?? null"
                :query="$query ?? []"
            />
        </x-slot:filters>

        @foreach($products as $product)
            <x-sf-product-card :product="$product" :list-id="$ga4ListId" :list-name="$ga4ListName" />
        @endforeach
    </x-sf-catalog>
@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-item-lists')
@endsection

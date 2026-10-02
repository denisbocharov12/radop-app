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

        // Excel export exists for the new / popular / sale listings only —
        // the same three the legacy header offered it on.
        $personalizedExport = (bool) auth('user')->user()?->sale;
        $exportRoute = match (request()->route()?->getName()) {
            'theme.shop.new' => 'theme.shop.new.export',
            'theme.shop.popular' => 'theme.shop.popular.export',
            'theme.shop.sale' => 'theme.shop.sale.export',
            default => null,
        };
        $exportUrl = $exportRoute
            ? route($exportRoute . ($personalizedExport ? '.personalized' : ''))
            : null;

        // Same filter set as the old shop sidebar: price, categories, brand.
        // It deliberately skipped every other attribute group — on /shop that
        // is 140 groups — and kept only the "Brand" attribute.
        $shopGroups = collect($attributes ?? [])->only(['Бренд', 'Brand']);

        $ga4ListId = data_get($ga4ItemLists ?? [], '0.item_list_id', '');
        $ga4ListName = data_get($ga4ItemLists ?? [], '0.item_list_name', '');
    @endphp

    <x-sf-breadcrumbs :items="[['url' => null, 'name' => $heading]]" />

    <x-sf-catalog
        :products="$products"
        :action="url()->current()"
        :default-sort="$defaultSort ?? 'price'"
        :heading="$heading"
        :export-url="$exportUrl"
        :export-personalized="$personalizedExport"
    >
        <x-slot:filters>
            <x-sf-catalog-filters
                :action="url()->current()"
                :groups="$shopGroups"
                :brands="$brands ?? null"
                :brand-counts="$brandCounts ?? []"
                :categories="$categories ?? null"
                :filtered-ids="$filteredProductIds ?? null"
                :facet-ids="$facetProductIds ?? []"
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

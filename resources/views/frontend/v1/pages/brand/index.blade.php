@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        $ga4ListId = data_get($ga4ItemLists ?? [], '0.item_list_id', '');
        $ga4ListName = data_get($ga4ItemLists ?? [], '0.item_list_name', '');
    @endphp

    <x-sf-breadcrumbs :items="collect($breadcrumbs ?? [])->push(['url' => null, 'name' => $existedBrand->title])" />
    @include('frontend.v1.components.breadcrumb-schema', ['items' => $breadcrumbs])

    <div class="sf-container">
        <div class="mt-2 flex items-center gap-4">
            @if($existedBrand->hasMedia('media'))
                <img
                    src="{{ $existedBrand->getFirstMediaUrl('media', 'thumb') }}"
                    alt="{{ $existedBrand->title }}"
                    class="h-14 w-auto max-w-[8rem] object-contain"
                />
            @endif
            <h1 class="text-2xl font-bold text-ink-900 lg:text-3xl">{{ $existedBrand->title }}</h1>
        </div>
    </div>

    <x-sf-catalog
        :products="$products"
        :action="route('theme.brand.index', $existedBrand->onec_id)"
        :default-sort="$defaultSort ?? 'price'"
    >
        <x-slot:filters>
            <x-sf-catalog-filters
                :action="route('theme.brand.index', $existedBrand->onec_id)"
                {{-- As on the old brand sidebar: price and categories; attribute
                     groups other than "Brand" were not offered here. --}}
                :groups="collect($attributes ?? [])->only(['Бренд', 'Brand'])"
                :brands="null"
                :categories="$categories ?? null"
                :query="$query ?? []"
            />
        </x-slot:filters>

        @foreach($products as $product)
            <x-sf-product-card :product="$product" :list-id="$ga4ListId" :list-name="$ga4ListName" />
        @endforeach
    </x-sf-catalog>

    @include('frontend.v1.components.seo-content', ['seoContent' => $seoContent ?? null])
@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-item-lists')
@endsection

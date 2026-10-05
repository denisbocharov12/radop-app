@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        $ga4ListId = data_get($ga4ItemLists ?? [], '0.item_list_id', '');
        $ga4ListName = data_get($ga4ItemLists ?? [], '0.item_list_name', '');
    @endphp

    <x-sf-breadcrumbs :items="collect($breadcrumbs ?? [])->push(['url' => null, 'name' => $existedBrand->title])" />
    @include('frontend.v1.components.breadcrumb-schema', [
        'items' => $breadcrumbs,
        'leaf' => ['name' => $existedBrand->title, 'url' => route('theme.brand.index', $existedBrand->onec_id)],
    ])

    {{-- Название бренда — обычный заголовок страницы, как на разделах каталога:
         отдельной надписи над колонкой фильтров больше нет. --}}
    <div class="sf-container">
        <div class="flex items-center gap-3">
            @if($existedBrand->hasMedia('media'))
                <img
                    src="{{ $existedBrand->getFirstMediaUrl('media', 'thumb') }}"
                    alt="{{ $existedBrand->title }}"
                    class="h-10 w-auto max-w-[7rem] object-contain"
                />
            @endif
            <h1 class="sf-page-title">{{ $existedBrand->title }}</h1>
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

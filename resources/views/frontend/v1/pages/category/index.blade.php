@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        use App\Repositories\Brand\BrandRepository;

        $trail = collect($breadcrumbs ?? []);
        $title = (string) data_get($trail->last(), 'name', $existedCategory->name ?? '');

        $ga4ListId = data_get($ga4ItemLists ?? [], '0.item_list_id', '');
        $ga4ListName = data_get($ga4ItemLists ?? [], '0.item_list_name', '');

        $displayedBrands = app(BrandRepository::class)
            ->getAllBrandsByProductsIdsToFrontEnd($productsByCategory);
    @endphp

    <x-sf-breadcrumbs :items="$trail" />
    @include('frontend.v1.components.breadcrumb-schema', ['items' => $breadcrumbs])

    @if($existedCategory->children->isNotEmpty())
        <div class="sf-container">
            <h1 class="mb-4 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">{{ $title }}</h1>
            <ul class="mb-6 flex flex-wrap gap-2">
                @foreach($existedCategory->children as $child)
                    <li>
                        <a
                            href="{{ route('theme.category.index', $child->onec_id) }}"
                            class="inline-flex items-center gap-2 rounded-md border border-ink-200 bg-white px-3 py-2 text-sm font-medium text-ink-700 transition-colors hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700"
                        >
                            {{ $child->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-sf-catalog
        :products="$products"
        :action="route('theme.category.index', $existedCategory->onec_id)"
        :default-sort="$defaultSort ?? 'price'"
        :heading="$existedCategory->children->isEmpty() ? $title : null"
    >
        <x-slot:filters>
            <x-sf-catalog-filters
                :action="route('theme.category.index', $existedCategory->onec_id)"
                :groups="$attributes ?? []"
                :brands="$displayedBrands"
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

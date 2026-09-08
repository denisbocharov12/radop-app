@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        $term = $themeSearchData->search ?? '';
        $ga4ListId = data_get($ga4ItemLists ?? [], '0.item_list_id', 'search_results');
        $ga4ListName = data_get($ga4ItemLists ?? [], '0.item_list_name', '');
        $related = $relatedProducts ?? collect();
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('theme.search')]]" />

    <div class="sf-container pb-12">
        <h1 class="mb-1 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">
            {{ __('theme.search_results_title', ['text' => $term]) }}
        </h1>
        <p class="mb-5 text-sm text-ink-500">{{ $products->total() }} {{ __('theme.sort-products') }}</p>

        @if($products->isEmpty() && $related->isEmpty())
            <div class="py-16 text-center">
                <x-sf-icon name="search" :size="40" class="mx-auto mb-3 text-ink-300" />
                <p class="text-md font-medium text-ink-700">{{ __('theme.products_not_found_for_query') }}</p>
                <p class="mt-2 text-sm text-ink-500">{!! __('theme.not-found-product') !!}</p>
            </div>
        @else
            {{-- Category shortcuts: real links, not tabs — they navigate. --}}
            @if(! empty($categories) && count($categories))
                <div class="sf-scrollbar-none mb-5 flex gap-2 overflow-x-auto pb-1">
                    @foreach($categories as $category)
                        @php($model = \App\Models\Category::where('onec_id', $category->category_id)->first())
                        @continue($model === null)
                        <a
                            href="{{ route('theme.category.index', ['onecId' => $category->category_id, 'filter' => ['search' => $term]]) }}"
                            class="whitespace-nowrap rounded-md border border-ink-200 px-3 py-1.5 text-sm text-ink-700 transition-colors hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700"
                        >{{ $model->name }}</a>
                    @endforeach
                </div>
            @endif

            @if($products->isNotEmpty())
                <div class="sf-grid-products">
                    @foreach($products as $product)
                        <x-sf-product-card :product="$product" :list-id="$ga4ListId" :list-name="$ga4ListName" />
                    @endforeach
                </div>

                {{ $products->appends(request()->except('page'))->links('vendor.pagination.sf') }}
            @endif

            @if($related->isNotEmpty())
                <section class="sf-section">
                    <h2 class="sf-section-title mb-4">{{ __('theme.search_suggested') }}</h2>
                    <div class="sf-grid-products">
                        @foreach($related as $product)
                            <x-sf-product-card :product="$product" list-id="search_related" list-name="Search related" />
                        @endforeach
                    </div>
                </section>
            @endif
        @endif
    </div>
@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-item-lists')
@endsection

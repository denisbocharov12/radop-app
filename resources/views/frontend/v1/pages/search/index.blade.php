@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        use App\Models\Category;

        $term = $themeSearchData->search ?? '';
        $ga4ListId = data_get($ga4ItemLists ?? [], '0.item_list_id', 'search_results');
        $ga4ListName = data_get($ga4ItemLists ?? [], '0.item_list_name', '');
        $related = $relatedProducts ?? collect();

        /*
         * Подсказки по категориям: раньше имя каждой тянулось отдельным запросом,
         * теперь одним. Показываем первые восемь, остальные — по кнопке.
         */
        $categoryLinks = collect();
        if (! empty($categories) && count($categories)) {
            $ids = collect($categories)->pluck('category_id')->filter()->unique();
            $names = Category::query()->whereIn('onec_id', $ids)->get()->keyBy('onec_id');

            $categoryLinks = $ids
                ->map(static fn ($id) => $names->get($id))
                ->filter()
                ->map(static fn ($category) => [
                    'name' => $category->name,
                    'url' => route('theme.category.index', ['onecId' => $category->onec_id, 'filter' => ['search' => $term]]),
                ])
                ->values();
        }

        $visibleCategories = 8;
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('theme.search')]]" />

    <div class="sf-container sf-page-body pb-10">
        {{-- Шапка выдачи: запрос и количество в одной строке, без лишней высоты. --}}
        <div class="mt-1 flex flex-wrap items-baseline gap-x-3 gap-y-1">
            <h1 class="text-xl font-bold text-ink-900 lg:text-2xl">
                {{ __('theme.search') }}:
                <span class="text-brand-600">«{{ $term }}»</span>
            </h1>
            @if($products->total())
                <span class="text-sm text-ink-600">
                    <b class="font-num font-semibold text-ink-900">{{ $products->total() }}</b>
                    {{ __('theme.sort-products') }}
                </span>
            @endif
        </div>

        @if($products->isEmpty() && $related->isEmpty())
            <div class="mx-auto mt-6 max-w-md rounded-xl border border-dashed border-ink-200 bg-white px-6 py-12 text-center">
                <span class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-ink-50 text-ink-400">
                    <x-sf-icon name="search" :size="30" />
                </span>
                <p class="text-lg font-semibold text-ink-900">{{ __('theme.products_not_found_for_query') }}</p>
                <p class="mx-auto mt-2 max-w-sm text-sm text-ink-600">{!! __('theme.not-found-product') !!}</p>
                <a href="{{ route('theme.shop.catalog') }}" class="sf-btn-primary mt-6 inline-flex">
                    <x-sf-icon name="grid" :size="16" />
                    {{ __('theme.go-to-catalog') }}
                </a>
            </div>
        @else
            @if($categoryLinks->isNotEmpty())
                {{-- Уточнение по разделу: ссылки переносятся по строкам, а не уезжают вбок. --}}
                <div class="mt-4 flex flex-wrap items-center gap-2" data-sf-search-categories>
                    <span class="text-xs font-semibold uppercase tracking-wide text-ink-500">
                        {{ __('theme.sf-search-in-category') }}
                    </span>

                    @foreach($categoryLinks as $index => $category)
                        <a
                            href="{{ $category['url'] }}"
                            @class([
                                'inline-flex max-w-full items-center rounded-full border border-ink-200 bg-white px-3 py-1 text-xs font-medium text-ink-700 transition-colors hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700',
                                'hidden' => $index >= $visibleCategories,
                            ])
                            @if($index >= $visibleCategories) data-sf-search-category-extra @endif
                        >
                            <span class="truncate">{{ $category['name'] }}</span>
                        </a>
                    @endforeach

                    @if($categoryLinks->count() > $visibleCategories)
                        <button
                            type="button"
                            class="rounded-full px-2.5 py-1 text-xs font-semibold text-brand-600 hover:bg-brand-50"
                            data-sf-search-categories-toggle
                            data-label-more="{{ __('theme.sf-brands-show-all') }} ({{ $categoryLinks->count() }})"
                            data-label-less="{{ __('theme.sf-brands-collapse') }}"
                        >{{ __('theme.sf-brands-show-all') }} ({{ $categoryLinks->count() }})</button>
                    @endif
                </div>
            @endif

            @if($products->isNotEmpty())
                {{-- Та же панель, что в каталоге: сортировка, размер страницы, вид. --}}
                <x-sf-catalog-toolbar
                    :products="$products"
                    :action="route('theme.search.index')"
                    default-sort=""
                    :with-filters="false"
                />

                <div class="sf-grid-products py-5" data-sf-view="grid">
                    @foreach($products as $product)
                        <x-sf-product-card :product="$product" :list-id="$ga4ListId" :list-name="$ga4ListName" />
                    @endforeach
                </div>

                {{ $products->appends(request()->except('page'))->links('vendor.pagination.sf') }}
            @endif

            @if($related->isNotEmpty())
                <section class="sf-section border-t border-ink-100">
                    <div class="sf-section-head">
                        <h2 class="sf-section-title">{{ __('theme.search_suggested') }}</h2>
                    </div>
                    <div class="sf-grid-products" data-sf-view="grid">
                        @foreach($related as $product)
                            <x-sf-product-card :product="$product" list-id="search_related" list-name="Search related" />
                        @endforeach
                    </div>
                </section>
            @endif
        @endif
    </div>

    @push('scripts')
        <script>
            /* Разворачивание списка разделов под строкой поиска. */
            document.addEventListener('DOMContentLoaded', function () {
                var box = document.querySelector('[data-sf-search-categories]');
                if (!box) return;

                var toggle = box.querySelector('[data-sf-search-categories-toggle]');
                if (!toggle) return;

                var extras = box.querySelectorAll('[data-sf-search-category-extra]');
                var expanded = false;

                toggle.addEventListener('click', function () {
                    expanded = !expanded;
                    extras.forEach(function (el) { el.classList.toggle('hidden', !expanded); });
                    toggle.textContent = expanded ? toggle.dataset.labelLess : toggle.dataset.labelMore;
                });
            });
        </script>
    @endpush
@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-item-lists')
@endsection

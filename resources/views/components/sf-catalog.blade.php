@props([
    'products',
    'action',
    'defaultSort' => 'price',
    'filters' => null,
    'heading' => null,
    /** Excel export endpoint for this listing, if it has one. */
    'exportUrl' => null,
    'exportPersonalized' => false,
])

{{-- Перечень товаров страницы для поисковика (ItemList). --}}
@include('frontend.v1.components.item-list-schema', ['products' => $products])



{{--
    Catalogue shell shared by category, shop, brand and search results.
    The filter column is a sidebar from `lg` up and a slide-over below it —
    same markup, moved by CSS, so the form exists once in the DOM.
--}}
<div class="sf-container">
    @if($heading || $exportUrl)
        <div class="mt-1 flex flex-wrap items-end justify-between gap-3">
            @if($heading)
                <h1 class="sf-page-title">{{ $heading }}</h1>
            @endif
            @if($exportUrl)
                <x-sf-export-button :url="$exportUrl" :personalized="$exportPersonalized" />
            @endif
        </div>
    @endif

    {{-- Room under the page title, so the filter card and toolbar read as the
         start of the listing rather than hanging off the heading. --}}
    <div @class(['flex gap-6 lg:gap-8', 'mt-3 lg:mt-4' => $heading || $exportUrl])>
        @if($filters)
            {{-- На десктопе колонка едет вместе со страницей: своя прокрутка и
                 закрепление прятали часть фильтров и спорили с прокруткой
                 страницы. На телефоне это по-прежнему шторка. --}}
            <div
                class="fixed inset-y-0 left-0 z-modal flex w-[min(21rem,90vw)] -translate-x-full flex-col bg-white shadow-pop transition-transform duration-200 ease-sf
                       lg:static lg:z-0 lg:h-fit lg:w-64 lg:shrink-0 lg:translate-x-0
                       lg:rounded-lg lg:border lg:border-ink-200 lg:shadow-none"
                data-sf-drawer="catalog-filters"
            >
                <div class="flex items-center justify-between border-b border-ink-100 px-4 py-3 lg:hidden">
                    <span class="text-md font-medium text-ink-900">{{ __('theme.filters') }}</span>
                    <button type="button" class="sf-icon-btn" data-sf-drawer-close aria-label="{{ __('theme.notification_close_btn_text') }}">
                        <x-sf-icon name="close" />
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto overscroll-contain p-4 lg:overflow-visible lg:p-0 lg:pb-1">
                    {{ $filters }}
                </div>

                {{-- On phones filters apply on demand: auto-submitting on every
                     tick reloads the page and closes the drawer mid-selection. --}}
                <div class="grid grid-cols-2 gap-2 border-t border-ink-100 p-3 pb-[max(0.75rem,env(safe-area-inset-bottom))] lg:hidden">
                    <button type="button" class="sf-btn-secondary" data-sf-filter-reset>{{ __('theme.reset-filters') }}</button>
                    <button type="submit" form="filterForm" class="sf-btn-primary">{{ __('theme.filter') }}</button>
                </div>
            </div>

            <div class="sf-overlay lg:hidden" data-sf-drawer-overlay="catalog-filters" hidden></div>
        @endif

        <div class="min-w-0 flex-1">
            <x-sf-catalog-toolbar :products="$products" :action="$action" :default-sort="$defaultSort" />

            {{-- ТЗ 45, 46: выбранные фильтры отдельными чипсами. --}}
            <x-sf-filter-chips :action="$action" />

            @if($products->isEmpty())
                <div class="py-16 text-center">
                    <x-sf-icon name="search" :size="40" class="mx-auto mb-3 text-ink-300" />
                    <p class="text-md font-medium text-ink-700">
                        {{ request()->has('filter') ? __('theme.products_not_found_for_query') : __('theme.missing-category') }}
                    </p>
                    <p class="mt-2 text-sm text-ink-500">{!! __('theme.not-found-product') !!}</p>
                    @if(request()->has('filter'))
                        <a href="{{ $action }}" class="sf-btn-secondary mt-5 inline-flex">{{ __('theme.reset-filters') }}</a>
                    @endif
                </div>
            @else
                <div class="sf-grid-products py-5" data-sf-view="grid">
                    {{ $slot }}
                </div>

                {{ $products->appends(request()->except('page'))->links('vendor.pagination.sf') }}
            @endif
        </div>
    </div>
</div>

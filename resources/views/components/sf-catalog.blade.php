@props([
    'products',
    'action',
    'defaultSort' => 'price',
    'filters' => null,
    'heading' => null,
])

{{--
    Catalogue shell shared by category, shop, brand and search results.
    The filter column is a sidebar from `lg` up and a slide-over below it —
    same markup, moved by CSS, so the form exists once in the DOM.
--}}
<div class="sf-container">
    @if($heading)
        <h1 class="mt-4 text-2xl font-bold text-ink-900 lg:text-3xl">{{ $heading }}</h1>
    @endif

    <div class="flex gap-6 lg:gap-8">
        @if($filters)
            <div
                class="fixed inset-y-0 left-0 z-modal w-[min(20rem,88vw)] -translate-x-full overflow-y-auto overscroll-contain bg-white p-4 shadow-pop transition-transform duration-200 ease-sf
                       lg:sticky lg:top-24 lg:z-0 lg:block lg:h-fit lg:max-h-[calc(100vh-8rem)] lg:w-64 lg:shrink-0 lg:translate-x-0 lg:p-0 lg:shadow-none"
                data-sf-drawer="catalog-filters"
            >
                <button type="button" class="sf-icon-btn absolute right-2 top-2 lg:hidden" data-sf-drawer-close aria-label="×">
                    <x-sf-icon name="close" />
                </button>

                {{ $filters }}
            </div>

            <div class="sf-overlay lg:hidden" data-sf-drawer-overlay="catalog-filters" hidden></div>
        @endif

        <div class="min-w-0 flex-1">
            <x-sf-catalog-toolbar :products="$products" :action="$action" :default-sort="$defaultSort" />

            @if($products->isEmpty())
                <div class="py-16 text-center">
                    <x-sf-icon name="search" :size="40" class="mx-auto mb-3 text-ink-300" />
                    <p class="text-md font-medium text-ink-700">
                        {{ request()->has('filter') ? __('theme.products_not_found_for_query') : __('theme.missing-category') }}
                    </p>
                    <p class="mt-2 text-sm text-ink-500">{!! __('theme.not-found-product') !!}</p>
                </div>
            @else
                <div class="sf-grid-products py-5">
                    {{ $slot }}
                </div>

                {{ $products->appends(request()->except('page'))->links('vendor.pagination.sf') }}
            @endif
        </div>
    </div>
</div>

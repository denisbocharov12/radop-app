<section class="section-standart section-sort">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sort-block d-none d-md-block">
                    @include('frontend.v1.components.sort-products')
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.v1.components.show-filter-button')
<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($existedCategory->products) < 1)
                @include('frontend.v1.pages.category.parts.not-found')
            @else
                <div class="col-12 col-md-3 col-theme-filters d-none d-md-block">
                    <div class="sticky-sidebar">
                        @include('frontend.v1.pages.category.parts.category-filter-form')
                    </div>
              </div>
                <div class="col-md-9 col-12 col-theme-content">
                    <div id="mobile-sort-block" class="mobile-sort-block">
                        <span class="mobile-sort-label">{{__('theme.sort-label')}}</span>
                        <span class="mobile-sort-selected" id="mobileSortSelected"></span>
                    </div>
                    <div id="mobileSortModal" class="mobile-sort-modal">
                        <div class="mobile-sort-modal-content">
                            <div class="mobile-sort-option default-option" data-sort="price">{{ __('theme.sort-price-asc') }}</div>
                            <div class="mobile-sort-option" data-sort="price_desc">{{ __('theme.sort-price-desc') }}</div>
                            <div class="mobile-sort-option" data-sort="title">{{ __('theme.sort-title') }}</div>
                            <div class="mobile-sort-option" data-sort="popular_order">{{ __('theme.sort-popular') }}</div>
                            <div class="mobile-sort-option" data-sort="condition">{{ __('theme.sort-new') }}</div>
                            <div class="mobile-sort-option" data-sort="stock">{{ __('theme.sort-stock') }}</div>
                        </div>
                    </div>
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
                        @include('frontend.v1.pages.category.parts.list')
                    </div>
                    <div id="mobile-per-page-block" class="mobile-per-page-block">
                        <div class="mobile-per-page-selected" id="mobilePerPageSelected">{{$products->perPage()}} товаров <span class="arrow">&#9660;</span></div>
                    </div>
                    <div id="mobilePerPageModal" class="mobile-per-page-modal">
                        <div class="mobile-per-page-modal-content">
                            <div class="mobile-per-page-option" data-value="24">24 {{ __('theme.sort-product') }}</div>
                            <div class="mobile-per-page-option" data-value="48">48 {{ __('theme.sort-products') }}</div>
                            <div class="mobile-per-page-option" data-value="72">72 {{ __('theme.sort-product') }}</div>
                            <div class="mobile-per-page-option" data-value="96">96 {{ __('theme.sort-products') }}</div>
                        </div>
                    </div>
                    <div class="theme-pagination">
                        {{$products->appends(request()->except('page'))->links()}}
                    </div>
                </div>
            @endif
        </div>
        @include('frontend.v1.pages.category.parts.category-filter-modal')
    </div>
</section>
@include('frontend.v1.components.sort-js')

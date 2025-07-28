<section class="section-standart section-sort">
    <div class="container">
        <div class="row" style="border-block: 1px solid #eee; margin-bottom: 25px">
            <div class="col-lg-3"></div>
            <div class="col-md-12 col-lg-9 col-12">
                <div class="sort-block">
                    @include('frontend.v1.components.sort-products')
                    <div class="view-mode-switch">
                        <span>{{ __('theme.view') }}:</span>
                        <button id="viewTable" class="btn btn-light me-2 active" type="button"><i class="fa fa-th"></i> {{ __('theme.view-table') }}</button>
                        <button id="viewList" class="btn btn-light" type="button"><i class="fa fa-list"></i> {{ __('theme.view-list') }}</button>
                    </div>
                    <div class="sort-per-page d-none d-md-block">
                        <form class="form-sort-per-page" id="form-sort-per-page" action="{{route('theme.shop.index')}}" method="GET">
                            <select name="perPage" id="perPage" class="js2-select select-sort-per-page">
                                <option value="24" {{request()->has('perPage') && request()->query('perPage') !== null && (int)request()->query('perPage') === 24 ? 'selected': ''}}>24 {{ __('theme.sort-product') }}</option>
                                <option value="48" {{request()->has('perPage') && request()->query('perPage') !== null && (int)request()->query('perPage') === 48 ? 'selected': ''}}>48 {{ __('theme.sort-products') }}</option>
                                <option value="72" {{request()->has('perPage') && request()->query('perPage') !== null && (int)request()->query('perPage') === 72 ? 'selected': ''}}>72 {{ __('theme.sort-product') }}</option>
                                <option value="96" {{request()->has('perPage') && request()->query('perPage') !== null && (int)request()->query('perPage') === 96 ? 'selected': ''}}>96 {{ __('theme.sort-products') }}</option>
                            </select>
                        </form>
                    </div>
                    @if($products->hasPages())
                        <div class="theme-pagination d-none d-lg-block">
                            {{$products->links()}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.v1.components.show-filter-button')
<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($products) < 1)
                @include('frontend.v1.pages.category.parts.not-found')
            @else
                <div class="col-12 col-md-3 col-theme-filters d-none d-md-block">
                    <div class="sticky-sidebar">
                        @include('frontend.v1.pages.shop.parts.shop-filter-form')
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
                    <div id="productsTableView" class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
                        @include('frontend.v1.pages.brand.parts.list')
                    </div>
                    <div id="productsListView" style="display:none;">
                        @include('frontend.v1.pages.brand.parts.list-view')
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
        @include('frontend.v1.pages.shop.parts.shop-filter-modal')
    </div>
</section>
@include('frontend.v1.components.sort-js')

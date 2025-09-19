<section class="section-standart section-sort">
    <div class="container">
        <div class="row d-none d-md-flex" style="border-block: 1px solid #eee; margin-bottom: 10px">
            <div class="col-lg-3"></div>
            <div class="col-md-12 col-lg-9 col-12">
                <div class="sort-block">
                    @include('frontend.v1.components.sort-products', ['defaultSort' => $defaultSort])
                    @include('frontend.v1.components.table-view-switch')
                    <div class="sort-per-page d-none d-md-block">
                        <form class="form-sort-per-page" id="form-sort-per-page" action="{{route('theme.category.index', $existedCategory->onec_id, ['query' => request()->query()])}}" method="GET">
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
            @if(count($existedCategory->products) < 1)
                @include('frontend.v1.pages.category.parts.not-found')
            @else
                <div class="col-12 col-md-3 col-theme-filters d-none d-md-block">
                    <div class="sticky-sidebar">
                        @include('frontend.v1.pages.category.parts.category-filter-form')
                    </div>
                </div>
                <div class="col-md-9 col-12 col-theme-content">
                    @include('frontend.v1.components.mobile-sort-products', ['defaultSort' => $defaultSort])
                    <div class="d-none d-md-block">
                        <div id="productsTableView" class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
                            @include('frontend.v1.pages.brand.parts.list')
                        </div>
                        <div id="productsListView" style="display:none;">
                            @include('frontend.v1.pages.brand.parts.list-view')
                        </div>
                    </div>
                    <div class="d-block d-md-none">
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
        @include('frontend.v1.pages.category.parts.category-filter-modal')
    </div>
</section>
@include('frontend.v1.components.sort-js')

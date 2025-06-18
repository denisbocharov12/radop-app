<section class="section-standart section-sort">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sort-block">
                    @include('frontend.v1.pages.shop.parts.sort-products')
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
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
                        @include('frontend.v1.pages.shop.parts.list')
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

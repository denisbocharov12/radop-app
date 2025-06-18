<section class="section-standart section-sort">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sort-block">
                    @include('frontend.v1.pages.brand.parts.sort-products')
{{--                    @include('frontend.v1.pages.brand.parts.export-excel')--}}
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.v1.components.show-filter-button')
<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
                <div class="col-12 col-md-3 col-theme-filters d-none d-md-block">
                    @include('frontend.v1.pages.brand.parts.brand-filter-form')
                </div>
                <div class="col-md-9 col-12 col-theme-content">
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
                        @include('frontend.v1.pages.brand.parts.list')
                    </div>
                    <div class="theme-pagination">
                        {{$products->links()}}
                    </div>
                </div>
        </div>
    </div>
    @include('frontend.v1.pages.brand.parts.brand-filter-modal')
</section>

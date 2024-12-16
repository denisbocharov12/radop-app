<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($products) < 1)
                @include('frontend.v1.pages.search.parts.not-found')
            @else
                <div class="col-12">
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
                        @include('frontend.v1.pages.search.parts.list')
                    </div>
                    <div class="row mt-5 mb-5">
                        {{$products->links()}}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

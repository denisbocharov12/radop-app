<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($existedCategory->products) < 1)
                @include('frontend.v1.pages.category.parts.not-found')
            @else
                <div class="col-3">

                </div>
                <div class="col-9">
                    <div class="row">
                        @include('frontend.v1.pages.category.parts.list')
                    </div>
                    <div class="row mt-5 mb-5">
                        {{$existedCategory->products()->paginate(config('theme-pagination.paginationCount'))->links()}}
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

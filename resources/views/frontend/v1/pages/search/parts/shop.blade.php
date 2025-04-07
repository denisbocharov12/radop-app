<section class="section-standart section-category section-search pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($products) < 1)
                @include('frontend.v1.pages.search.parts.not-found')
            @else
                <div class="col-12 col-search-results">
                    <div class="wrap">
                        <h1 class="search-results-title">{{__('theme.search_results_title', ['text' => $themeSearchData->search])}}</h1>
                    </div>
                    <hr>
                </div>
                <div class="col-12 col-search-meta">
                    <h3 class="col-search-meta-title">{{__('theme.search_meta_category_title')}}</h3>
                    <div class="wrap wrap-items">
                        @foreach($categories as $category)
                            <a href="{{route('theme.category.index', $category->category_id)}}" title="Категория" class="wrap-item-link limk-meta">{{\App\Models\Category::where('onec_id', $category->category_id)->first()?->name}}</a>
                        @endforeach

                    </div>
                </div>
                <div class="col-12">
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}" style="{{$products->isEmpty() ? '' : 'grid-template-columns: repeat(5, 1fr);'}}">
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

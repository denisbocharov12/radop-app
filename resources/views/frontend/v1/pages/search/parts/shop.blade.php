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
                    <div class="wrap wrap-items">
                        <a href="{{route('theme.search.index', ['search' => $themeSearchData->search])}}" title="{{__('theme.search_meta_title')}}" class="wrap-item-link limk-meta theme-bold">{{__('theme.search_meta_title')}} ({{$products->total()}})</a>
                        @foreach($categories as $category)
                            <a href="{{route('theme.category.index', $category->category_id)}}" title="{{\App\Models\Category::where('onec_id', $category->category_id)->first()?->name}}" class="wrap-item-link limk-meta">{{\App\Models\Category::where('onec_id', $category->category_id)->first()?->name}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-12">
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}" >
                        @include('frontend.v1.pages.search.parts.list')
                    </div>
                    <div class="theme-pagination">
                        {{$products->links()}}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

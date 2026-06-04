<section class="section-standart section-category section-search pt-0">
    <div class="container">
        @php
            $ga4SelectListId = 'search_results';
            $ga4SelectListName = '';
            if (!empty($ga4ItemLists) && is_array($ga4ItemLists) && isset($ga4ItemLists[0]['item_list_id'])) {
                $ga4SelectListId = (string) $ga4ItemLists[0]['item_list_id'];
                $ga4SelectListName = (string) ($ga4ItemLists[0]['item_list_name'] ?? '');
            }
        @endphp
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
                        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
                            <span class="wrap-item-link limk-meta limk-meta-suggested" title="{{ __('theme.search_suggested') }}">{{ __('theme.search_suggested') }} ({{ $relatedProducts->count() }})</span>
                        @endif
                        @foreach($categories as $category)
                            <a href="{{ route('theme.category.index', ['onecId' => $category->category_id, 'filter' => ['search' => $themeSearchData->search]]) }}" title="{{\App\Models\Category::where('onec_id', $category->category_id)->first()?->name}}" class="wrap-item-link limk-meta">{{\App\Models\Category::where('onec_id', $category->category_id)->first()?->name}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-12">
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}" >
                        @include('frontend.v1.pages.search.parts.list', ['ga4ItemListId' => $ga4SelectListId, 'ga4ItemListName' => $ga4SelectListName])
                        {{-- Suggested products (same category, then brand) flow into the
                             common list right after the found item(s). --}}
                        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
                            @include('frontend.v1.pages.search.parts.list', [
                                'products' => $relatedProducts,
                                'ga4ItemListId' => 'search_related',
                                'ga4ItemListName' => 'Search related',
                            ])
                        @endif
                    </div>
                    <div class="theme-pagination">
                        {{$products->links()}}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

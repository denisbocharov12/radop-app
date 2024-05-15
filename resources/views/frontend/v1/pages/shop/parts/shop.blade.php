<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($products) < 1)
                @include('frontend.v1.pages.category.parts.not-found')
            @else
                <div class="col-12 col-md-3 col-theme-filters">
                    <form action="{{route('theme.shop.index')}}" method="GET">
                        <div class="theme-wg-wrap">
                                                    <p class="theme-widget-title">{{__('theme.search')}}</p>
                                                    <div class="filter-widget-wrap">
                                                        <input type="text" name="filter[search]" value="{{isset($query['search']) ? $query['search'] : ''}}" placeholder="{{__('theme.search-text')}}" class="search">
                                                    </div>
                                                </div>
                        <div class="theme-wg-wrap">
                            <p class="theme-widget-title">{{__('theme.category')}}</p>
                            <div class="filter-widget-wrap">
                                @if(!empty($themeParentCategories))
                                    <ul class="accordion theme-category-list">
                                        @foreach($themeParentCategories as $parentCategory)
                                            @include('frontend.v1.pages.category.parts.filter.category', $parentCategory)
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="theme-wg-wrap">
                            <p class="theme-widget-title">{{__('theme.brand')}}</p>
                            <div class="filter-widget-wrap filter-wrap-overflow">
                                @foreach($brands as $brand)
                                    <input type="checkbox" class="theme-checkbox" {{isset($query['brand']) && in_array($query['brand'], $brand->id) ? 'checked' : ''}} id="brand-{{$brand->id}}" name="filter[brand][]" value="{{$brand->id}}">
                                    <label for="brand-{{$brand->id}}">{{$brand->title}}</label>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="theme-wg-btn">{{__('theme.filter')}}</button>
                    </form>
                </div>
                <div class="col-md-9 col-12 col-theme-content">
                    <div class="row">
                        @include('frontend.v1.pages.shop.parts.list')
                    </div>
                    <div class="row mt-5 mb-5">
                        {{$products->links()}}
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

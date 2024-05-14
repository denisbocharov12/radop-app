<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($existedCategory->products) < 1)
                @include('frontend.v1.pages.category.parts.not-found')
            @else
                <div class="col-12 col-md-3 col-theme-filters">
                    <form action="{{route('theme.category.index', $existedCategory->onec_id)}}" method="GET">
{{--                        <div class="theme-wg-wrap">--}}
{{--                            <p class="theme-widget-title">Поиск</p>--}}
{{--                            <div class="filter-widget-wrap">--}}
{{--                                <input type="text" name="filter[search]" value="{{isset($query['search']) ? $query['search'] : ''}}" placeholder="Введите SKU товара либо название" class="search">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="theme-wg-wrap">
                            <p class="theme-widget-title">Категории</p>
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
                            <p class="theme-widget-title">Брэнд</p>
                            <div class="filter-widget-wrap">
                                @foreach($brands as $brand)
                                    <input type="checkbox" class="theme-checkbox" {{isset($query['brand']) && in_array($query['brand'], $brand->id) ? 'checked' : ''}} id="brand-{{$brand->id}}" name="filter[brand][]" value="{{$brand->id}}">
                                    <label for="brand-{{$brand->id}}">{{$brand->title}}</label>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-9 col-12 col-theme-content">
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

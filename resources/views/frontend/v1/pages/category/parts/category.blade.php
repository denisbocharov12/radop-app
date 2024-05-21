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
                            <p class="theme-widget-title">По цене</p>
                            <div class="filter-widget-wrap">
                                <div class="price-input">
                                    <div class="field">
                                        <span>Min</span>
                                        <input type="number" class="input-min" value="2500">
                                    </div>
                                    <div class="separator">-</div>
                                    <div class="field">
                                        <span>Max</span>
                                        <input type="number" class="input-max" value="7500">
                                    </div>
                                </div>
                                <div class="slider">
                                    <div class="progress"></div>
                                </div>
                                <div class="range-input">
                                    <input type="range" class="range-min" min="0" max="10000" value="2500" step="10">
                                    <input type="range" class="range-max" min="0" max="10000" value="7500" step="10">
                                </div>
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
                                    <input type="checkbox" class="theme-checkbox" {{isset($query['brand']) && is_array($query['brand']) && in_array($brand->onec_id, $query['brand']) ? 'checked' : ''}} id="brand-{{$brand->onec_id}}" name="filter[brand][]" value="{{$brand->onec_id}}">
                                    <label for="brand-{{$brand->id}}">{{$brand->title}}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="theme-wg-wrap">
                            <p class="theme-widget-title">Аттрибуты</p>
                            <div class="filter-widget-wrap filter-wrap-overflow">
                                @foreach($brands as $brand)
                                    <input type="checkbox" class="theme-checkbox" {{isset($query['brand']) && is_array($query['brand']) && in_array($brand->onec_id, $query['brand']) ? 'checked' : ''}} id="brand-{{$brand->onec_id}}" name="filter[brand][]" value="{{$brand->onec_id}}">
                                    <label for="brand-{{$brand->id}}">{{$brand->title}}</label>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="theme-wg-btn">{{__('theme.filter')}}</button>
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

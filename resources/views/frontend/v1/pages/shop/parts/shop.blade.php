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
                            <p class="theme-widget-title">По цене</p>
                            <div class="filter-widget-wrap">
                                <div class="price-input">
                                    @php
                                    $queryPrice = $query['price'] ?? null;
                                    $queryPriceFrom = $query['price']['from'] ?? null;
                                    $queryPriceTo = $query['price']['to'] ?? null;
                                    @endphp
                                    <div class="field">
                                        <span>Min</span>
                                        <input type="number" class="input-min" name="filter[price][from]" @if(is_array($queryPrice) && isset($queryPriceFrom) ) value="{{$queryPriceFrom}}" @else value="{{$queryPriceFrom}}"  @endif>
                                    </div>
                                    <div class="separator">-</div>
                                    <div class="field">
                                        <span>Max</span>
                                        <input type="number" class="input-max" name="filter[price][to]"  @if(is_array($queryPrice) && isset($queryPriceTo) ) value="{{$queryPriceTo}}" @else value="{{$queryPriceTo}}"  @endif" >
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="theme-wg-wrap">--}}
{{--                            <p class="theme-widget-title">{{__('theme.category')}}</p>--}}
{{--                            <div class="filter-widget-wrap">--}}
{{--                                @if(!empty($themeParentCategories))--}}
{{--                                    <ul class="accordion theme-category-list">--}}
{{--                                        @foreach($themeParentCategories as $parentCategory)--}}
{{--                                            @include('frontend.v1.pages.category.parts.filter.category', $parentCategory)--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="theme-wg-wrap">
                            <p class="theme-widget-title">Аттрибуты</p>
                            <div class="filter-widget-wrap filter-wrap-overflow">
                                @foreach($attributes as $attribute)
                                    @if(!empty($attribute->values))
                                        <p style="font-weight: bold; margin: 5px 0; display: flex; width: 100%">{{$attribute->name}}</p>
                                        @php
                                            $values = \App\Models\AttributeValue::where('attribute_onec_id', $attribute->onec_id)->get()->groupBy('value');
                                        @endphp
                                        {{--                                        @dd($values)--}}
                                        @foreach($values as $key => $attribute)
                                            @php
                                                $attribute = \App\Models\AttributeValue::where('value->'.str_replace('_', '-', app()->getLocale()), $key)->first();

                                            @endphp

                                            <input type="checkbox" class="theme-checkbox" {{isset($query) && isset($query['attribute']) && is_array($query['attribute']) && in_array($attribute->attribute_onec_id, $query['attribute']) ? 'checked' : ''}} id="attribute-{{$attribute->attribute_onec_id}}" name="filter[attribute][]" value="{{$attribute->attribute_onec_id}}">
                                            <label for="attribute-{{$attribute->attribute_onec_id}}">{{$attribute->value}}</label>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="theme-wg-wrap">
                            <p class="theme-widget-title">{{__('theme.brand')}}</p>
                            <div class="filter-widget-wrap filter-wrap-overflow">
                                @foreach($brands as $brand)
                                    <input type="checkbox" class="theme-checkbox" {{isset($query['brand']) && is_array($query['brand']) && in_array($brand->onec_id, $query['brand']) ? 'checked' : ''}} id="brand-{{$brand->onec_id}}" name="filter[brand][]" value="{{$brand->onec_id}}">
                                    <label for="brand-{{$brand->onec_id}}">{{$brand->title}}</label>
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

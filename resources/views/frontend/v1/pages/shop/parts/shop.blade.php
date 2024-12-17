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
                            <p class="theme-widget-title">{{__('theme.by-price')}}</p>
                            <div class="filter-widget-wrap">
                                @php
                                    $queryPrice = $query['price'] ?? null;
                                    $queryPriceFrom = $query['price']['from'] ?? null;
                                    $queryPriceTo = $query['price']['to'] ?? null;
                                @endphp
                                <div class="price-range-wrap">
                                    <div class="slider">
                                        <div class="progress"
                                             @if(is_array($queryPrice) && isset($queryPriceFrom) && isset($queryPriceTo))
                                             style="left:{{$queryPriceFrom/10}}%; right:{{100 - $queryPriceTo/10}}%"
                                            @endif
                                        >
                                        </div>
                                    </div>
                                    <div class="range-input">
                                        <input type="range" class="range-min" min="0" max="1000" @if(is_array($queryPrice) && isset($queryPriceFrom)) value="{{$queryPriceFrom}}" @else value="1" @endif step="1">
                                        <input type="range" class="range-max" min="0" max="1000" @if(is_array($queryPrice) && isset($queryPriceTo)) value="{{$queryPriceTo}}" @else value="1000" @endif step="1">
                                    </div>
                                </div>
                                <div class="price-input">
                                    <div class="field">
                                        <span>{{__('theme.min')}}</span>
                                        <input type="number" class="input-min" name="filter[price][from]" @if(is_array($queryPrice) && isset($queryPriceFrom)) value="{{$queryPriceFrom}}" @else value="{{$queryPriceFrom}}"  @endif>
                                    </div>
                                    <div class="separator">-</div>
                                    <div class="field">
                                        <span>{{__('theme.max')}}</span>
                                        <input type="number" class="input-max" name="filter[price][to]"  @if(is_array($queryPrice) && isset($queryPriceTo)) value="{{$queryPriceTo}}" @else value="{{$queryPriceTo}}"  @endif" >
                                    </div>
                                </div>
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
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
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

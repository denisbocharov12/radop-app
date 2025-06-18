<form action="{{route('theme.brand.index', $existedBrand->onec_id)}}" method="GET">
    <div class="theme-wg-wrap">
        <p class="theme-widget-title theme-widget-title-range">{{__('theme.by-price')}}</p>
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
                <div class="separator"></div>
                <div class="field">
                    <span>{{__('theme.max')}}</span>
                    <input type="number" class="input-max" name="filter[price][to]"  @if(is_array($queryPrice) && isset($queryPriceTo)) value="{{$queryPriceTo}}" @else value="{{$queryPriceTo}}"  @endif" >
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="theme-wg-btn">{{__('theme.filter')}}</button>
</form>
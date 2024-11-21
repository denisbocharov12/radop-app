<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($existedCategory->products) < 1)
                @include('frontend.v1.pages.category.parts.not-found')
            @else
                <div class="col-12 col-md-2 col-theme-filters">
                    <div class="sticky-sidebar">
                        <form action="{{route('theme.category.index', $existedCategory->onec_id)}}" method="GET">
                            <div class="theme-wg-wrap">
                                <p class="theme-widget-title">{{__('theme.by-price')}}</p>
                                <div class="filter-widget-wrap">
                                    <div class="price-input">
                                        @php
                                            $queryPrice = $query['price'] ?? null;
                                            $queryPriceFrom = $query['price']['from'] ?? null;
                                            $queryPriceTo = $query['price']['to'] ?? null;
                                        @endphp
                                        <div class="field">
                                            <span>{{__('theme.min')}}</span>
                                            <input type="number" class="input-min" name="filter[price][from]" @if(is_array($queryPrice) && isset($queryPriceFrom) ) value="{{$queryPriceFrom}}" @else value="{{$queryPriceFrom}}"  @endif>
                                        </div>
                                        <div class="separator">-</div>
                                        <div class="field">
                                            <span>{{__('theme.max')}}</span>
                                            <input type="number" class="input-max" name="filter[price][to]"  @if(is_array($queryPrice) && isset($queryPriceTo) ) value="{{$queryPriceTo}}" @else value="{{$queryPriceTo}}"  @endif" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="theme-wg-wrap">
                                <p class="theme-widget-title">{{__('theme.attributes')}}</p>
                                @if(!empty($attributes))
                                    <ul class="theme-toggle-list">
                                        @foreach($attributes as $key => $attributeValues)
                                            <li class="theme-toggle-item">
                                                <div class="theme-toggle-item-title">
                                                    <p class="theme-widget-title">{{$key}}</p>
                                                    <i class="icon-arrow-radop-right"></i>
                                                </div>
                                                <div class="theme-toggle-item-content">
                                                    @foreach($attributeValues as $attribute)
                                                        @php
                                                            $attribute = \App\Models\AttributeValue::find($attribute['id']);
                                                        @endphp
                                                        <input type="checkbox" class="theme-checkbox" {{isset($query) && isset($query['attribute']) && is_array($query['attribute']) && in_array($attribute->value, $query['attribute']) ? 'checked' : ''}} id="attribute-{{$attribute->id}}" name="filter[attribute][]" value="{{$attribute->value}}">
                                                        <label for="attribute-{{$attribute->id}}">{{$attribute->value}}</label>
                                                    @endforeach
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <button type="submit" class="theme-wg-btn">{{__('theme.filter')}}</button>
                        </form>
                    </div>
              </div>
                <div class="col-md-10 col-12 col-theme-content">
                    <div class="row">
                        @include('frontend.v1.pages.category.parts.list')
                    </div>
                    <div class="row mt-5 mb-5">
                        {{$products->links()}}
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

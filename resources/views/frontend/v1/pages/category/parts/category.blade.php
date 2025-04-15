<div class="sort-block">
    @include('frontend.v1.components.sort-products')
</div>
<section class="section-standart section-category pt-0">
    <div class="container">
        <div class="row row-category-list">
            @if(count($existedCategory->products) < 1)
                @include('frontend.v1.pages.category.parts.not-found')
            @else
                <div class="col-12 col-md-3 col-theme-filters">
                    <div class="sticky-sidebar">
                        <form action="{{route('theme.category.index', $existedCategory->onec_id)}}" method="GET" id="filterForm">
                            <input type="hidden" name="sort" id="sortInput" value="{{ request('sort') }}">
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
                            <div class="theme-wg-wrap">
                                <p class="theme-widget-title">{{__('theme.attributes')}}</p>
                                @if(!empty($attributes))
                                    <ul class="theme-toggle-list">
                                        @foreach($attributes as $key => $attributeValues)
                                            <li class="theme-toggle-item">
                                                <div class="theme-toggle-item-title">
                                                    <i class="icon-arrow-filter-radop-left"></i>
                                                    <p class="theme-widget-title">{{$key}}</p>
                                                </div>
                                                @php
                                                    $attributeValues = collect($attributeValues)->map(function($attribute) {
                                                        return \App\Models\AttributeValue::find($attribute->id);
                                                    })->sortBy('value');

                                                $activeStyle = 'display: none';

                                                foreach ($attributeValues as $attribute) {
                                                    if (isset($query) && isset($query['attribute']) && is_array($query['attribute']) && array_key_exists($attribute->attribute_onec_id, $query['attribute'])){
                                                        $activeStyle = 'display:flex';
                                                    }
                                                }
                                                @endphp
                                                <div class="theme-toggle-item-content" style="{{$activeStyle}}">
                                                        @foreach($attributeValues as $attribute)
                                                            <div class="col-6">
                                                                <input type="checkbox" class="theme-checkbox"  id="attribute-{{$attribute->id}}" name="filter[attribute][{{$attribute->attribute_onec_id}}][]" {{isset($query['attribute']) && is_array($query['attribute']) && array_key_exists($attribute->attribute_onec_id, $query['attribute']) && in_array(str_replace(',','.', $attribute->value), $query['attribute'][$attribute?->attribute_onec_id]) ? 'checked' : ''}} value="{{str_replace(',','.', $attribute->value)}}">
                                                                <label for="attribute-{{$attribute->id}}">{{$attribute->value}}</label>
                                                            </div>
                                                        @endforeach
                                                </div>
                                            </li>
                                        @endforeach
                                        @php
                                            $allProductIds = $productsByCategory->pluck('id')->toArray();
                                            $displayedBrands = \App\Models\Product::whereIn('id', $allProductIds)
                                                ->with('brand')
                                                ->get()
                                                ->pluck('brand')
                                                ->unique('id');
                                        @endphp
                                        @if($displayedBrands)
                                            <li class="theme-toggle-item">
                                                <div class="theme-toggle-item-title">
                                                    <i class="icon-arrow-filter-radop-left"></i>
                                                    <p class="theme-widget-title">{{__('theme.brand')}}</p>
                                                </div>
                                                <div class="theme-toggle-item-content">
                                                    @foreach($displayedBrands as $brand)
                                                        <div class="col-6">
                                                            <input type="checkbox" class="theme-checkbox" {{isset($query['brand']) && is_array($query['brand']) && in_array($brand?->onec_id, $query['brand']) ? 'checked' : ''}} id="brand-{{$brand?->onec_id}}" name="filter[brand][]" value="{{$brand?->onec_id}}">
                                                            <label for="brand-{{$brand?->onec_id}}">{{$brand?->title}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                            <button type="submit" class="theme-wg-btn">{{__('theme.filter')}}</button>
                        </form>
                    </div>
              </div>
                <div class="col-md-9 col-12 col-theme-content">
                    <div class="{{$products->isEmpty() ? 'row' : 'grid-products-list-wrap'}}">
                        @include('frontend.v1.pages.category.parts.list')
                    </div>
                    <div class="row mt-5 mb-5">
                        {{$products->appends(request()->except('page'))->links()}}
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

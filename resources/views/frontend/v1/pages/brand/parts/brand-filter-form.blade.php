<form action="{{route('theme.brand.index', $existedBrand->onec_id)}}" method="GET" id="filterForm">
    <input type="hidden" name="sort" id="sortInput" value="{{ request('sort') }}">
    <div class="theme-wg-wrap">
        <ul class="theme-toggle-list">
            <li class="theme-toggle-item">
                    <div class="theme-toggle-item-title">
                        <i class="icon-arrow-filter-radop-left" style="transform: rotate(90deg);"></i>
                        <p class="theme-widget-title">
                            {{ __('theme.by-price') }}
                        </p>
                    </div>
                    @php
                        $queryPrice = $query['price'] ?? null;
                        $queryPriceFrom = $query['price']['from'] ?? null;
                        $queryPriceTo = $query['price']['to'] ?? null;

                        $activePriceStyle = 'display: flex';
//                        if (is_array($queryPrice) && ($queryPriceFrom || $queryPriceTo)) {
//                            $activePriceStyle = 'display: flex';
//                        }
                    @endphp
                    <div class="theme-toggle-item-content" style="{{ $activePriceStyle }}; flex-direction: column; gap: 10px;">
                        <div class="filter-widget-wrap">
                            <div class="price-range-wrap">
                                <div class="slider">
                                    <div class="progress"
                                         @if(is_array($queryPrice) && isset($queryPriceFrom) && isset($queryPriceTo))
                                             style="left:{{$queryPriceFrom/10}}%; right:{{100 - $queryPriceTo/10}}%"
                                            @endif
                                    ></div>
                                </div>
                                <div class="range-input">
                                    <input type="range" class="range-min" min="0" max="1000" value="{{ $queryPriceFrom ?? 0 }}" step="1">
                                    <input type="range" class="range-max" min="0" max="1000" value="{{ $queryPriceTo ?? 1000 }}" step="1">
                                </div>
                            </div>

                            <div class="price-input">
                                <div class="field">
                                    <span>{{ __('theme.min') }}</span>
                                    <input type="number" class="input-min" name="filter[price][from]" value="{{ $queryPriceFrom ?? 0 }}">
                                </div>
                                <div class="separator"></div>
                                <div class="field">
                                    <span>{{ __('theme.max') }}</span>
                                    <input type="number" class="input-max" name="filter[price][to]" value="{{ $queryPriceTo ?? 1000 }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @foreach($attributes as $key => $attributeValues)
                    @php
                        $brandNames = ['Бренд', 'Brand', 'Бренд'];
                    @endphp
                    @if(!in_array($key, $brandNames))
                        @continue
                    @endif
                    @php
                        $attributeValues = collect($attributeValues)->map(function($attribute) {
                            $attributeId = is_array($attribute) ? ($attribute['id'] ?? null) : ($attribute->id ?? null);
                            return $attributeId ? app(\App\Repositories\Attribute\AttributeRepository::class)->getAttributeValueById((int)$attributeId) : null;
                        })->filter()->sortBy('value');
                    @endphp

                    @if($attributeValues->count() <= 1)
                        @continue
                    @endif

                    <li class="theme-toggle-item">
                        <div class="theme-toggle-item-title">
                            <i class="icon-arrow-filter-radop-left"></i>
                            <p class="theme-widget-title">{{ $key }}</p>
                        </div>

                        @php
                            $activeStyle = 'display: none';

                            foreach ($attributeValues as $attribute) {
                                if ($attribute && isset($query) && isset($query['attribute']) && is_array($query['attribute']) && array_key_exists($attribute->attribute_onec_id, $query['attribute'])){
                                    $activeStyle = 'display:flex';
                                }
                            }
                        @endphp

                        <div class="theme-toggle-item-content" style="{{ $activeStyle }}">
                            @foreach($attributeValues as $attribute)
                                @if($attribute)
                                    <div class="col-6">
                                        <input type="checkbox" class="theme-checkbox" id="attribute-{{ $attribute->id }}"
                                               name="filter[attribute][{{ $attribute->attribute_onec_id }}][]"
                                               value="{{ str_replace(',', '.', $attribute->value) }}"
                                                {{ isset($query['attribute'][$attribute->attribute_onec_id]) &&
                                                    in_array(str_replace(',', '.', $attribute->value), $query['attribute'][$attribute->attribute_onec_id])
                                                    ? 'checked' : '' }}>
                                        <label for="attribute-{{ $attribute->id }}">{{ $attribute->value }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @endforeach
                @if(isset($brands) && $brands->isNotEmpty())
                    <li class="theme-toggle-item">
                        <div class="theme-toggle-item-title">
                            <i class="icon-arrow-filter-radop-left"></i>
                            <p class="theme-widget-title">{{__('theme.brand')}}</p>
                        </div>
                        <div class="theme-toggle-item-content">
                            @foreach($brands as $brand)
                                <div class="col-6">
                                    <input type="checkbox" class="theme-checkbox" {{isset($query['brand']) && is_array($query['brand']) && in_array($brand->onec_id, $query['brand']) ? 'checked' : ''}} id="brand-{{$brand->onec_id}}" name="filter[brand][]" value="{{$brand->onec_id}}">
                                    <label for="brand-{{$brand->onec_id}}">{{$brand->title}}</label>
                                </div>
                            @endforeach
                        </div>
                    </li>
                @endif
        </ul>
    </div>
    <button type="button" id="filterResetBtn" class="filter-reset-btn">{{__('theme.reset-filters')}}</button>
</form>
@include('frontend.v1.components.brand-filter-ajax', ['existedBrand' => $existedBrand])
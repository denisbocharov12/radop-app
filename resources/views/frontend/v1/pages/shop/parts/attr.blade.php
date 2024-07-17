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

                            <input type="checkbox" class="theme-checkbox" {{isset($query) && isset($query['attribute']) && is_array($query['attribute']) && in_array($attribute->id, $query['attribute']) ? 'checked' : ''}} id="attribute-{{$attribute->id}}" name="filter[attribute][]" value="{{$attribute->id}}">
                            <label for="attribute-{{$attribute->id}}">{{$attribute->value}}</label>
                        @endforeach
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    <div class="filter-widget-wrap filter-wrap-overflow">
        @if(!empty($attributes))
            @foreach($attributes as $key => $attributeValues)
                <p style="font-weight: bold; margin: 5px 0; display: flex; width: 100%">{{$key}}</p>
                @foreach($attributeValues as $attribute)
                    @php
                        $attribute = \App\Models\AttributeValue::find($attribute['id']);

                    @endphp

                    <input type="checkbox" class="theme-checkbox" {{isset($query) && isset($query['attribute']) && is_array($query['attribute']) && in_array($attribute->id, $query['attribute']) ? 'checked' : ''}} id="attribute-{{$attribute->id}}" name="filter[attribute][]" value="{{$attribute->id}}">
                    <label for="attribute-{{$attribute->id}}">{{$attribute->value}}</label>
                @endforeach
            @endforeach
        @endif
    </div>
</div>

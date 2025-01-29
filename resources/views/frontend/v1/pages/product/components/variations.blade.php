@if(isset($product->data->upp_sale) && is_array(json_decode($product->data->upp_sale, true)) && isset($product->characteristic) && is_array(json_decode($product->characteristic, true)))
    <div class="upp-sale-products-wrap">
        @foreach(json_decode($product->data->upp_sale) as $uppSaleProductOnecId)
            @php
                $uppSaleProduct = \App\Models\Product::where('onec_id', $uppSaleProductOnecId)
                             ->where('status', true)
                             ->where('site_status', true)
                             ->first();

                $selectedType = json_decode($product->characteristic)->selected_type;

            @endphp
            @if($selectedType === \App\Enums\ProductCharacteristicTypes::getTextCharacteristicFE())
                <div class="upp-sale-product" data-toggle="tooltip" data-placement="top" title="{{$uppSaleProduct->title}}">
                    <a href="{{route('theme.product.index', $uppSaleProduct->slug)}}" class="product-mini-brand">
                        <span class="upp-sale-product-value-text">
                            {{\App\Models\AttributeValue::where('attribute_onec_id', json_decode($product->characteristic)->character_id)->where('product_onec_id', $uppSaleProductOnecId)->first()?->value}}
                        </span>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
@endif

@if(Auth::guard('user')->user())
    <div class="product-card-summary">
        <p>
            <span class="summary-title">
                {{__('theme.total')}}
            </span>
            <span class="product-card-summary-text" id="product-card-summary-{{$product->onec_id}}">
                @include('frontend.v1.components.product_total')
            </span>
            {{__('theme.MDL')}}
        </p>
    </div>
@endif
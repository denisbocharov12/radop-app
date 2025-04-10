<div class="packages-wrap-min-to-order">
    <p>{{__('theme.package-min-to-order')}}: {{isset($product->packages->where('order_status', true)->first()->value) ? $product->packages->where('order_status', true)->first()->value : $product->packages->sortBy('value')->first()->value}} {{__('theme.min_order_unit')}}</p>
</div>

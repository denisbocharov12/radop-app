<div class="packages-wrap">
    @if(!$product->packages->isEmpty())
        <p>{{__('theme.package')}}: @foreach($product->packages->sortBy('value') as $package){{$package->value}}{{$loop->last ? '' : '/'}}@endforeach {{__('theme.package_unit')}}</p>
    @else
        <p></p>
    @endif
</div>

@if($product->min_order !== null && $product->min_order > 1)
    <div class="packages-wrap-min-to-order">
        <p>{{__('theme.package-min-to-order')}}: {{$product->min_order}} {{__('theme.min_order_unit')}}</p>
    </div>
@endif

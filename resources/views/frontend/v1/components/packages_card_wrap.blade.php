@if(Auth::guard('user')->user() !== null)
    @if(!$product->packages->isEmpty())
        <div class="packages-wrap">
            <p>{{__('theme.package')}}: @foreach($product->packages->sortBy('value') as $package){{$package->value}}{{$loop->last ? '' : '/'}}@endforeach {{__('theme.package_unit')}}</p>
        </div>
        <div class="packages-wrap-min-to-order">
            <p>{{__('theme.package-min-to-order')}}: {{isset($product->packages->where('order_status', true)->first()->value) ? $product->packages->sortBy('value')->first()->value : 1}}</p>
        </div>
    @endif
@endif

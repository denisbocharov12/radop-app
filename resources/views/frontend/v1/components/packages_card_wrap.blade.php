@if(!$product->packages->isEmpty())
    <div class="packages-wrap">
        <p>{{__('theme.package')}}: @foreach($product->packages->sortBy('value') as $package){{$package->value}}{{$loop->last ? '' : '/'}}@endforeach</p>
    </div>
@endif

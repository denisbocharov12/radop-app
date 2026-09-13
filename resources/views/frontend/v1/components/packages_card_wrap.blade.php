{{-- Pack size and minimum order, shown under the price on cards and on the
     product page. Both lines are optional. --}}
@if($product->packages->isNotEmpty() || ($product->min_order !== null && $product->min_order > 1))
    <div class="space-y-0.5 text-2xs italic text-ink-500">
        @if($product->packages->isNotEmpty())
            <p>
                {{ __('theme.package') }}:
                {{ $product->packages->sortBy(static fn ($pack) => (float) $pack->value)->pluck('value')->implode('/') }}
                {{ __('theme.package_unit') }}
            </p>
        @endif

        @if($product->min_order !== null && $product->min_order > 1)
            <p>{{ __('theme.package-min-to-order') }}: {{ $product->min_order }} {{ __('theme.min_order_unit') }}</p>
        @endif
    </div>
@endif

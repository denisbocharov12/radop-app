{{-- Pack size and minimum order, shown under the price on cards and on the
     product page. Both lines are optional. --}}
@if($product->packages->isNotEmpty() || ($product->min_order !== null && $product->min_order > 1))
    <div class="space-y-1 text-xs text-ink-600">
        @if($product->packages->isNotEmpty())
            <p class="flex items-center gap-1.5">
                <x-sf-icon name="box" :size="15" class="shrink-0 text-ink-400" />
                {{ __('theme.package') }}:
                {{ $product->packages->sortBy(static fn ($pack) => (float) $pack->value)->pluck('value')->implode('/') }}
                {{ __('theme.package_unit') }}
            </p>
        @endif

        @if($product->min_order !== null && $product->min_order > 1)
            <p class="flex items-center gap-1.5">
                <x-sf-icon name="cart" :size="15" class="shrink-0 text-ink-400" />
                {{ __('theme.package-min-to-order') }}: {{ $product->min_order }} {{ __('theme.min_order_unit') }}
            </p>
        @endif
    </div>
@endif

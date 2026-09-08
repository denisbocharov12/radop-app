@php
    /*
     * "Continue shopping" rails under the basket.
     *
     * The three lists used to be a jQuery vertical-tab widget wired by index;
     * they are now three plain sections, each a scroll-snap rail of the shared
     * product card. Empty lists are skipped rather than rendering a bare tab.
     */
    $rails = [
        ['title' => __('theme.popular-products'), 'products' => $popularProducts ?? collect(), 'list' => 'cart_popular'],
        ['title' => __('theme.on-discount'), 'products' => $discountProducts ?? collect(), 'list' => 'cart_sale'],
        ['title' => __('theme.recommended'), 'products' => $featuredProducts ?? collect(), 'list' => 'cart_featured'],
    ];
@endphp

@foreach($rails as $rail)
    @continue($rail['products']->isEmpty())
    <section class="sf-section">
        <div class="sf-container" data-sf-rail>
            <div class="sf-section-head">
                <h2 class="sf-section-title">{{ $rail['title'] }}</h2>
                <div class="flex items-center gap-2">
                    <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 lg:inline-flex" data-sf-rail-prev aria-label="←">
                        <x-sf-icon name="chevronLeft" :size="16" />
                    </button>
                    <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 lg:inline-flex" data-sf-rail-next aria-label="→">
                        <x-sf-icon name="chevronRight" :size="16" />
                    </button>
                </div>
            </div>

            <div class="sf-rail">
                @foreach($rail['products'] as $product)
                    <x-sf-product-card :product="$product" :list-id="$rail['list']" :list-name="$rail['title']" />
                @endforeach
            </div>
        </div>
    </section>
@endforeach

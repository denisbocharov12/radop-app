{{-- Лента товаров: новинки, хиты, скидки или любое условие из номенклатуры. --}}
@php($railUrl = $section['link'] ? url($section['link']) : null)
<section class="sf-section" id="{{ $section['anchor'] }}">
    <div class="sf-container" data-sf-rail>
        <div class="sf-section-head">
            <h2 class="sf-section-title">
                @if($railUrl)
                    <a href="{{ $railUrl }}" class="hover:text-brand-600">{{ $section['title'] }}</a>
                @else
                    {{ $section['title'] }}
                @endif
            </h2>
            <div class="flex items-center gap-2">
                @if($railUrl)
                    <a href="{{ $railUrl }}" class="sf-section-link">{{ $section['linkTitle'] ?: __('theme.view-all') }}</a>
                @endif
                <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 lg:inline-flex" data-sf-rail-prev aria-label="←">
                    <x-sf-icon name="chevronLeft" :size="16" />
                </button>
                <button type="button" class="sf-icon-btn hidden h-8 w-8 border border-ink-200 disabled:opacity-30 lg:inline-flex" data-sf-rail-next aria-label="→">
                    <x-sf-icon name="chevronRight" :size="16" />
                </button>
            </div>
        </div>

        @if($section['subtitle'])
            <p class="-mt-2 mb-3 text-sm text-ink-600">{{ $section['subtitle'] }}</p>
        @endif

        <div class="sf-rail">
            @foreach($section['products'] as $product)
                <x-sf-product-card
                    :product="$product"
                    :list-id="$section['settings']['list_id'] ?? ('home_' . $section['id'])"
                    :list-name="$section['settings']['list_name'] ?? ($section['title'] ?? 'Home')"
                />
            @endforeach
        </div>
    </div>
</section>

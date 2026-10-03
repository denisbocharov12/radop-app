{{-- «Сезонные новинки»: фото на фоне, поверх — сплошная маска заданного цвета
     и прозрачности, чтобы заголовок и карточки читались на любом снимке. --}}
@php
    $seasonalUrl = $section['link'] ? url($section['link']) : null;
    $overlay = $section['overlayColor'] ?? '#0b2a4a';
    $opacity = ($section['overlayOpacity'] ?? 55) / 100;
    // heading_style = light — светлый текст поверх тёмной маски.
    $onImage = ($section['headingStyle'] ?? 'light') === 'light';
@endphp
<section
    class="sf-season"
    id="{{ $section['anchor'] }}"
    @if($section['background']) style="background-image: url('{{ $section['background'] }}')" @endif
>
    <div class="sf-season-mask" style="background-color: {{ $overlay }}; opacity: {{ $opacity }}"></div>

    <div class="sf-container relative" data-sf-rail>
        <div class="sf-section-head">
            <h2 @class(['sf-section-title', 'sf-section-title-onimage' => $onImage])>
                @if($seasonalUrl)
                    <a href="{{ $seasonalUrl }}" class="hover:underline">{{ $section['title'] }}</a>
                @else
                    {{ $section['title'] }}
                @endif
            </h2>
            <div class="flex items-center gap-2">
                @if($seasonalUrl)
                    <a href="{{ $seasonalUrl }}" @class(['sf-section-link', 'sf-section-link-onimage' => $onImage])>
                        {{ $section['linkTitle'] ?: __('theme.view-all') }}
                    </a>
                @endif
                <button type="button" @class(['sf-icon-btn hidden h-8 w-8 border disabled:opacity-30 lg:inline-flex', 'border-white/40 text-white hover:bg-white/10' => $onImage, 'border-ink-200' => ! $onImage]) data-sf-rail-prev aria-label="←">
                    <x-sf-icon name="chevronLeft" :size="16" />
                </button>
                <button type="button" @class(['sf-icon-btn hidden h-8 w-8 border disabled:opacity-30 lg:inline-flex', 'border-white/40 text-white hover:bg-white/10' => $onImage, 'border-ink-200' => ! $onImage]) data-sf-rail-next aria-label="→">
                    <x-sf-icon name="chevronRight" :size="16" />
                </button>
            </div>
        </div>

        @if($section['subtitle'])
            <p @class(['-mt-2 mb-3 text-sm', 'text-white/85' => $onImage, 'text-ink-600' => ! $onImage])>{{ $section['subtitle'] }}</p>
        @endif

        <div class="sf-rail">
            @foreach($section['products'] as $product)
                <x-sf-product-card
                    :product="$product"
                    :list-id="$section['settings']['list_id'] ?? ('home_seasonal_' . $section['id'])"
                    :list-name="$section['settings']['list_name'] ?? ($section['title'] ?? 'Home seasonal')"
                />
            @endforeach
        </div>
    </div>
</section>

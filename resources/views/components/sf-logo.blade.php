@props([
    /** `header` scales for the sticky bar; `footer` is larger and always shows the tagline. */
    'variant' => 'header',
    /** `light` — белый локап для тёмной подложки; по умолчанию цветной. */
    'tone' => 'dark',
])

@php
    /*
     * The shipped mark is a 40×35 pentagon whose "RĂDOP" lettering is ~4px
     * tall at header size — illegible. The lockup pairs that mark with a
     * typeset wordmark so the name reads at any size, and the whole thing is
     * configured in config/storefront.php so a new logo is a config change,
     * not a template hunt.
     */
    $logo = config('storefront.logo');
    $full = $tone === 'light'
        ? ($logo['full_light'] ?? $logo['full'] ?? null)
        : ($logo['full'] ?? null);
    // ТЗ 7: в шапке пока без подзаголовка, в подвале оставляем.
    $tagline = $variant === 'footer'
        ? ($logo['tagline'][app()->getLocale()] ?? $logo['tagline']['ro'] ?? null)
        : null;
    $isFooter = $variant === 'footer';
@endphp

<span {{ $attributes->class(['inline-flex shrink-0 items-center', 'gap-2' => ! $isFooter, 'gap-3' => $isFooter]) }}>
    @if(! empty($full))
        {{-- Готовый локап: знак и надпись уже внутри картинки. Подпись в
             подвале выводим рядом, иначе она пропадает вместе с версткой. --}}
        <img
            src="{{ asset($full) }}"
            alt="Radop"
            @class(['w-auto', 'h-10 lg:h-12' => ! $isFooter, 'h-14' => $isFooter])
        />

        @if($tagline)
            <span class="text-xs font-medium text-ink-500">{{ $tagline }}</span>
        @endif
    @else
        <img
            src="{{ asset($logo['mark']) }}"
            alt="{{ $logo['wordmark'] ? '' : 'Radop' }}"
            width="40"
            height="35"
            @class(['w-auto', 'h-9 lg:h-10' => ! $isFooter, 'h-12' => $isFooter])
        />

        @if($logo['wordmark'])
            <span class="flex flex-col leading-none">
                <span @class([
                    'font-extrabold tracking-[0.12em] text-brand-600',
                    'text-lg lg:text-xl' => ! $isFooter,
                    'text-2xl' => $isFooter,
                ])>{{ $logo['wordmark'] }}</span>
                @if($tagline)
                    <span @class([
                        'font-medium text-ink-500',
                        // Phones too, one size down so the header row still fits at 360 px.
                        'mt-0.5 whitespace-nowrap text-[0.625rem] leading-none sm:text-2xs' => ! $isFooter,
                        'mt-1 text-xs' => $isFooter,
                    ])>{{ $tagline }}</span>
                @endif
            </span>
        @endif
    @endif
</span>

@props([
    'score' => 0,
    'size' => 15,
])

@php
    // Five stars, filled up to the rounded half-star. Half stars are drawn by
    // clipping a filled star rather than shipping a third icon.
    $value = max(0, min(5, (float) $score));
@endphp

<div class="flex items-center gap-0.5" role="img" aria-label="{{ number_format($value, 1) }} / 5">
    @for($i = 1; $i <= 5; $i++)
        @php($fill = max(0, min(1, $value - $i + 1)))
        <span class="relative inline-block" style="width: {{ $size }}px; height: {{ $size }}px">
            <x-sf-icon name="star" :size="$size" stroke-width="1.5" class="absolute inset-0 text-ink-200" style="fill: currentColor" />
            @if($fill > 0)
                <span class="absolute inset-0 overflow-hidden" style="width: {{ round($fill * 100) }}%">
                    <x-sf-icon name="star" :size="$size" stroke-width="1.5" class="text-accent-400" style="fill: currentColor" />
                </span>
            @endif
        </span>
    @endfor
</div>

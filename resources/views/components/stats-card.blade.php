@props(['title', 'value', 'icon' => null, 'change' => null, 'changeType' => 'up', 'suffix' => '', 'color' => 'brand'])

@php
    // Literal class strings so Tailwind can detect them
    $palette = [
        'brand'   => ['bg-brand-50',   'text-brand-600'],
        'emerald' => ['bg-emerald-50', 'text-emerald-600'],
        'amber'   => ['bg-amber-50',   'text-amber-600'],
        'red'     => ['bg-red-50',     'text-red-600'],
        'sky'     => ['bg-sky-50',     'text-sky-600'],
        'violet'  => ['bg-violet-50',  'text-violet-600'],
    ];
    [$iconBg, $iconFg] = $palette[$color] ?? $palette['brand'];
@endphp

<div class="stats-card">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="stats-label">{{ $title }}</p>
            <p class="stats-value mt-1 truncate">{{ $value }}{{ $suffix }}</p>
            @if($change)
                <p class="stats-change {{ $changeType === 'up' ? 'text-emerald-600' : 'text-red-600' }}">
                    <i data-lucide="{{ $changeType === 'up' ? 'trending-up' : 'trending-down' }}" class="w-3.5 h-3.5"></i>
                    {{ $change }}
                </p>
            @endif
        </div>
        @if($icon)
            <div class="w-10 h-10 rounded-lg {{ $iconBg }} flex items-center justify-center flex-shrink-0">
                <i data-lucide="{{ $icon }}" class="w-5 h-5 {{ $iconFg }}"></i>
            </div>
        @endif
    </div>
</div>

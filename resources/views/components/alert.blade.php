@props(['type' => 'info'])

@php
    $map = [
        'success' => ['bg-emerald-50', 'border-emerald-200', 'text-emerald-700', 'check-circle'],
        'error'   => ['bg-red-50',     'border-red-200',     'text-red-700',     'alert-circle'],
        'warning' => ['bg-amber-50',   'border-amber-200',   'text-amber-700',   'alert-triangle'],
        'info'    => ['bg-sky-50',     'border-sky-200',     'text-sky-700',     'info'],
    ];
    [$bg, $border, $text, $icon] = $map[$type] ?? $map['info'];
@endphp

<div {{ $attributes->merge(['class' => "flex items-start gap-2 rounded-lg border px-4 py-3 text-sm $bg $border $text"]) }}>
    <i data-lucide="{{ $icon }}" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
    <div class="flex-1">{{ $slot }}</div>
</div>

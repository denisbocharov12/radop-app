@props([
    'name',
    'size' => 20,
    'strokeWidth' => 1.75,
])

@php
    // Same path data the Vue islands use — see resources/js/storefront/lib/icons.js.
    // Cached forever in production; the file only changes on deploy.
    $paths = \Illuminate\Support\Facades\Cache::rememberForever('sf.icons', static function () {
        $file = resource_path('icons/storefront.json');

        return is_file($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
    });

    $path = $paths[$name] ?? null;
@endphp

@if($path)
    <svg
        width="{{ $size }}"
        height="{{ $size }}"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="{{ $strokeWidth }}"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
        focusable="false"
        {{ $attributes->merge(['class' => 'shrink-0']) }}
    >
        <path d="{{ $path }}" />
    </svg>
@endif

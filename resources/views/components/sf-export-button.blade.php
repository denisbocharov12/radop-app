@props([
    'url',
    'personalized' => false,
    'compact' => false,
])

{{--
    "Download catalogue" (Excel). Restores the export link the legacy category
    and shop headers had. The request is JSON (the server builds the file, then
    answers with its URL or a "personalised export started" notice), handled by
    the `[data-sf-export]` delegate in storefront/lib/vitals.js.
--}}
@php
    $label = $personalized ? __('theme.download-personalized-catalog') : __('theme.sf-download-xlsx');
    // Иконка у подраздела: подсказка объясняет, что скачается.
    $tooltip = $compact ? __('theme.sf-download-section-xlsx') : $label;
@endphp

@if($url)
    <a
        href="{{ $url }}"
        data-sf-export
        data-sf-export-personalized="{{ $personalized ? '1' : '0' }}"
        title="{{ $tooltip }}"
        aria-label="{{ $tooltip }}"
        {{ $attributes->class([
            'group/export inline-flex shrink-0 items-center gap-2 rounded-md font-medium transition-colors',
            'h-9 w-9 justify-center text-success-600 hover:bg-success-50' => $compact,
            'h-10 border border-success-500/40 bg-success-50 px-3 text-sm text-success-600 hover:bg-success-600 hover:text-white' => ! $compact,
        ]) }}
    >
        {{-- Spreadsheet glyph, drawn on the shared 24px grid. --}}
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0" data-sf-export-icon>
            <path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z" />
            <path d="M14 3v6h6M8.5 13l3 4.5M11.5 13l-3 4.5M14 17.5h2.5" />
        </svg>
        @unless($compact)
            <span data-sf-export-label>{{ $label }}</span>
        @endunless
    </a>
@endif

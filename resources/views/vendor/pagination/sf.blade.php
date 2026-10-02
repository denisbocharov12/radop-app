@if ($paginator->hasPages())
    <nav class="mt-8 flex flex-wrap items-center justify-center gap-1" role="navigation" aria-label="{{ __('theme.sf-pagination') }}">
        @if ($paginator->onFirstPage())
            <span class="sf-icon-btn cursor-not-allowed opacity-40" aria-disabled="true">
                <x-sf-icon name="chevronLeft" :size="18" />
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="sf-icon-btn border border-ink-200" aria-label="{{ __('theme.sf-page-prev') }}" title="{{ __('theme.sf-page-prev') }}">
                <x-sf-icon name="chevronLeft" :size="18" />
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 text-sm text-ink-500">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-md bg-brand-600 px-3 text-sm font-semibold text-white"
                            aria-current="page"
                        >{{ $page }}</span>
                    @else
                        <a
                            href="{{ $url }}"
                            class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-md border border-ink-200 px-3 text-sm font-medium text-ink-700 transition-colors hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700"
                        >{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="sf-icon-btn border border-ink-200" {{-- Not pagination.next/previous: the ro/ru files set those to '' for the
                 old arrow buttons, which left these links without a name. --}}
            aria-label="{{ __('theme.sf-page-next') }}" title="{{ __('theme.sf-page-next') }}">
                <x-sf-icon name="chevronRight" :size="18" />
            </a>
        @else
            <span class="sf-icon-btn cursor-not-allowed opacity-40" aria-disabled="true">
                <x-sf-icon name="chevronRight" :size="18" />
            </span>
        @endif
    </nav>
@endif

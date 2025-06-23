@if ($paginator->hasPages())
    <nav class="d-flex flex-column flex-md-row justify-items-center justify-content-between">
        <div class="d-flex flex-fill align-items-center justify-content-center justify-content-md-between mb-3 mb-md-0">
            <div class="d-none d-md-block">
                <p class="small text-muted mb-0">
                    {!! __('theme.showing') !!}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('theme.to') !!}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {!! __('theme.of') !!}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('theme.results') !!}
                </p>
            </div>
            <div>
                <ul class="pagination pagination-sm pagination-md-lg mb-0">
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('theme.previous_pagination')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('theme.previous_pagination')">&lsaquo;</a>
                        </li>
                    @endif
                    @php
                        $start = max($paginator->currentPage() - 1, 1);
                        $end = min($paginator->currentPage() + 1, $paginator->lastPage());
                        if ($start <= 2) $start = 1;
                        if ($end >= $paginator->lastPage() - 1) $end = $paginator->lastPage();
                    @endphp
                    @if ($start > 1)
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                        @if ($start > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif
                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    @if ($end < $paginator->lastPage())
                        @if ($end < $paginator->lastPage() - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
                    @endif
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('theme.next_pagination')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('theme.next_pagination')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="d-block d-md-none text-center">
            <p class="small text-muted mb-0">
                {!! __('theme.showing') !!}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('theme.to') !!}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('theme.of') !!}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('theme.results') !!}
            </p>
        </div>
    </nav>
@endif

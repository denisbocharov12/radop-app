@props(['paginator'])

@if($paginator->hasPages())
    @php $paginator->appends(request()->except('page')); @endphp
    <div class="flex items-center justify-between gap-3 px-5 py-4 border-t border-gray-100 text-sm">
        <span class="text-gray-500">Показано {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} из {{ $paginator->total() }}</span>
        <div class="flex items-center gap-1">
            @if($paginator->onFirstPage())
                <span class="btn-secondary btn-sm opacity-40 cursor-not-allowed"><i data-lucide="chevron-left" class="w-4 h-4"></i></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn-secondary btn-sm"><i data-lucide="chevron-left" class="w-4 h-4"></i></a>
            @endif
            <span class="px-3 text-gray-600 whitespace-nowrap">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn-secondary btn-sm"><i data-lucide="chevron-right" class="w-4 h-4"></i></a>
            @else
                <span class="btn-secondary btn-sm opacity-40 cursor-not-allowed"><i data-lucide="chevron-right" class="w-4 h-4"></i></span>
            @endif
        </div>
    </div>
@endif

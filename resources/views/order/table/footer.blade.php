@if($orders->hasPages())
    @php $orders->appends(request()->except('page')); @endphp
    <div class="flex items-center justify-between gap-3 px-5 py-4 border-t border-gray-100 text-sm">
        <span class="text-gray-500">
            Показано {{ $orders->firstItem() }}–{{ $orders->lastItem() }} из {{ $orders->total() }}
        </span>
        <div class="flex items-center gap-1">
            @if($orders->onFirstPage())
                <span class="btn-secondary btn-sm opacity-40 cursor-not-allowed"><i data-lucide="chevron-left" class="w-4 h-4"></i></span>
            @else
                <a href="{{ $orders->previousPageUrl() }}" class="btn-secondary btn-sm"><i data-lucide="chevron-left" class="w-4 h-4"></i></a>
            @endif
            <span class="px-3 text-gray-600 whitespace-nowrap">{{ $orders->currentPage() }} / {{ $orders->lastPage() }}</span>
            @if($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" class="btn-secondary btn-sm"><i data-lucide="chevron-right" class="w-4 h-4"></i></a>
            @else
                <span class="btn-secondary btn-sm opacity-40 cursor-not-allowed"><i data-lucide="chevron-right" class="w-4 h-4"></i></span>
            @endif
        </div>
    </div>
@endif

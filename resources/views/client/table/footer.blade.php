@if($users->hasPages())
    @php $users->appends(request()->except('page')); @endphp
    <div class="flex items-center justify-between gap-3 px-5 py-4 border-t border-gray-100 text-sm">
        <span class="text-gray-500">
            Показано {{ $users->firstItem() }}–{{ $users->lastItem() }} из {{ $users->total() }}
        </span>
        <div class="flex items-center gap-1">
            @if($users->onFirstPage())
                <span class="btn-secondary btn-sm opacity-40 cursor-not-allowed"><i data-lucide="chevron-left" class="w-4 h-4"></i></span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="btn-secondary btn-sm"><i data-lucide="chevron-left" class="w-4 h-4"></i></a>
            @endif
            <span class="px-3 text-gray-600 whitespace-nowrap">{{ $users->currentPage() }} / {{ $users->lastPage() }}</span>
            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="btn-secondary btn-sm"><i data-lucide="chevron-right" class="w-4 h-4"></i></a>
            @else
                <span class="btn-secondary btn-sm opacity-40 cursor-not-allowed"><i data-lucide="chevron-right" class="w-4 h-4"></i></span>
            @endif
        </div>
    </div>
@endif

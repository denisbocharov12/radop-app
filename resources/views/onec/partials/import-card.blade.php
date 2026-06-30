{{--
    Reusable 1C import card.
    Vars: $title, $action (route url), $btn (label)
          $desc (optional), $file (bool, default true), $count (optional int)
          $batch (optional *Batch model exposing ->id), $btnClass (default 'btn-primary')
--}}
@php
    $file = $file ?? true;
    $btnClass = $btnClass ?? 'btn-primary';
    $resolvedBatch = null;
    if (!empty($batch)) {
        $resolvedBatch = \Illuminate\Support\Facades\Bus::findBatch($batch->id);
    }
@endphp
<x-card>
    <h5 class="text-base font-semibold text-gray-900 mb-1">{{ $title }}</h5>
    @if(!empty($desc))
        <p class="text-sm text-gray-500 mb-3">{{ $desc }}</p>
    @endif
    <form action="{{ $action }}" enctype="multipart/form-data" method="POST" class="space-y-3">
        @csrf
        @if($file)
            <input type="file" name="attachment"
                   class="block w-full text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-white hover:file:bg-brand-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
        @endif
        <button type="submit" class="{{ $btnClass }}">
            <i data-lucide="settings" class="w-4 h-4"></i> {{ $btn }}
        </button>
    </form>

    @if($resolvedBatch)
        <div class="mt-4 border-t border-gray-100 pt-4">
            <h6 class="text-sm font-semibold text-gray-800 mb-2">Последний импорт — {{ $resolvedBatch->createdAt }}</h6>
            <dl class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-gray-600 mb-2">
                <div><span class="font-medium text-gray-700">Завершён:</span> {{ $resolvedBatch->finishedAt }}</div>
                <div><span class="font-medium text-gray-700">Ошибки:</span> {{ $resolvedBatch->failedJobs }}</div>
                @if(isset($count))
                    <div><span class="font-medium text-gray-700">Кол-во:</span> {{ $count }}</div>
                @endif
                @if(!empty($totalJobs))
                    <div><span class="font-medium text-gray-700">Всего процессов:</span> {{ $resolvedBatch->totalJobs }}</div>
                @endif
            </dl>
            <div class="h-2.5 w-full overflow-hidden rounded-full bg-gray-100">
                <div class="h-full rounded-full bg-brand-600 transition-all" style="width: {{ $resolvedBatch->progress() }}%"></div>
            </div>
            <p class="mt-1 text-xs text-gray-500">{{ $resolvedBatch->progress() }}%</p>
        </div>
    @endif
</x-card>

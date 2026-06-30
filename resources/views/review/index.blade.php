@extends('v2.layouts.app')

@section('title', 'Отзывы')
@section('breadcrumb')<span class="text-gray-700">Отзывы</span>@endsection

@section('content')
    <x-page-header title="Отзывы" description="Всего: {{ $reviews->total() }} · на модерации: {{ $pendingCount }}">
        <x-slot:actions>
            <a href="{{ route('review.create') }}" class="btn-primary btn-sm"><i data-lucide="plus" class="w-4 h-4"></i> Добавить отзыв</a>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                @include('review.table.content')
            </table>
        </div>
        <x-pager :paginator="$reviews" />
    </div>
@endsection

@section('scripts')
<script>
    $(document).on('change', '.review-status-toggle', function () {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        window.axios.post(@json(route('review.update.status')), { review_id: id, status: status })
            .then(function () { window.Alpine.store('toast').add('Статус отзыва обновлён', 'success'); })
            .catch(function () { window.Alpine.store('toast').add('Ошибка при обновлении статуса', 'error'); });
    });
</script>
@endsection

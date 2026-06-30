@extends('v2.layouts.app')

@section('title', 'Товары')
@section('breadcrumb')<span class="text-gray-700">Товары</span>@endsection

@section('content')
    @php $bulkUrl = \Illuminate\Support\Facades\Route::has('product.products.update-conditions') ? route('product.products.update-conditions') : ''; @endphp

    <x-page-header title="Товары" description="Всего товаров: {{ $products->total() }}">
        <x-slot:actions>
            @if(Route::has('product.export-descriptions'))
                <a href="{{ route('product.export-descriptions') }}" class="btn-secondary btn-sm"><i data-lucide="download" class="w-4 h-4"></i> Экспорт описаний</a>
            @endif
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'product-create')">
                <i data-lucide="plus" class="w-4 h-4"></i> Добавить товар
            </button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    @if(!empty($productErrorsSummary['products']))
        <div class="mb-4 flex items-center justify-between gap-3 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
            <div class="flex items-start gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5"></i>
                <div class="text-sm text-red-700">
                    <p class="font-medium">{{ __('product_errors.panel_heading', ['count' => $productErrorsSummary['products']], 'ru') }}</p>
                    <p class="text-xs mt-1 flex flex-wrap gap-2">
                        <span class="badge badge-danger">{{ __('product_errors.panel_with_critical', ['count' => $productErrorsSummary['products_critical']], 'ru') }}</span>
                        <span class="badge badge-warning">{{ __('product_errors.panel_with_minor', ['count' => $productErrorsSummary['products_minor']], 'ru') }}</span>
                    </p>
                </div>
            </div>
            @if(Route::has('product.errors.index'))
                <a href="{{ route('product.errors.index') }}" class="btn-secondary btn-sm flex-shrink-0"><i data-lucide="eye" class="w-4 h-4"></i> Подробнее</a>
            @endif
        </div>
    @endif

    @if(!isset($query['status']))
        <p class="mb-3 text-xs text-brand-600">По умолчанию показаны товары со статусом выгрузки «Активный».</p>
    @endif

    <div class="card">
        @include('product.table.head')
        <div class="table-wrap">
            <table class="data-table" id="products-table">
                @include('product.table.content')
            </table>
        </div>
        @include('product.table.footer')
    </div>

    @include('product.modal.create')
@endsection

@section('scripts')
<script>
    $(function () {
        var bulkUrl = @json($bulkUrl);

        $('#select-all-products, #select-all-products-head').on('change', function () {
            var c = $(this).is(':checked');
            $('.product-checkbox').prop('checked', c);
            $('#select-all-products, #select-all-products-head').prop('checked', c);
        });
        $(document).on('change', '.product-checkbox', function () {
            var all = $('.product-checkbox').length, sel = $('.product-checkbox:checked').length;
            $('#select-all-products, #select-all-products-head').prop('checked', all > 0 && sel === all);
        });

        $('#bulk-condition-update-btn').on('click', function (e) {
            e.preventDefault();
            if (!bulkUrl) { Swal.fire('Недоступно', 'Функция недоступна', 'info'); return; }
            var ids = $('.product-checkbox:checked').map(function () { return $(this).val(); }).get();
            var condition = $('#bulk-condition-select').val();
            if (!ids.length) { Swal.fire('Ошибка', 'Выберите хотя бы один товар', 'error'); return; }
            if (!condition) { Swal.fire('Ошибка', 'Выберите состояние', 'error'); return; }
            $.ajax({
                url: bulkUrl, type: "POST",
                data: { product_ids: ids, condition: condition, _token: "{{ csrf_token() }}" },
                success: function () {
                    Swal.fire({ title: 'Готово', text: 'Состояние обновлено', icon: 'success', timer: 1500, showConfirmButton: false });
                    setTimeout(function () { location.reload(); }, 1500);
                },
                error: function (xhr) {
                    Swal.fire('Ошибка', (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Произошла ошибка', 'error');
                }
            });
        });
    });
</script>
@endsection

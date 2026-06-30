@extends('v2.layouts.app')

@section('title', 'Просмотры товаров')
@section('breadcrumb')<span class="text-gray-700">Просмотры товаров</span>@endsection

@section('content')
    <x-page-header title="Отчёты по просмотрам товаров" description="Генерация отчётов по просмотрам товаров за период">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" id="generateReport"><i data-lucide="bar-chart-3" class="w-4 h-4"></i> Сгенерировать</button>
            <button type="button" class="btn-success btn-sm" id="exportReport" style="display:none;"><i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Экспорт в Excel</button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card class="mb-6">
        @include('reports.view-count.components.filter-form')
    </x-card>

    <div id="reportResults" style="display:none;" class="mb-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Количество товаров</p><p class="text-2xl font-bold text-brand-700 mt-1" id="productsCount">0</p></div>
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Общие просмотры</p><p class="text-2xl font-bold text-emerald-600 mt-1" id="totalViews">0</p></div>
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Уникальные просмотры</p><p class="text-2xl font-bold text-sky-600 mt-1" id="uniqueViews">0</p></div>
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Период</p><p class="text-base font-semibold text-amber-600 mt-2" id="reportPeriod">—</p></div>
        </div>
    </div>

    <div id="reportTable" style="display:none;">
        <x-card :padding="false">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr><th>ID</th><th>OneC ID</th><th>Название товара</th><th class="text-right">Общие</th><th class="text-right">Уникальные</th><th class="text-right">За период</th><th class="text-right">Точность</th></tr>
                    </thead>
                    <tbody id="reportTableBody"></tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function toggleClearCategory() {
                if ($('#category_id').val()) { $('#clear_category').show(); } else { $('#clear_category').hide(); }
            }
            toggleClearCategory();
            $('#category_id').on('change', function() { toggleClearCategory(); });
            $('#clear_category').click(function(e) { e.preventDefault(); $('#category_id').val('').trigger('change'); });

            $('#generateReport').click(function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const productSearch = $('#product_search').val();
                const categoryId = $('#category_id').val();
                const sortBy = $('#sort_by').val();
                const sortDirection = $('#sort_direction').val();

                if (!startDate || !endDate) { alert('Пожалуйста, выберите даты начала и окончания периода'); return; }

                $.ajax({
                    url: '{{ route("reports.view-count.product.report.generate") }}',
                    method: 'POST',
                    data: {
                        start_date: startDate, end_date: endDate, product_search: productSearch,
                        category_id: categoryId, sort_by: sortBy, sort_direction: sortDirection,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) { displayReport(response.data); $('#exportReport').show(); }
                        else { alert('Ошибка при генерации отчета'); }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMsg = 'Ошибки валидации:\n';
                            Object.keys(xhr.responseJSON.errors).forEach(function(key) { errorMsg += xhr.responseJSON.errors[key].join('\n') + '\n'; });
                            alert(errorMsg);
                        } else { alert('Ошибка при генерации отчета'); }
                    }
                });
            });

            $('#exportReport').click(function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const productSearch = $('#product_search').val();
                const categoryId = $('#category_id').val();
                const sortBy = $('#sort_by').val();
                const sortDirection = $('#sort_direction').val();

                if (!startDate || !endDate) { alert('Пожалуйста, выберите даты начала и окончания периода'); return; }

                const form = $('<form>', { 'method': 'GET', 'action': '{{ route("reports.view-count.product.report.export") }}' });
                form.append($('<input>', { 'type': 'hidden', 'name': '_token', 'value': '{{ csrf_token() }}' }));
                form.append($('<input>', { 'type': 'hidden', 'name': 'start_date', 'value': startDate }));
                form.append($('<input>', { 'type': 'hidden', 'name': 'end_date', 'value': endDate }));
                if (productSearch) { form.append($('<input>', { 'type': 'hidden', 'name': 'product_search', 'value': productSearch })); }
                if (categoryId) { form.append($('<input>', { 'type': 'hidden', 'name': 'category_id', 'value': categoryId })); }
                form.append($('<input>', { 'type': 'hidden', 'name': 'sort_by', 'value': sortBy }));
                form.append($('<input>', { 'type': 'hidden', 'name': 'sort_direction', 'value': sortDirection }));
                $('body').append(form);
                form.submit();
                form.remove();
            });

            function displayReport(data) {
                $('#productsCount').text(data.count);
                $('#totalViews').text(data.total_views);
                $('#uniqueViews').text(data.total_unique_views);
                $('#reportPeriod').text(data.period.start_date + ' - ' + data.period.end_date);

                const tbody = $('#reportTableBody');
                tbody.empty();

                data.products.forEach(function(product) {
                    const row = `
                        <tr>
                            <td>${product.id}</td>
                            <td>${product.onec_id || '-'}</td>
                            <td>${product.title}</td>
                            <td class="text-right">${product.total_views}</td>
                            <td class="text-right">${product.unique_views}</td>
                            <td class="text-right">${product.period_views}</td>
                            <td class="text-right">${product.views_per_unit}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });

                $('#reportResults').show();
                $('#reportTable').show();
            }
        });
    </script>
@endsection

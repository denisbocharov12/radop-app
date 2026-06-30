@extends('v2.layouts.app')

@section('title', 'Просмотры брендов')
@section('breadcrumb')<span class="text-gray-700">Просмотры брендов</span>@endsection

@section('content')
    <x-page-header title="Отчёты по просмотрам брендов" description="Генерация отчётов по просмотрам брендов за период">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" id="generateReport"><i data-lucide="bar-chart-3" class="w-4 h-4"></i> Сгенерировать</button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card class="mb-6">
        @include('reports.view-count.components.filter-form-brand')
    </x-card>

    <div id="reportResults" style="display:none;" class="mb-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Количество брендов</p><p class="text-2xl font-bold text-brand-700 mt-1" id="brandsCount">0</p></div>
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
                        <tr><th>ID</th><th>OneC ID</th><th>Название бренда</th><th class="text-right">Общие</th><th class="text-right">Уникальные</th><th class="text-right">За период</th><th class="text-right">Точность</th></tr>
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
            $('#generateReport').click(function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const brandId = $('#brand_id').val();

                if (!startDate || !endDate) { alert('Пожалуйста, выберите даты начала и окончания периода'); return; }

                $.ajax({
                    url: '{{ route("reports.view-count.brand.report.generate") }}',
                    method: 'POST',
                    data: { start_date: startDate, end_date: endDate, brand_id: brandId, _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) { displayReport(response.data); }
                        else { alert('Ошибка при генерации отчета'); }
                    },
                    error: function() { alert('Ошибка при генерации отчета'); }
                });
            });

            function displayReport(data) {
                $('#brandsCount').text(data.count);
                $('#totalViews').text(data.total_views);
                $('#uniqueViews').text(data.total_unique_views);
                $('#reportPeriod').text(data.period.start_date + ' - ' + data.period.end_date);

                const tbody = $('#reportTableBody');
                tbody.empty();

                data.brands.forEach(function(brand) {
                    const row = `
                        <tr>
                            <td>${brand.id}</td>
                            <td>${brand.onec_id || '-'}</td>
                            <td>${brand.title}</td>
                            <td class="text-right">${brand.total_views}</td>
                            <td class="text-right">${brand.unique_views}</td>
                            <td class="text-right">${brand.period_views}</td>
                            <td class="text-right">${brand.views_per_unit}</td>
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

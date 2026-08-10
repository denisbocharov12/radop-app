@extends('v2.layouts.app')

@section('title', 'Просмотры категорий')
@section('breadcrumb')<span class="text-gray-700">Просмотры категорий</span>@endsection

@section('content')
    <x-page-header title="Отчёты по просмотрам категорий" description="Генерация отчётов по просмотрам категорий за период">
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
        @include('reports.view-count.components.filter-form-category')
    </x-card>

    <div id="reportResults" style="display:none;" class="mb-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Количество категорий</p><p class="text-2xl font-bold text-brand-700 mt-1" id="categoriesCount">0</p></div>
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Общие просмотры</p><p class="text-2xl font-bold text-emerald-600 mt-1" id="totalViews">0</p></div>
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Уникальные просмотры</p><p class="text-2xl font-bold text-sky-600 mt-1" id="uniqueViews">0</p></div>
            <div class="card p-4 text-center"><p class="text-sm text-gray-500">Период</p><p class="text-base font-semibold text-amber-600 mt-2" id="reportPeriod">—</p></div>
        </div>
    </div>

    <div id="reportCharts" style="display:none;" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <x-card>
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Активность просмотров по дням</h3>
            <canvas id="viewsTrendChart" height="120"></canvas>
        </x-card>
        <x-card>
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Топ-10 категорий по просмотрам</h3>
            <canvas id="viewsTopChart" height="120"></canvas>
        </x-card>
    </div>

    <div id="reportTable" style="display:none;">
        <x-card :padding="false">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr><th>ID</th><th>OneC ID</th><th>Название категории</th><th class="text-right">Общие</th><th class="text-right">Уникальные</th><th class="text-right">За период</th><th class="text-right">Точность</th></tr>
                    </thead>
                    <tbody id="reportTableBody"></tbody>
                </table>
            </div>
        </x-card>
        <div id="reportPagination" class="flex flex-wrap items-center justify-between gap-3 mt-4"></div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var PER_PAGE = 25;

            function loadReport(page) {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                if (!startDate || !endDate) { alert('Пожалуйста, выберите даты начала и окончания периода'); return; }

                $.ajax({
                    url: '{{ route("reports.view-count.category.report.generate") }}',
                    method: 'POST',
                    data: { start_date: startDate, end_date: endDate, category_id: $('#category_id').val(), page: page || 1, per_page: PER_PAGE, _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) { displayReport(response.data); }
                        else { alert('Ошибка при генерации отчета'); }
                    },
                    error: function() { alert('Ошибка при генерации отчета'); }
                });
            }

            $('#generateReport').click(function() { loadReport(1); });

            function renderPagination(data) {
                var p = data.pagination || { current_page: 1, last_page: 1, per_page: PER_PAGE, total: data.count || 0 };
                var el = $('#reportPagination').empty();
                var from = p.total === 0 ? 0 : (p.current_page - 1) * p.per_page + 1;
                var to = Math.min(p.current_page * p.per_page, p.total);
                el.append('<span class="text-sm text-gray-500">Показано ' + from + '–' + to + ' из ' + p.total + '</span>');
                if (p.last_page <= 1) { return; }
                var nav = $('<div class="flex items-center gap-1"></div>');
                function btn(label, page, disabled, active) {
                    var b = $('<button type="button" class="btn-sm ' + (active ? 'btn-primary' : 'btn-secondary') + '">' + label + '</button>');
                    if (disabled) { b.prop('disabled', true).addClass('opacity-50'); } else { b.on('click', function () { loadReport(page); }); }
                    return b;
                }
                nav.append(btn('‹', p.current_page - 1, p.current_page <= 1, false));
                var start = Math.max(1, p.current_page - 2), end = Math.min(p.last_page, p.current_page + 2);
                for (var i = start; i <= end; i++) { nav.append(btn(i, i, false, i === p.current_page)); }
                nav.append(btn('›', p.current_page + 1, p.current_page >= p.last_page, false));
                el.append(nav);
            }

            function displayReport(data) {
                $('#categoriesCount').text(data.count);
                $('#totalViews').text(data.total_views);
                $('#uniqueViews').text(data.total_unique_views);
                $('#reportPeriod').text(data.period.start_date + ' - ' + data.period.end_date);

                const tbody = $('#reportTableBody');
                tbody.empty();

                data.categories.forEach(function(category) {
                    const row = `
                        <tr>
                            <td>${category.id}</td>
                            <td>${category.onec_id || '-'}</td>
                            <td>${category.name}</td>
                            <td class="text-right">${category.total_views}</td>
                            <td class="text-right">${category.unique_views}</td>
                            <td class="text-right">${category.period_views}</td>
                            <td class="text-right">${category.views_per_unit}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });

                renderPagination(data);
                renderCharts(data);

                $('#reportResults').show();
                $('#reportTable').show();
            }

            var trendChart = null, topChart = null;
            function renderCharts(data) {
                if (typeof Chart === 'undefined') { return; }
                var series = data.series || [];
                if (trendChart) { trendChart.destroy(); }
                trendChart = new Chart(document.getElementById('viewsTrendChart'), {
                    type: 'line',
                    data: { labels: series.map(function (p) { return p.date; }), datasets: [
                        { label: 'Просмотры', data: series.map(function (p) { return p.views; }), borderColor: '#059669', backgroundColor: 'rgba(5,150,105,.1)', tension: .3, fill: true },
                        { label: 'Уникальные', data: series.map(function (p) { return p.uniques; }), borderColor: '#0284c7', backgroundColor: 'rgba(2,132,199,.08)', tension: .3, fill: true }
                    ]},
                    options: { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } }
                });
                var top = data.top || [];
                if (topChart) { topChart.destroy(); }
                topChart = new Chart(document.getElementById('viewsTopChart'), {
                    type: 'bar',
                    data: { labels: top.map(function (c) { return (c.name || '').substring(0, 28); }),
                        datasets: [{ label: 'Просмотры', data: top.map(function (c) { return c.total_views; }), backgroundColor: '#0068a7' }] },
                    options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } }
                });
                $('#reportCharts').show();
            }
        });
    </script>
@endsection

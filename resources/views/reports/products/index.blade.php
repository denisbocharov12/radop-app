@extends('v2.layouts.app')

@section('title', 'Отчёт по товарам')
@section('breadcrumb')<span class="text-gray-700">Отчёт по товарам</span>@endsection

@section('content')
    <x-page-header title="Отчёт по товарам" description="Продажи товаров за период (от самых продаваемых)">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" id="generateReport"><i data-lucide="bar-chart-3" class="w-4 h-4"></i> Сгенерировать</button>
            <button type="button" class="btn-success btn-sm" id="downloadReport"><i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Скачать Excel</button>
        </x-slot:actions>
    </x-page-header>

    <x-card class="mb-6">
        <form id="reportForm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label" for="start_date">Дата начала периода</label>
                    <input type="date" class="form-input" id="start_date" name="start_date" required>
                </div>
                <div>
                    <label class="form-label" for="end_date">Дата окончания периода</label>
                    <input type="date" class="form-input" id="end_date" name="end_date" required>
                </div>
                <div>
                    <label class="form-label" for="onec_id">Код товара (необязательно)</label>
                    <input type="text" class="form-input" id="onec_id" name="onec_id" placeholder="onec_id">
                </div>
            </div>
        </form>
    </x-card>

    <div id="reportResults" style="display:none;">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Кол-во продаж (шт)</p>
                <p class="text-2xl font-bold text-brand-700 mt-1" id="totalQuantity">0</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Сумма продаж</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1" id="totalSum">0 MDL</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Период</p>
                <p class="text-base font-semibold text-sky-600 mt-2" id="reportPeriod">—</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Позиций товаров</p>
                <p class="text-2xl font-bold text-amber-600 mt-1" id="productsCount">0</p>
            </div>
        </div>

        <x-card :padding="false">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr><th>№</th><th>Код товара</th><th>Название</th><th class="text-right">Кол-во продаж</th><th class="text-right">Сумма продаж</th></tr>
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
        $('#generateReport').click(function() { generateReport(); });
        $('#downloadReport').click(function() { downloadReport(); });

        function generateReport() {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();
            const onecId = $('#onec_id').val();

            if (!startDate || !endDate) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните даты начала и окончания периода', 'error');
                return;
            }
            if (new Date(startDate) > new Date(endDate)) {
                Swal.fire('Ошибка', 'Дата начала не может быть больше даты окончания', 'error');
                return;
            }

            $.ajax({
                url: '{{ route("reports.products.generate") }}',
                type: 'POST',
                data: { start_date: startDate, end_date: endDate, onec_id: onecId || '', _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        displayReportResults(response.data);
                        Swal.fire('Успешно', 'Отчет сгенерирован', 'success');
                    } else {
                        Swal.fire('Ошибка', 'Не удалось сгенерировать отчет', 'error');
                    }
                },
                error: function(xhr) {
                    let message = 'Произошла ошибка при генерации отчета';
                    if (xhr.responseJSON && xhr.responseJSON.message) { message = xhr.responseJSON.message; }
                    Swal.fire('Ошибка', message, 'error');
                }
            });
        }

        function downloadReport() {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();
            const onecId = $('#onec_id').val();

            if (!startDate || !endDate) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните даты начала и окончания периода', 'error');
                return;
            }
            if (new Date(startDate) > new Date(endDate)) {
                Swal.fire('Ошибка', 'Дата начала не может быть больше даты окончания', 'error');
                return;
            }

            const url = '{{ route("reports.products.download") }}' +
                '?start_date=' + encodeURIComponent(startDate) +
                '&end_date=' + encodeURIComponent(endDate) +
                '&onec_id=' + encodeURIComponent(onecId || '');

            window.open(url, '_blank');
        }

        function displayReportResults(data) {
            $('#totalQuantity').text(data.total_quantity);
            $('#totalSum').text(formatCurrency(data.total_sum) + ' MDL');
            $('#reportPeriod').text(data.period.start_date + ' - ' + data.period.end_date);
            $('#productsCount').text(data.count);

            const tbody = $('#reportTableBody');
            tbody.empty();

            if (data.products && data.products.length > 0) {
                data.products.forEach(function(row) {
                    const tr = `
                        <tr>
                            <td>${row.number}</td>
                            <td>${row.onec_id || '-'}</td>
                            <td>${escapeHtml(row.title)}</td>
                            <td class="text-right">${row.total_quantity}</td>
                            <td class="text-right">${formatCurrency(row.total_sum)}</td>
                        </tr>
                    `;
                    tbody.append(tr);
                });
            } else {
                tbody.append('<tr><td colspan="5" class="text-center py-6 text-gray-400">Нет данных для отображения</td></tr>');
            }

            $('#reportResults').show();
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    });
    </script>
@endsection

@extends('v2.layouts.app')

@section('title', 'Отчёты по статусам')
@section('breadcrumb')<span class="text-gray-700">Отчёты по статусам</span>@endsection

@section('content')
    <x-page-header title="Отчёты по заказам по статусам" description="Генерация отчётов по статусам заказов за период">
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
                    <label class="form-label" for="status_id">Статус</label>
                    <select class="form-select js-select2" id="status_id" name="status_id">
                        <option value="">Все статусы</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </x-card>

    <div id="reportResults" style="display:none;">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Общая сумма</p>
                <p class="text-2xl font-bold text-brand-700 mt-1" id="totalSum">0 MDL</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Количество заказов</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1" id="totalCount">0</p>
            </div>
        </div>

        <x-card :padding="false">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr><th>№</th><th>ID</th><th>Клиент</th><th>Фискальный код</th><th>Дата</th><th>Город</th><th>Филиал</th><th class="text-right">Сумма</th></tr>
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
            const statusId = $('#status_id').val();

            if (!startDate || !endDate) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните все поля', 'error');
                return;
            }

            $.ajax({
                url: '{{ route("reports.orders-status.generate") }}',
                type: 'POST',
                data: { start_date: startDate, end_date: endDate, status_id: statusId, _token: '{{ csrf_token() }}' },
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
            const statusId = $('#status_id').val();

            if (!startDate || !endDate) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните все поля', 'error');
                return;
            }

            const url = '{{ route("reports.orders-status.download") }}' +
                    '?start_date=' + encodeURIComponent(startDate) +
                    '&end_date=' + encodeURIComponent(endDate) +
                    '&status_id=' + encodeURIComponent(statusId);

            window.open(url, '_blank');
        }

        function displayReportResults(data) {
            $('#totalSum').text(formatCurrency(data.total_sum) + ' MDL');
            $('#totalCount').text(data.count);

            const tbody = $('#reportTableBody');
            tbody.empty();

            if (data.orders && data.orders.length > 0) {
                data.orders.forEach(function(order) {
                    const row = `
                        <tr>
                            <td>${order.number}</td>
                            <td>${order.id}</td>
                            <td>${order.client}</td>
                            <td>${order.fisc_code}</td>
                            <td>${order.date}</td>
                            <td>${order.city}</td>
                            <td>${order.filial}</td>
                            <td class="text-right">${formatCurrency(order.sum)}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            } else {
                tbody.append('<tr><td colspan="8" class="text-center py-6 text-gray-400">Нет данных для отображения</td></tr>');
            }

            $('#reportResults').show();
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
        }
    });
    </script>
@endsection

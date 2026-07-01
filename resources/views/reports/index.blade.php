@extends('v2.layouts.app')

@section('title', 'Отчёты по заказам')
@section('breadcrumb')<span class="text-gray-700">Отчёты по заказам</span>@endsection

@section('content')
    <x-page-header title="Отчёты по заказам" description="Генерация отчётов по заказам за выбранный период">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" id="generateReport"><i data-lucide="bar-chart-3" class="w-4 h-4"></i> Сгенерировать</button>
            <button type="button" class="btn-success btn-sm" id="downloadReport"><i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Скачать Excel</button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <x-card class="mb-6">
        @include('reports.components.filter-form', ['groupByClientsOption' => true])
    </x-card>

    <div id="reportResults" style="display:none;" class="mb-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Количество заказов</p>
                <p class="text-2xl font-bold text-brand-700 mt-1" id="ordersCount">0</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Общая сумма</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1" id="totalSum">0</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Период</p>
                <p class="text-base font-semibold text-sky-600 mt-2" id="reportPeriod">—</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Менеджер</p>
                <p class="text-base font-semibold text-amber-600 mt-2" id="reportManager">Все</p>
            </div>
        </div>
    </div>

    <div id="reportTable" style="display:none;">
        <x-card :padding="false">
            <div class="table-wrap">
                <table class="data-table">
                    <thead id="reportTableHead">
                        <tr><th>№</th><th>ID</th><th>Клиент</th><th>Дата</th><th>Город</th><th>Филиал</th><th class="text-right">Сумма</th></tr>
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
            // #user_id (.js-select2) is already initialised by the global select2
            // helper (with a dropdownParent). Re-calling .select2() double-inits it
            // and leaves the raw <select>. Only init anything the helper missed.
            $('.js-select2').not('.select2-hidden-accessible').each(function () {
                var $el = $(this), $p = $el.parent();
                $p.css('position', 'relative');
                $el.select2({ width: '100%', dropdownParent: $p });
            });

            $('#generateReport').on('click', function() {
                generateReport();
            });

            $('#downloadReport').on('click', function() {
                downloadReport();
            });

            function generateReport() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const userId = $('#user_id').val();

                if (!startDate || !endDate) {
                    Swal.fire('Ошибка', 'Пожалуйста, заполните даты начала и окончания периода', 'error');
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    Swal.fire('Ошибка', 'Дата начала не может быть больше даты окончания', 'error');
                    return;
                }

                $.ajax({
                    url: '{{ route("reports.orders.generate") }}',
                    type: 'POST',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        user_id: userId,
                        group_by_clients: $('#group_by_clients').is(':checked') ? 1 : 0,
                        _token: '{{ csrf_token() }}'
                    },
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
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire('Ошибка', message, 'error');
                    }
                });
            }

            function downloadReport() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const userId = $('#user_id').val();

                if (!startDate || !endDate) {
                    Swal.fire('Ошибка', 'Пожалуйста, заполните даты начала и окончания периода', 'error');
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    Swal.fire('Ошибка', 'Дата начала не может быть больше даты окончания', 'error');
                    return;
                }

                const form = $('<form>', {
                    method: 'GET',
                    action: '{{ route("reports.orders.download") }}',
                    target: '_blank'
                });

                form.append($('<input>', { type: 'hidden', name: 'start_date', value: startDate }));
                form.append($('<input>', { type: 'hidden', name: 'end_date', value: endDate }));
                form.append($('<input>', { type: 'hidden', name: 'user_id', value: userId }));
                form.append($('<input>', { type: 'hidden', name: 'group_by_clients', value: $('#group_by_clients').is(':checked') ? 1 : 0 }));
                form.append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }));

                $('body').append(form);
                form.submit();
                form.remove();
            }

            function displayReportResults(data) {
                $('#ordersCount').text(data.count);
                $('#totalSum').text(formatNumber(data.total_sum));
                $('#reportPeriod').text(data.period.start_date + ' - ' + data.period.end_date);

                const managerName = $('#user_id option:selected').text();
                $('#reportManager').text(managerName || 'Все менеджеры');

                if (data.grouped) {
                    renderGroupedTable(data.groups || []);
                } else {
                    renderFlatTable(data.orders || []);
                }

                $('#reportResults').show();
                $('#reportTable').show();
            }

            function renderFlatTable(orders) {
                var head = '<tr><th>№</th><th>ID</th><th>Клиент</th><th>Дата</th><th>Город</th><th>Филиал</th><th>Сумма</th></tr>';
                var body = '';
                orders.forEach(function(order) {
                    body += '<tr>'
                        + '<td>' + esc(order.number) + '</td>'
                        + '<td>' + esc(order.id) + '</td>'
                        + '<td>' + esc(order.client) + '</td>'
                        + '<td>' + esc(order.date) + '</td>'
                        + '<td>' + esc(order.city) + '</td>'
                        + '<td>' + esc(order.filial) + '</td>'
                        + '<td>' + formatNumber(order.sum) + '</td>'
                        + '</tr>';
                });
                $('#reportTableHead').html(head);
                $('#reportTableBody').html(body);
            }

            function renderGroupedTable(groups) {
                var head = '<tr><th>№</th><th>ID</th><th>Клиент</th><th>Фискальный код</th><th>Период</th><th>Сумма</th></tr>';
                var body = '';
                groups.forEach(function(group) {
                    (group.orders || []).forEach(function(order) {
                        body += '<tr>'
                            + '<td>' + esc(order.number) + '</td>'
                            + '<td>' + esc(order.id) + '</td>'
                            + '<td>' + esc(group.client) + '</td>'
                            + '<td>' + esc(group.fisc_code) + '</td>'
                            + '<td>' + esc(order.date) + '</td>'
                            + '<td>' + formatNumber(order.sum) + '</td>'
                            + '</tr>';
                    });
                    body += '<tr class="fw-bold" style="background:#d9f2e6;">'
                        + '<td></td><td></td>'
                        + '<td>' + esc(group.client) + '</td>'
                        + '<td>' + esc(group.fisc_code) + '</td>'
                        + '<td>' + esc(group.period) + '</td>'
                        + '<td>' + formatNumber(group.total) + '</td>'
                        + '</tr>';
                });
                $('#reportTableHead').html(head);
                $('#reportTableBody').html(body);
            }

            function esc(value) {
                return $('<div>').text(value === null || value === undefined ? '' : value).html();
            }

            function formatNumber(value) {
                var num = parseFloat(value);
                if (isNaN(num)) {
                    num = 0;
                }
                var parts = num.toFixed(2).split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                return parts[0] + ',' + parts[1];
            }
        });
    </script>
@endsection

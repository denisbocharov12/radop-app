@extends('v1.layouts.layout')

@section('content')
    <!-- content @s -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Отчеты по заказам</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Генерация отчетов по заказам за выбранный период</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li><button type="button" class="btn btn-primary" id="generateReport"><em class="icon ni ni-download-cloud"></em><span>Сгенерировать отчет</span></button></li>
                                            <li><button type="button" class="btn btn-success" id="downloadReport"><em class="icon ni ni-file-docs"></em><span>Скачать Excel</span></button></li>
                                        </ul>
                                    </div>
                                </div><!-- .toggle-wrap -->
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    @include('v1.errors.errors')

                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner">
                                @include('reports.components.filter-form', ['groupByClientsOption' => true])
                            </div>
                        </div>
                    </div>

                    <div class="nk-block" id="reportResults" style="display: none;">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <h5 class="card-title">Результаты отчета</h5>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="text-center">
                                                            <h6 class="text-muted">Количество заказов</h6>
                                                            <h3 class="text-primary" id="ordersCount">0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="text-center">
                                                            <h6 class="text-muted">Общая сумма</h6>
                                                            <h3 class="text-success" id="totalSum">0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="text-center">
                                                            <h6 class="text-muted">Период</h6>
                                                            <h6 class="text-info" id="reportPeriod">-</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="text-center">
                                                            <h6 class="text-muted">Менеджер</h6>
                                                            <h6 class="text-warning" id="reportManager">Все</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block" id="reportTable" style="display: none;">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead id="reportTableHead">
                                            <tr>
                                                <th>№</th>
                                                <th>ID</th>
                                                <th>Клиент</th>
                                                <th>Дата</th>
                                                <th>Город</th>
                                                <th>Филиал</th>
                                                <th>Сумма</th>
                                            </tr>
                                        </thead>
                                        <tbody id="reportTableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2();

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

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'start_date',
                    value: startDate
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'end_date',
                    value: endDate
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'user_id',
                    value: userId
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'group_by_clients',
                    value: $('#group_by_clients').is(':checked') ? 1 : 0
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: '{{ csrf_token() }}'
                }));

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

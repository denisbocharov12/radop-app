@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Отчеты по заказам по городу</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Генерация отчетов по заказам по городу за выбранный период</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li><button type="button" class="btn btn-primary" id="generateReport"><em class="icon ni ni-download-cloud"></em><span>Сгенерировать отчет</span></button></li>
                                            <li><button type="button" class="btn btn-success" id="downloadReport"><em class="icon ni ni-file-docs"></em><span>Скачать Excel</span></button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block">
                        <div class="card">
                            <div class="card-inner">
                                <form id="reportForm">
                                    <div class="row g-4">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="start_date">Дата начала периода</label>
                                                <div class="form-control-wrap">
                                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="end_date">Дата окончания периода</label>
                                                <div class="form-control-wrap">
                                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="city_id">Город</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" id="city_id" name="city_id">
                                                        <option value="">Все города</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block" id="reportResults" style="display: none;">
                        <div class="card">
                            <div class="card-inner">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="stat-card bg-primary bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Общая сумма</div>
                                                <div class="stat-card-value h3 fw-bold text-primary" id="totalSum">0 MDL</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="stat-card bg-success bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Количество заказов</div>
                                                <div class="stat-card-value h3 fw-bold text-success" id="totalCount">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-inner">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>ID</th>
                                                <th>Клиент</th>
                                                <th>Фискальный код</th>
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
@endsection

@section('scripts')
    <script>
    $(document).ready(function() {
        $('#generateReport').click(function() {
            generateReport();
        });

        $('#downloadReport').click(function() {
            downloadReport();
        });

        function generateReport() {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();
            const cityId = $('#city_id').val();

            if (!startDate || !endDate) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните все поля', 'error');
                return;
            }

            $.ajax({
                url: '{{ route("reports.orders-city.generate") }}',
                type: 'POST',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    city_id: cityId,
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
            const cityId = $('#city_id').val();

            if (!startDate || !endDate) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните все поля', 'error');
                return;
            }

            const url = '{{ route("reports.orders-city.download") }}' +
                       '?start_date=' + encodeURIComponent(startDate) +
                       '&end_date=' + encodeURIComponent(endDate) +
                       '&city_id=' + encodeURIComponent(cityId);

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
                        <td>${formatCurrency(order.sum)}</td>
                    </tr>
                `;
                tbody.append(row);
            });
                    } else {
            tbody.append('<tr><td colspan="8" class="text-center">Нет данных для отображения</td></tr>');
        }

            $('#reportResults').show();
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('ru-RU', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }
    });
    </script>
@endsection

@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Отчет по товарам</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Генерация отчета по продажам товаров за выбранный период (от самых продаваемых)</p>
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
                                                <label class="form-label" for="onec_id">Код товара (необязательно)</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="onec_id" name="onec_id" placeholder="onec_id">
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
                                    <div class="col-md-3">
                                        <div class="stat-card bg-primary bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Кол-во продаж (шт)</div>
                                                <div class="stat-card-value h3 fw-bold text-primary" id="totalQuantity">0</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card bg-success bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Сумма продаж</div>
                                                <div class="stat-card-value h3 fw-bold text-success" id="totalSum">0 MDL</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card bg-info bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Период</div>
                                                <div class="stat-card-value h6 fw-bold text-info" id="reportPeriod">-</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-card bg-warning bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Позиций товаров</div>
                                                <div class="stat-card-value h3 fw-bold text-warning" id="productsCount">0</div>
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
                                                <th>Код товара</th>
                                                <th>Название</th>
                                                <th>Кол-во продаж</th>
                                                <th>Сумма продаж</th>
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
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    onec_id: onecId || '',
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
                            <td>${row.total_quantity}</td>
                            <td>${formatCurrency(row.total_sum)}</td>
                        </tr>
                    `;
                    tbody.append(tr);
                });
            } else {
                tbody.append('<tr><td colspan="5" class="text-center">Нет данных для отображения</td></tr>');
            }

            $('#reportResults').show();
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('ru-RU', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    });
    </script>
@endsection

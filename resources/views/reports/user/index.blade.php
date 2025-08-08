@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Отчеты по пользователям</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Генерация отчетов по заказам пользователей за выбранный период</p>
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
                                                <label class="form-label" for="user_id">Пользователь</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" id="user_id" name="user_id" required data-placeholder="Выберите пользователя">
                                                        <option value="">Выберите пользователя</option>
                                                        @foreach($users as $user)
                                                            @php
                                                                $displayName = $user->name;
                                                                if ($user->profile) {
                                                                    if ($user->type && $user->type->key_name === 'fiz') {
                                                                        $displayName = $user->profile->fio ?? ($user->profile->first_name . ' ' . $user->profile->last_name) ?? $user->name;
                                                                    } else {
                                                                        $displayName = $user->profile->organization_name . ' ( Фиск. Код.: ' . $user->profile->cod_fiscal . ' )';
                                                                    }
                                                                }
                                                            @endphp
                                                            <option value="{{ $user->id }}">{{ $displayName }}</option>
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
                                    <div class="col-md-4">
                                        <div class="stat-card bg-primary bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Общая сумма</div>
                                                <div class="stat-card-value h3 fw-bold text-primary" id="totalSum">0 MDL</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="stat-card bg-success bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Количество позиций</div>
                                                <div class="stat-card-value h3 fw-bold text-success" id="totalCount">0</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="stat-card bg-info bg-opacity-10 rounded p-3">
                                            <div class="stat-card-info text-center">
                                                <div class="stat-card-label text-muted mb-2">Общее количество товаров</div>
                                                <div class="stat-card-value h3 fw-bold text-info" id="totalQuantity">0</div>
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
                                                <th>Код товара</th>
                                                <th>Наименование товара</th>
                                                <th>Цена</th>
                                                <th>Кол-во</th>
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
            const userId = $('#user_id').val();

            if (!startDate || !endDate || !userId) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните все поля', 'error');
                return;
            }

            $.ajax({
                url: '{{ route("reports.users.generate") }}',
                type: 'POST',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    user_id: userId,
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

            if (!startDate || !endDate || !userId) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните все поля', 'error');
                return;
            }

            const url = '{{ route("reports.users.download") }}' +
                       '?start_date=' + encodeURIComponent(startDate) +
                       '&end_date=' + encodeURIComponent(endDate) +
                       '&user_id=' + encodeURIComponent(userId);

            window.open(url, '_blank');
        }

        function displayReportResults(data) {
            $('#totalSum').text(formatCurrency(data.total_sum) + ' MDL');
            $('#totalCount').text(data.count);
            $('#totalQuantity').text(data.total_quantity || 0);

            const tbody = $('#reportTableBody');
            tbody.empty();

            if (data.items && data.items.length > 0) {
                data.items.forEach(function(item) {
                    const row = `
                        <tr>
                            <td>${item.onec_id}</td>
                            <td>${item.product_name}</td>
                            <td>${formatCurrency(item.price)} MDL</td>
                            <td>${item.quantity}</td>
                            <td>${formatCurrency(item.sum)} MDL</td>
                        </tr>
                    `;
                    tbody.append(row);
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
    });
    </script>
@endsection

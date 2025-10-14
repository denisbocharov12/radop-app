@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Отчеты по просмотрам товаров</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Генерация отчетов по просмотрам товаров за выбранный период</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li><button type="button" class="btn btn-primary" id="generateReport"><em class="icon ni ni-reports"></em><span>Сгенерировать отчет</span></button></li>
                                            <li><button type="button" class="btn btn-success" id="exportReport" style="display: none;"><em class="icon ni ni-download-cloud"></em><span>Экспорт в Excel</span></button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('v1.errors.errors')

                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner">
                                @include('reports.view-count.components.filter-form')
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
                                                            <h6 class="text-muted">Количество товаров</h6>
                                                            <h3 class="text-primary" id="productsCount">0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="text-center">
                                                            <h6 class="text-muted">Общие просмотры</h6>
                                                            <h3 class="text-success" id="totalViews">0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="text-center">
                                                            <h6 class="text-muted">Уникальные просмотры</h6>
                                                            <h3 class="text-info" id="uniqueViews">0</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="text-center">
                                                            <h6 class="text-muted">Период</h6>
                                                            <h6 class="text-warning" id="reportPeriod">-</h6>
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
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>OneC ID</th>
                                                <th>Название товара</th>
                                                <th>Общие просмотры</th>
                                                <th>Уникальные просмотры</th>
                                                <th>Просмотры за период</th>
                                                <th>Точность просмотров</th>
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
            function toggleClearCategory() {
                if ($('#category_id').val()) {
                    $('#clear_category').show();
                } else {
                    $('#clear_category').hide();
                }
            }

            toggleClearCategory();

            $('#category_id').on('change', function() {
                toggleClearCategory();
            });

            $('#clear_category').click(function(e) {
                e.preventDefault();
                $('#category_id').val('').trigger('change');
            });

            $('#generateReport').click(function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const productSearch = $('#product_search').val();
                const categoryId = $('#category_id').val();
                const sortBy = $('#sort_by').val();
                const sortDirection = $('#sort_direction').val();

                if (!startDate || !endDate) {
                    alert('Пожалуйста, выберите даты начала и окончания периода');
                    return;
                }

                $.ajax({
                    url: '{{ route("reports.view-count.product.report.generate") }}',
                    method: 'POST',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        product_search: productSearch,
                        category_id: categoryId,
                        sort_by: sortBy,
                        sort_direction: sortDirection,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            displayReport(response.data);
                            $('#exportReport').show();
                        } else {
                            alert('Ошибка при генерации отчета');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorMsg = 'Ошибки валидации:\n';
                            Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                                errorMsg += xhr.responseJSON.errors[key].join('\n') + '\n';
                            });
                            alert(errorMsg);
                        } else {
                            alert('Ошибка при генерации отчета');
                        }
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

                if (!startDate || !endDate) {
                    alert('Пожалуйста, выберите даты начала и окончания периода');
                    return;
                }

                const form = $('<form>', {
                    'method': 'GET',
                    'action': '{{ route("reports.view-count.product.report.export") }}'
                });

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'start_date',
                    'value': startDate
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'end_date',
                    'value': endDate
                }));

                if (productSearch) {
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': 'product_search',
                        'value': productSearch
                    }));
                }

                if (categoryId) {
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': 'category_id',
                        'value': categoryId
                    }));
                }

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sort_by',
                    'value': sortBy
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'sort_direction',
                    'value': sortDirection
                }));

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
                            <td>${product.total_views}</td>
                            <td>${product.unique_views}</td>
                            <td>${product.period_views}</td>
                            <td>${product.views_per_unit}</td>
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

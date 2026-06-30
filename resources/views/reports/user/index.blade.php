@extends('v2.layouts.app')

@section('title', 'Отчёты по клиентам')
@section('breadcrumb')<span class="text-gray-700">Отчёты по клиентам</span>@endsection

@section('content')
    <x-page-header title="Отчёты по клиентам" description="Генерация отчётов по заказам клиента за выбранный период">
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
                    <label class="form-label" for="user_id">Клиент</label>
                    <select class="form-select js-select2" id="user_id" name="user_id" required>
                        <option value="">Выберите клиента</option>
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
        </form>
    </x-card>

    <div id="reportResults" style="display:none;">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Общая сумма</p>
                <p class="text-2xl font-bold text-brand-700 mt-1" id="totalSum">0 MDL</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Количество позиций</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1" id="totalCount">0</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-sm text-gray-500">Общее количество товаров</p>
                <p class="text-2xl font-bold text-sky-600 mt-1" id="totalQuantity">0</p>
            </div>
        </div>

        <x-card :padding="false">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr><th>Код товара</th><th>Наименование</th><th class="text-right">Цена</th><th class="text-right">Кол-во</th><th class="text-right">Сумма</th></tr>
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
            const userId = $('#user_id').val();

            if (!startDate || !endDate || !userId) {
                Swal.fire('Ошибка', 'Пожалуйста, заполните все поля', 'error');
                return;
            }

            $.ajax({
                url: '{{ route("reports.users.generate") }}',
                type: 'POST',
                data: { start_date: startDate, end_date: endDate, user_id: userId, _token: '{{ csrf_token() }}' },
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
                            <td class="text-right">${formatCurrency(item.price)} MDL</td>
                            <td class="text-right">${item.quantity}</td>
                            <td class="text-right">${formatCurrency(item.sum)} MDL</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            } else {
                tbody.append('<tr><td colspan="5" class="text-center py-6 text-gray-400">Нет данных для отображения</td></tr>');
            }

            $('#reportResults').show();
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
        }
    });
    </script>
@endsection

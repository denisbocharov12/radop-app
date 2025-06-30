<div class="card-inner position-relative card-tools-toggle">
    <div class="mb-3 p-3" style="background: #f8f9fa; border-radius: 8px; border: 1px solid #e5e7eb;">
        <div class="mb-1" style="font-size: 15px; color: #555;">
            1. Выделите нужные заказы галочками или кнопкой "Выделить все".<br>
            2. Выберите новый статус.<br>
            3. Нажмите "Изменить статус" для применения.
        </div>
        <div class="d-flex align-items-center mb-2">
            <input type="checkbox" id="select-all-orders" style="margin-right: 10px;">
            <span style="margin-right: 20px; font-weight: 500;">Выделить все заказы</span>
            <select id="bulk-status-select" class="form-select" style="width: 180px; margin-right: 10px;">
                <option value="">Выбрать статус</option>
                @foreach($orderStatus as $key => $status)
                    <option value="{{ $key }}">{{ $status }}</option>
                @endforeach
            </select>
            <button id="bulk-status-update-btn" class="btn btn-primary">Изменить статус</button>
        </div>
    </div>
    <div style="height: 10px;"></div>
    <div class="card-title-group">
        @hasrole('manager')
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="filterOrdersSwitch">
            <label class="form-check-label" for="filterOrdersSwitch">Фильтровать мои заказы</label>
        </div>
        @endhasrole
        <div class="card-tools">
        </div><!-- .card-tools -->
        <div class="card-tools me-n1">
            <ul class="btn-toolbar gx-1">
                <li>
                    <a href="#" class="btn btn-icon" id="filter-toggle" title="Фильтры"><em class="icon ni ni-filter"></em></a>
                </li>
            </ul><!-- .btn-toolbar -->
        </div><!-- .card-tools -->
    </div><!-- .card-title-group -->
    <div class="card-search search-wrap" data-search="search">
        <div class="card-body">
            <div class="search-content">
                <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                <input type="text" name="search" class="form-control border-transparent form-focus-none" placeholder="Поиск по email...">
                <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
            </div>
        </div>
    </div><!-- .card-search -->
    <div id="filter-panel" style="margin-top: 15px;">
        <form method="get">
            <div class="row g-2 align-items-end">
                {{-- Город --}}
                <div class="col-md-2">
                    <label>Город</label>
                    <select name="filter[city]" class="form-select">
                        <option value="">Все</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->name }}"
                                    {{ request('filter.city') == $city->name ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Статус заказа --}}
                <div class="col-md-2">
                    <label>Статус заказа</label>
                    <select name="filter[status]" class="form-select">
                        <option value="">Все</option>
                        @foreach($orderStatus as $key => $status)
                            <option value="{{ $key }}"
                                    {{ request('filter.status') == $key ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Статус оплаты --}}
                <div class="col-md-2">
                    <label>Статус оплаты</label>
                    <select name="filter[payment_status]" class="form-select">
                        <option value="">Все</option>
                        @foreach($paymentStatus as $key => $status)
                            <option value="{{ $key }}"
                                    {{ request('filter.payment_status') == $key ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Email --}}
                <div class="col-md-2">
                    <label>Email</label>
                    <input type="text" name="filter[email]" class="form-control"
                           value="{{ request('filter.email') }}">
                </div>
                {{-- Телефон --}}
                <div class="col-md-2">
                    <label>Номер телефона</label>
                    <input type="text" name="filter[phone]" class="form-control"
                           value="{{ request('filter.phone') }}">
                </div>
                {{-- Номер заказа --}}
                <div class="col-md-2">
                    <label>Номер заказа</label>
                    <input type="text" name="filter[order_number]" class="form-control"
                           value="{{ request('filter.order_number') }}">
                </div>
            </div>
            <div class="row g-2 align-items-end mt-1">
                {{-- Тип пользователя --}}
                <div class="col-md-2">
                    <label>Тип пользователя</label>
                    <select name="filter[user_type]" class="form-select">
                        <option value="">Все</option>
                        @foreach($userTypes as $userType)
                            <option value="{{ $userType->key_name }}"
                                    {{ request('filter.user_type') == $userType->key_name ? 'selected' : '' }}>
                                {{ $userType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Метод оплаты --}}
                <div class="col-md-2">
                    <label>Метод оплаты</label>
                    <select name="filter[payment_method]" class="form-select">
                        <option value="">Все</option>
                        @foreach($paymentMethods as $key => $method)
                            <option value="{{ $key }}"
                                    {{ request('filter.payment_method') == $key ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Фамилия имя --}}
                <div class="col-md-2">
                    <label>Фискальный код</label>
                    <input type="text" name="filter[cod_fiscal]" class="form-control"
                           value="{{ request('filter.cod_fiscal') }}">
                </div>
                {{-- Клиент --}}
                <div class="col-md-2">
                    <label>Клиент</label>
                    <input type="text" name="filter[fio]" class="form-control"
                           value="{{ request('filter.fio') }}">
                </div>
                {{-- Дата --}}
                <div class="col-md-2">
                    <label>Дата</label>
                    <input type="text" name="filter[created_at]" class="form-control datepicker-filter-created-at"
                           value="{{ request('filter.created_at') }}">
                </div>
                {{-- Менеджер --}}
                <div class="col-md-2">
                    <label>Менеджер</label>
                    <select name="filter[manager_id]" class="form-select">
                        <option value="">Все</option>
                        @foreach($managers as $key => $manager)
                            <option value="{{ $manager->id }}"
                                    {{ request('filter.manager_id') == $manager->id ? 'selected' : '' }}>
                                {{ $manager?->profile?->first_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row g-2 align-items-end mt-1 d-flex justify-content-end">
                {{-- Кнопки --}}
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Фильтровать</button>
                    <a href="{{ route('order.index') }}" class="btn btn-light w-100 mt-1">Сбросить</a>
                </div>
            </div>
        </form>
    </div>
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css">--}}
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/locales/bootstrap-datepicker.ru.min.js"></script>--}}
    <script>
        document.getElementById('filter-toggle').addEventListener('click', function(e) {
            e.preventDefault();
            var panel = document.getElementById('filter-panel');
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        });
        // $(function() {
        //     $('.datepicker-filter-created-at').datepicker({
        //         format: 'dd.mm.yyyy',
        //         autoclose: true,
        //         todayHighlight: true,
        //         language: 'ru',
        //         clearBtn: true
        //     });
        // });
    </script>
</div><!-- .card-inner -->

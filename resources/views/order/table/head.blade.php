<div class="px-5 py-4 border-b border-gray-100 space-y-4">
    {{-- Quick search: client, e-mail, phone, order #, filial, city --}}
    <form method="get" class="flex flex-col sm:flex-row sm:items-center gap-2">
        <div class="search-bar w-full flex-1 min-w-0">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" name="filter[search]" value="{{ request('filter.search') }}"
                   placeholder="Быстрый поиск: клиент, компания, e-mail, телефон, № заказа, филиал, город…">
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary btn-sm"><i data-lucide="search" class="w-4 h-4"></i> Найти</button>
            @if(request('filter.search'))
                <a href="{{ route('order.index') }}" class="btn-secondary btn-sm"><i data-lucide="x" class="w-4 h-4"></i> Сброс</a>
            @endif
        </div>
    </form>

    {{-- Bulk actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-200">
        <label class="inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
            <input type="checkbox" id="select-all-orders" class="w-4 h-4 rounded border-gray-300 accent-brand-600">
            Выделить все
        </label>
        <select id="bulk-status-select" class="form-select no-select2 w-full sm:w-52">
            <option value="">Изменить статус…</option>
            @foreach($orderStatus as $key => $status)
                <option value="{{ $key }}">{{ $status }}</option>
            @endforeach
        </select>
        <button id="bulk-status-update-btn" type="button" class="btn-primary btn-sm"><i data-lucide="check-check" class="w-4 h-4"></i> Применить</button>

        @hasrole('manager')
            <label class="sm:ml-auto inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                <input type="checkbox" id="filterOrdersSwitch" class="w-4 h-4 rounded border-gray-300 accent-brand-600">
                Только мои заказы
            </label>
        @endhasrole

        <button type="button" id="filter-toggle" class="btn-secondary btn-sm @hasrole('manager') @else sm:ml-auto @endif">
            <i data-lucide="sliders-horizontal" class="w-4 h-4"></i> Фильтры
        </button>
    </div>

    {{-- Filter panel --}}
    <form method="get" id="filter-panel" style="display:none;">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="form-label">Город</label>
                <select name="filter[city]" class="form-select no-select2">
                    <option value="">Все</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ request('filter.city') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Статус заказа</label>
                <select name="filter[status]" class="form-select no-select2">
                    <option value="">Все</option>
                    @foreach($orderStatus as $key => $status)
                        <option value="{{ $key }}" {{ request('filter.status') == $key ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Статус оплаты</label>
                <select name="filter[payment_status]" class="form-select no-select2">
                    <option value="">Все</option>
                    @foreach($paymentStatus as $key => $status)
                        <option value="{{ $key }}" {{ request('filter.payment_status') == $key ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Метод оплаты</label>
                <select name="filter[payment_method]" class="form-select no-select2">
                    <option value="">Все</option>
                    @foreach($paymentMethods as $key => $method)
                        <option value="{{ $key }}" {{ request('filter.payment_method') == $key ? 'selected' : '' }}>{{ $method }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Email</label>
                <input type="text" name="filter[email]" class="form-input" value="{{ request('filter.email') }}">
            </div>
            <div>
                <label class="form-label">Телефон</label>
                <input type="text" name="filter[phone]" class="form-input" value="{{ request('filter.phone') }}">
            </div>
            <div>
                <label class="form-label">№ заказа</label>
                <input type="text" name="filter[order_number]" class="form-input" value="{{ request('filter.order_number') }}">
            </div>
            <div>
                <label class="form-label">Фискальный код</label>
                <input type="text" name="filter[cod_fiscal]" class="form-input" value="{{ request('filter.cod_fiscal') }}">
            </div>
            <div>
                <label class="form-label">Клиент</label>
                <input type="text" name="filter[fio]" class="form-input" value="{{ request('filter.fio') }}">
            </div>
            <div>
                <label class="form-label">Тип клиента</label>
                <select name="filter[user_type]" class="form-select no-select2">
                    <option value="">Все</option>
                    @foreach($userTypes as $userType)
                        <option value="{{ $userType->key_name }}" {{ request('filter.user_type') == $userType->key_name ? 'selected' : '' }}>{{ $userType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Менеджер</label>
                <select name="filter[manager_id]" class="form-select no-select2">
                    <option value="">Все</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ request('filter.manager_id') == $manager->id ? 'selected' : '' }}>{{ $manager?->profile?->first_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Дата</label>
                <input type="text" name="filter[created_at]" class="form-input" placeholder="дд.мм.гггг" value="{{ request('filter.created_at') }}">
            </div>
        </div>
        <div class="flex justify-end gap-2 mt-3">
            <a href="{{ route('order.index') }}" class="btn-secondary btn-sm">Сбросить</a>
            <button type="submit" class="btn-primary btn-sm"><i data-lucide="filter" class="w-4 h-4"></i> Фильтровать</button>
        </div>
    </form>
</div>

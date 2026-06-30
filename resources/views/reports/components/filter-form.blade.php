<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="form-label" for="start_date">Дата начала периода</label>
        <input type="date" class="form-input" id="start_date" name="start_date" value="{{ request('start_date') }}" required>
    </div>
    <div>
        <label class="form-label" for="end_date">Дата окончания периода</label>
        <input type="date" class="form-input" id="end_date" name="end_date" value="{{ request('end_date') }}" required>
    </div>
    <div class="sm:col-span-2">
        <label class="form-label" for="user_id">Менеджер (необязательно)</label>
        <select class="form-select js-select2" id="user_id" name="user_id">
            <option value="">Все менеджеры</option>
            @foreach($managers as $manager)
                <option value="{{ $manager->id }}" {{ request('user_id') == $manager->id ? 'selected' : '' }}>
                    {{ $manager->profile->first_name }} {{ $manager->profile->last_name }}
                </option>
            @endforeach
        </select>
    </div>
    @if($groupByClientsOption ?? false)
    <div class="sm:col-span-2">
        <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer select-none">
            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-brand-600" id="group_by_clients" name="group_by_clients" value="1">
            Группировать по клиентам
        </label>
        <p class="form-hint mt-1">Заказы группируются по клиентам; скрываются телефон/город/филиал, дата заменяется периодом и добавляется сумма по клиенту.</p>
    </div>
    @endif
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="form-label" for="start_date">Дата начала периода</label>
            <div class="form-control-wrap">
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}" required>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label class="form-label" for="end_date">Дата окончания периода</label>
            <div class="form-control-wrap">
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}" required>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label class="form-label" for="user_id">Менеджер (необязательно)</label>
            <div class="form-control-wrap">
                <select class="form-select js-select2" id="user_id" name="user_id">
                    <option value="">Все менеджеры</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ request('user_id') == $manager->id ? 'selected' : '' }}>
                            {{ $manager->profile->first_name }} {{ $manager->profile->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @if($groupByClientsOption ?? false)
    <div class="col-lg-12">
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="group_by_clients" name="group_by_clients" value="1">
                <label class="custom-control-label" for="group_by_clients">Группировать по клиентам</label>
            </div>
            <span class="form-note">Заказы группируются по клиентам, скрываются телефон/город/филиал, дата заменяется периодом и добавляется сумма по клиенту.</span>
        </div>
    </div>
    @endif
</div>

<form action="{{ route('client.index') }}" method="GET"
      class="px-5 py-4 border-b border-gray-100 space-y-3">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">ID</label>
            <input type="text" name="filter[id]" value="{{ $query['id'] ?? '' }}"
                   placeholder="#" class="form-input w-full">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Клиент / E-mail</label>
            <input type="text" name="filter[client]" value="{{ $query['client'] ?? '' }}"
                   placeholder="Имя, компания, e-mail" class="form-input w-full">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Фискальный код</label>
            <input type="text" name="filter[cod_fiscal]" value="{{ $query['cod_fiscal'] ?? '' }}"
                   placeholder="Ф.К." class="form-input w-full">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Менеджер</label>
            <input type="text" name="filter[manager]" value="{{ $query['manager'] ?? '' }}"
                   placeholder="Имя менеджера" class="form-input w-full">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Телефон</label>
            <input type="text" name="filter[phone]" value="{{ $query['phone'] ?? '' }}"
                   placeholder="Телефон" class="form-input w-full">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Город</label>
            <select name="filter[city]" class="form-select w-full">
                <option value="">Все города</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ (string)($query['city'] ?? '') === (string)$city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Статус</label>
            <select name="filter[status]" class="form-select w-full">
                <option value="">Все</option>
                <option value="1" {{ (string)($query['status'] ?? '') === '1' ? 'selected' : '' }}>Активный</option>
                <option value="0" {{ isset($query['status']) && $query['status'] === '0' ? 'selected' : '' }}>Неактивный</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Общий поиск</label>
            <input type="text" name="filter[search]" value="{{ $query['search'] ?? '' }}"
                   placeholder="По имени, коду, телефону…" class="form-input w-full">
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
        <label class="inline-flex items-center gap-2 text-sm text-gray-600 select-none cursor-pointer">
            <input type="checkbox" name="filter[with_trashed]" value="with_trashed"
                   {{ ($query['with_trashed'] ?? '') === 'with_trashed' ? 'checked' : '' }}
                   class="w-4 h-4 rounded border-gray-300 accent-brand-600">
            Показать удалённых
        </label>

        <div class="sm:ml-auto flex items-center gap-2">
            <button type="submit" class="btn-primary btn-sm"><i data-lucide="filter" class="w-4 h-4"></i> Фильтр</button>
            <a href="{{ route('client.index') }}" class="btn-secondary btn-sm"><i data-lucide="x" class="w-4 h-4"></i> Сбросить</a>
        </div>
    </div>
</form>

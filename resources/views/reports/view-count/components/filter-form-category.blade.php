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
        <label class="form-label" for="category_id">Категория (необязательно)</label>
        <select class="form-select js-select2" id="category_id" name="category_id">
            <option value="">Все категории</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->getTranslation('name', app()->getLocale()) }} ({{ $category->onec_id }})
                </option>
            @endforeach
        </select>
    </div>
</div>

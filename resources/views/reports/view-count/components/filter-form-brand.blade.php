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
        <label class="form-label" for="brand_id">Бренд (необязательно)</label>
        <select class="form-select js-select2" id="brand_id" name="brand_id">
            <option value="">Все бренды</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->getTranslation('title', app()->getLocale()) }} ({{ $brand->onec_id }})
                </option>
            @endforeach
        </select>
    </div>
</div>

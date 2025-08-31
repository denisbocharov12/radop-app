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
            <label class="form-label" for="brand_id">Бренд (необязательно)</label>
            <div class="form-control-wrap">
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
    </div>
</div> 
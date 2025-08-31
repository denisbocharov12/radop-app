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
            <label class="form-label" for="product_id">Товар (необязательно)</label>
            <div class="form-control-wrap">
                <select class="form-select js-select2" id="product_id" name="product_id">
                    <option value="">Все товары</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->getTranslation('title', app()->getLocale()) }} ({{ $product->onec_id }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div> 
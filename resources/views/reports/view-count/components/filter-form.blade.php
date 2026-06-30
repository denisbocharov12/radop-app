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
        <label class="form-label" for="product_search">Поиск товара (необязательно)</label>
        <input type="text" class="form-input" id="product_search" name="product_search" placeholder="Введите название, код 1C или штрихкод товара">
        <p class="form-hint">Поиск по названию, коду 1C и штрихкоду товара.</p>
    </div>
    @if(isset($categories))
    <div class="sm:col-span-2">
        <label class="form-label" for="category_id">Категория (необязательно)</label>
        <select class="form-select js-select2" id="category_id" name="category_id">
            <option value="">Все категории</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->getTranslation('name', app()->getLocale()) }}
                </option>
            @endforeach
        </select>
        <p class="form-hint">Выбрана категория? <a href="#" id="clear_category" class="text-red-500 hover:text-red-700" style="display:none;">Сбросить</a></p>
    </div>
    @endif
    <div>
        <label class="form-label" for="sort_by">Сортировать по</label>
        <select class="form-select no-select2" id="sort_by" name="sort_by">
            <option value="total_views">Общие просмотры</option>
            <option value="unique_views">Уникальные просмотры</option>
            <option value="period_views">Просмотры за период</option>
            <option value="title">Название</option>
            <option value="onec_id">Код 1C</option>
        </select>
    </div>
    <div>
        <label class="form-label" for="sort_direction">Порядок сортировки</label>
        <select class="form-select no-select2" id="sort_direction" name="sort_direction">
            <option value="desc">По убыванию</option>
            <option value="asc">По возрастанию</option>
        </select>
    </div>
</div>

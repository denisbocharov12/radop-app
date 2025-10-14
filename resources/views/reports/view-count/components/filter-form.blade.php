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
            <label class="form-label" for="product_search">Поиск товара (необязательно)</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="product_search" name="product_search" placeholder="Введите название, код 1C или штрихкод товара">
            </div>
            <small class="form-text text-muted">Будет выполнен поиск по названию, коду 1C и штрихкоду товара</small>
        </div>
    </div>
    @if(isset($categories))
    <div class="col-lg-12">
        <div class="form-group">
            <label class="form-label" for="category_id">Категория (необязательно)</label>
            <div class="form-control-wrap position-relative">
                <select class="form-select js-select2" id="category_id" name="category_id">
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->getTranslation('name', app()->getLocale()) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <small class="form-text text-muted">
                Выбрана категория? 
                <a href="#" id="clear_category" class="text-danger" style="display: none;">
                    <em class="icon ni ni-cross-circle"></em> Сбросить
                </a>
            </small>
        </div>
    </div>
    @endif
    <div class="col-lg-6">
        <div class="form-group">
            <label class="form-label" for="sort_by">Сортировать по</label>
            <div class="form-control-wrap">
                <select class="form-select" id="sort_by" name="sort_by">
                    <option value="total_views">Общие просмотры</option>
                    <option value="unique_views">Уникальные просмотры</option>
                    <option value="period_views">Просмотры за период</option>
                    <option value="title">Название</option>
                    <option value="onec_id">Код 1C</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label class="form-label" for="sort_direction">Порядок сортировки</label>
            <div class="form-control-wrap">
                <select class="form-select" id="sort_direction" name="sort_direction">
                    <option value="desc">По убыванию</option>
                    <option value="asc">По возрастанию</option>
                </select>
            </div>
        </div>
    </div>
</div> 
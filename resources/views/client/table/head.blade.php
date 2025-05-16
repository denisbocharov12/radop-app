<form action="{{route('client.index')}}" method="GET" class="card-inner position-relative card-tools-toggle">
    @csrf
    <div class="card-title-group">
        <div class="card-tools d-flex flex-wrap">
            <input type="text" name="filter[search]" style="padding: 0" value="{{isset($query['search']) ? $query['search'] : ''}}" class="form-control border-transparent form-focus-none" placeholder="Поиск по ...">
            <div class="preview-block mt-2" style="margin-right: 15px">
                <span class="preview-title overline-title">Показать удаленные</span>
                <div class="g-4 align-center flex-wrap">
                    <div class="g">
                        <div class="custom-control custom-control-sm custom-radio">
                            <input {{isset($query['with_trashed']) && $query['with_trashed'] === 'with_trashed' ? 'checked' : ''}} type="radio" class="custom-control-input" name="filter[with_trashed]" id="custom-r-with_bank" value="with_trashed">
                            <label class="custom-control-label" for="custom-r-with_bank">Да</label>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .card-tools -->
    </div><!-- .card-title-group -->
    <button class="btn btn-info mt-3" type="submit">Фильтр</button>
    <a href="{{route('client.index')}}" class="btn btn-warning mt-3" type="submit">Сбросить фильтры</a>
</form><!-- .card-inner -->

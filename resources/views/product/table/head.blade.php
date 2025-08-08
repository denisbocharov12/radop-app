<div class="card-inner position-relative card-tools-toggle">
    <div class="mb-3 p-3" style="background: #f8f9fa; border-radius: 8px; border: 1px solid #e5e7eb;">
        <div class="mb-1" style="font-size: 15px; color: #555;">
            1. Отметьте товары галочками или кнопкой "Выделить все".<br>
            2. Выберите состояние.<br>
            3. Нажмите "Изменить состояние".
        </div>
        <div class="d-flex align-items-center mb-2">
            <input type="checkbox" id="select-all-products" style="margin-right: 10px;">
            <span style="margin-right: 20px; font-weight: 500;">Выделить все товары</span>
            <select id="bulk-condition-select" class="form-select" style="width: 200px; margin-right: 10px;">
                <option value="">Выбрать состояние</option>
                <option value="new">Новинка</option>
                <option value="popular">Популярный товар</option>
                <option value="regular">Обычный</option>
            </select>
            <button id="bulk-condition-update-btn" class="btn btn-primary">Изменить состояние</button>
        </div>
    </div>
    <form action="{{route('product.index')}}" method="GET" class="card-title-group">
        @csrf
        <div class="card-tools">
            <input type="text" name="filter[search]" style="padding: 0" value="{{isset($query['search']) ? $query['search'] : ''}}" class="form-control border-transparent form-focus-none" placeholder="Поиск по ...">
        </div><!-- .card-tools -->
        <div class="card-tools me-n1">
            <ul class="btn-toolbar gx-1">
                <li>
                    <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                </li><!-- li -->
                <li class="btn-toolbar-sep"></li><!-- li -->
                <li>
                    <div class="toggle-wrap">
                        <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                        <div class="toggle-content" data-content="cardTools">
                            <ul class="btn-toolbar gx-1">
                                <li class="toggle-close">
                                    <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                </li><!-- li -->
                                <li>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-setting"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                            <ul class="link-check">
                                                <li><span>Показать</span></li>
                                                <li class="active"><a href="#">10</a></li>
                                                <li><a href="#">20</a></li>
                                                <li><a href="#">50</a></li>
                                            </ul>
                                            <ul class="link-check">
                                                <li><span>Сортировка</span></li>
                                                <li class="active"><a href="#">DESC</a></li>
                                                <li><a href="#">ASC</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- .dropdown -->
                                </li><!-- li -->
                            </ul><!-- .btn-toolbar -->
                        </div><!-- .toggle-content -->
                    </div><!-- .toggle-wrap -->
                </li><!-- li -->
            </ul><!-- .btn-toolbar -->
        </div><!-- .card-tools -->
    </form><!-- .card-title-group -->
</div><!-- .card-inner -->

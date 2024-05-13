<div class="card-inner position-relative card-tools-toggle">
    <div class="card-title-group">
        @hasrole('manager')
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="filterOrdersSwitch">
            <label class="form-check-label" for="filterOrdersSwitch">Фильтровать мои заказы</label>
        </div>
        @endhasrole
        <div class="card-tools">

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
    </div><!-- .card-title-group -->
    <div class="card-search search-wrap" data-search="search">
        <div class="card-body">
            <div class="search-content">
                <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                <input type="text" name="search" class="form-control border-transparent form-focus-none" placeholder="Search by ...">
                <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
            </div>
        </div>
    </div><!-- .card-search -->
</div><!-- .card-inner -->

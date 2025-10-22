<form action="{{route('admin.menus.index')}}" method="GET" class="card-inner position-relative card-tools-toggle">
    @csrf
    <div class="card-title-group">
        <div class="card-tools">
            <input type="text" name="search" style="padding: 0" value="{{request('search')}}" class="form-control border-transparent form-focus-none" placeholder="Поиск по коду или названию...">
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
                            </ul><!-- .btn-toolbar -->
                        </div><!-- .toggle-content -->
                    </div><!-- .toggle-wrap -->
                </li><!-- li -->
            </ul><!-- .btn-toolbar -->
        </div><!-- .card-tools -->
    </div><!-- .card-title-group -->
</form><!-- .card-inner -->


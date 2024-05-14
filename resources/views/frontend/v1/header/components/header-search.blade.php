<div class="header-search col col-md col-xl col-lg">
    <div class="wrap">
        <form action="{{route('theme.search.index')}}" method="GET">
            @csrf
            <input type="text" class="search" name="search" placeholder="Искать на сайте" />
            <button type="submit" class="btn-search">Найти <i class="icon-search"></i></button>
        </form>
    </div>
</div>

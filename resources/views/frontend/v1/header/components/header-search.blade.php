<div class="header-search header-with-menu col col-md col-xl col-lg">
    @include('frontend.v1.header.components.top-bar')
    <div class="wrap">
        <div class="btn-header-catalog-wrap">
            <button id="btn-header-catalog" class="btn-header-catalog">
                <i class="icon-bars"></i>
                <span class="btn-header-catalog-text">{{__('theme.header-catalog-text')}}</span>
            </button>
        </div>
        <form action="{{route('theme.search.index')}}" method="GET">
            @csrf
            <input type="text" class="search" name="search" placeholder="{{__('theme.search-on-site')}}" />
            <button type="submit" class="btn-search"><i class="icon-search"></i></button>
        </form>
    </div>
</div>

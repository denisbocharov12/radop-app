<div class="header-search header-with-menu col col-md col-xl col-lg">
    @include('frontend.v1.header.components.top-bar')
    <div class="wrap">
        <div class="btn-header-catalog-wrap">
            <button id="btn-header-catalog" class="btn-header-catalog">
                <span class="animated-burger-icon"></span>
                <span class="btn-header-catalog-text">{{__('theme.header-catalog-text')}}</span>
            </button>
            <div class="row row-menu row-header-catalog row-header-catalog-wrap">
                <div class="header-catalog" id="header-catalog-action">
                    <div class="row row-header-catalog">
                        @if(!empty($themeParentCategories))
                            @foreach($themeParentCategories as $parentCategory)
                                @include('frontend.v1.header.components.header-catalog-item', $parentCategory)
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <form action="{{route('theme.search.index')}}" method="GET">
            @csrf
            <input type="text" class="search" name="search" placeholder="{{__('theme.search-on-site')}}" />
            <button type="submit" class="btn-search"><i class="icon-search"></i></button>
        </form>
    </div>
</div>

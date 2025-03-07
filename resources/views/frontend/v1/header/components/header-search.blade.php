<div class="header-search header-with-menu col col-md col-xl col-lg">
    @include('frontend.v1.header.components.top-bar')
    <div class="wrap">
        <div class="btn-header-catalog-wrap">
            <button id="btn-header-catalog" class="btn-header-catalog">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.87109 5C3.87109 4.44772 4.31881 4 4.87109 4H22.0015C22.5538 4 23.0015 4.44772 23.0015 5V6C23.0015 6.55228 22.5538 7 22.0015 7H4.87109C4.31881 7 3.87109 6.55228 3.87109 6V5Z" fill="white"/>
                    <path d="M2.91406 12C2.91406 11.4477 3.36178 11 3.91406 11H21.0445C21.5968 11 22.0445 11.4477 22.0445 12V13C22.0445 13.5523 21.5968 14 21.0445 14H3.91406C3.36178 14 2.91406 13.5523 2.91406 13V12Z" fill="white"/>
                    <path d="M1 19C1 18.4477 1.44772 18 2 18H19.1304C19.6827 18 20.1304 18.4477 20.1304 19V20C20.1304 20.5523 19.6827 21 19.1304 21H2C1.44772 21 1 20.5523 1 20V19Z" fill="white"/>
                </svg>
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

<li class="item megamenu">
    <a href="{{route('theme.category.index', $parentCategory->onec_id)}}" class="link link-megamenu"
    >
        {{$parentCategory->name}}
    </a>
    @if(count($parentCategory->children) > 0)
        <div class="megamenu-wrap">
            <div class="container container-megamenu">
                <div class="row row-megamenu">
                    <div class="col-12 col-content-megamenu" id="js-content-megamenu">
                        <div class="row row-list-content">
                            @if(count($parentCategory->children) > 0)
                                @foreach($parentCategory->children as $childrenCategory)
                                    <div class="col-4 col-list-content">
                                        <a href="{{route('theme.category.index', $childrenCategory->onec_id)}}" class="heading">
                                            {{$childrenCategory->name}}
                                        </a>
                                        @if(count($childrenCategory->children)  > 0)
                                            @include('frontend.v1.header.components.loop.header-menu-item-column', $childrenCategory)
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</li>

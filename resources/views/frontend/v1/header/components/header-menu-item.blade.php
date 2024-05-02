<li class="item megamenu">
    <a href="{{route('theme.category.index', $parentCategory->onec_id)}}" class="link link-megamenu"
    >
        @if($parentCategory->getFirstMediaUrl('media') !== '')
            <img src="{{$parentCategory->getFirstMediaUrl('media')}}" alt="Media" style="width: 22px; height: 22px; margin-right: 5px">
        @endif
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
                                            @if($childrenCategory->getFirstMediaUrl('media') !== '')
                                                <img src="{{$childrenCategory->getFirstMediaUrl('media')}}" alt="Media" style="width: 22px; height: 22px; margin-right: 5px">
                                            @endif
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

<div class="col-4 col-list-content">
    <a href="{{route('theme.category.index', $parentCategory->onec_id)}}" class="link link-megamenu"
    >
        @if($parentCategory->getFirstMediaUrl('media') !== '')
            <img src="{{$parentCategory->getFirstMediaUrl('media')}}" alt="Media" style="width: 22px; height: 22px; margin-right: 5px">
        @endif
        {{$parentCategory->name}}
    </a>
    @if(count($parentCategory->children) > 0)
        <div class="wrap-content">
            @if(count($parentCategory->children) > 0)
                @foreach($parentCategory->children as $childrenCategory)
                    <a href="{{route('theme.category.index', $childrenCategory->onec_id)}}" class="heading">
                        @if($childrenCategory->getFirstMediaUrl('media') !== '')
                            <img src="{{$childrenCategory->getFirstMediaUrl('media')}}" alt="Media" style="width: 22px; height: 22px; margin-right: 5px">
                        @endif
                        {{$childrenCategory->name}}
                    </a>
                @endforeach
            @endif
        </div>
    @endif
</div>

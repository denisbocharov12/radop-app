<div class="col-4 col-list-content">
    <a href="{{route('theme.category.index', $parentCategory->onec_id)}}" class="link link-megamenu"
    >
        {{$parentCategory->name}}
    </a>
    @if(count($parentCategory->children) > 0)
        <div class="wrap-content">
            @if(count($parentCategory->children) > 0)
                @foreach($parentCategory->children as $childrenCategory)
                    <a href="{{route('theme.category.index', $childrenCategory->onec_id)}}" class="heading">
                        {{$childrenCategory->name}}
                    </a>
                @endforeach
            @endif
        </div>
    @endif
</div>

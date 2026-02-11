@if(!isset($noColumnWrap) || !$noColumnWrap)
<div class="col-4 col-list-content">
@endif
    <a href="{{route('theme.category.index', $parentCategory->onec_id)}}" class="link link-megamenu">
        {{$parentCategory->name}}
    </a>
    @if(count($parentCategory->children) > 0)
        <div class="wrap-content">
            @foreach($parentCategory->children as $childrenCategory)
                <a href="{{route('theme.category.index', $childrenCategory->onec_id)}}" class="heading">
                    {{$childrenCategory->name}}
                </a>
            @endforeach
        </div>
    @endif
@if(!isset($noColumnWrap) || !$noColumnWrap)
</div>
@endif

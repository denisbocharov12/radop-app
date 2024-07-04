<li>
    <a id="top" class="toggle" href="javascript:void(0);">{{$parentCategory->name}}</a>
    @if(count($parentCategory->children) > 0)
        <ul class="inner">
            @foreach($parentCategory->children as $childrenCategory)
                    <li>
                        <a href="{{route('theme.brand.index', $childrenCategory->onec_id)}}" class="toggle">- {{$childrenCategory->name}}</a>
                        @if(count($childrenCategory->children)  > 0)
                            @include('frontend.v1.pages.brand.parts.filter.loop-item', $childrenCategory)
                        @endif
                    </li>
            @endforeach
        </ul>
    @endif
</li>

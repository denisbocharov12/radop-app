@if(count($childrenCategory->children) > 0)
    <ul class="inner">
        @foreach($childrenCategory->children as $childrenCategory)
            <li>
                <a href="{{route('theme.category.index', $childrenCategory->onec_id)}}" class="toggle">-- {{$childrenCategory->name}}</a>
                @include('frontend.v1.pages.category.parts.filter.loop-item', $childrenCategory)
            </li>
        @endforeach
    </ul>
@endif


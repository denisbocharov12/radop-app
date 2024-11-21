@if($categories->isNotEmpty())
    <ul class="list category-list">
        @foreach($categories as $category)
            <li class="item">
                <a class="link" href="{{route('theme.category.index', $category->onec_id)}}">
                    @if($category->getFirstMediaUrl('media') !== '')
                        <img src="{{$category->getFirstMediaUrl('media')}}" alt="{{$category->name}}" style="width: 16px; height: 16px; margin-right: 5px">
                    @endif
                    {{$category->name}}
                </a>
            </li>
        @endforeach
    </ul>
@endif

<ul>
    @foreach($childs as $child)
        <li class="child ms-3 border-bottom d-inline-block">
            {{ $child->name }}
        </li>
    @endforeach
</ul>
<div class="clearfix"></div>

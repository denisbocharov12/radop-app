<ul class="flex flex-wrap gap-1.5">
    @foreach($childs as $child)
        <li class="inline-flex items-center px-2 py-0.5 text-xs rounded-md bg-gray-100 text-gray-600">{{ $child->name }}</li>
    @endforeach
</ul>

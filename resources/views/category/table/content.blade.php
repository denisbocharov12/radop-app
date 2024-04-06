<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Название</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Родительская категория</span></div>
            <div class="nk-tb-col"><span class="sub-text">Статус</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($categories as $category)
            <div class="nk-tb-item" id="category-id-{{$category->id}}">
                <div class="nk-tb-col">
                    <span>#{{$category->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$category->name}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$category->parent->name ?? ''}}</span>
                </div>
                <div class="nk-tb-col">
                    @if($category->status)
                        <span class="tb-status text-success">Активная</span>
                    @else
                        <span class="tb-status text-danger">Неактивная</span>
                    @endif
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('category.edit', $category)}}" data-id="{{$category->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="category-delete" id="category-delete-{{$category->id}}" data-id="{{$category->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- .nk-tb-item -->
        @endforeach
    </div><!-- .nk-tb-list -->
</div><!-- .card-inner -->

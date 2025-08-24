<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Порядок отображения</span></div>
            <div class="nk-tb-col"><span class="sub-text">Изображение RU</span></div>
            <div class="nk-tb-col"><span class="sub-text">Изображение RO</span></div>
            <div class="nk-tb-col"><span class="sub-text">Статус</span></div>
            <div class="nk-tb-col"><span class="sub-text">Ссылка</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($banners as $banner)
            <div class="nk-tb-item" id="brand-id-{{$banner->id}}">
                <div class="nk-tb-col">
                    <span>#{{$banner->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$banner->order}}</span>
                </div>
                <div class="nk-tb-col">
                    <img src="{{ asset('storage/' . $banner->image_path_ru) }}" height="100px" alt="">
                </div>
                <div class="nk-tb-col">
                    <img src="{{ asset('storage/' . $banner->image_path_ro) }}" height="100px" alt="">
                </div>
                <div class="nk-tb-col">
                    @if($banner->active)
                        <span class="tb-status text-success">Активный</span>
                    @else
                        <span class="tb-status text-danger">Неактивный</span>
                    @endif
                </div>
                <div class="nk-tb-col">
                    <span>{{$banner->link}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('banner.edit', $banner)}}" data-id="{{$banner->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="banner-delete" id="banner-delete-{{$banner->id}}" data-id="{{$banner->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
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

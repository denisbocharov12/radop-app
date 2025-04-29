<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Пользователь</span></div>
            <div class="nk-tb-col"><span class="sub-text">Адрес</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Телефон</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Город</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($filials as $filial)
            <div class="nk-tb-item" id="model-id-{{$filial->id}}">
                <div class="nk-tb-col">
                    <span>#{{$filial->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <div class="user-card">
                        <div class="user-name">
                            <span class="tb-lead"><a class="text-decoration-underline" href="{{route('client.show', $filial->user)}}">{{$filial->user->profile?->organization_name}}</a></span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col">
                    <div class="user-card">
                        <div class="user-name">
                            <span class="tb-lead"><a class="text-decoration-underline" href="#">{{$filial->address}}</a></span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$filial->phone}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$filial->city?->name}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('filial.edit', $filial)}}" data-id="{{$filial->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="model-delete" id="model-delete-{{$filial->id}}" data-id="{{$filial->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
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

<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Имя/Фамилия</span></div>
            <div class="nk-tb-col"><span class="sub-text">Пользователь</span></div>
            <div class="nk-tb-col"><span class="sub-text">Роль</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Статус</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Телефон</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Город</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($users as $user)
            <div class="nk-tb-item" id="model-id-{{$user->id}}">
                <div class="nk-tb-col">
                    <span>#{{$user->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <div class="user-card">
                        <div class="user-name">
                            <span class="tb-lead">@if($user->type->key_name === 'iur') {{$user->profile->organization_name}} @else {{$user->profile->first_name}} {{$user->profile->last_name}} @endif</span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col">
                    <div class="user-card">
                        <div class="user-name">
                            <span class="tb-lead"><a class="text-decoration-underline" href="#">{{$user->name}}</a></span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col">
                    <div class="user-card">
                        <div class="user-name">
                            <span class="tb-lead"><a class="text-decoration-underline" href="#">{{$user->roles->first()->name}}</a></span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    @if($user->status)
                        <span class="tb-status text-success">Активный</span>
                    @else
                        <span class="tb-status text-danger">Неактивный</span>
                    @endif
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$user->profile->phone}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$user?->city?->name}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('client.show', $user)}}"><em class="icon ni ni-eye"></em><span>Просмотреть</span></a></li>
                                        <li><a href="{{route('client.edit', $user)}}" data-id="{{$user->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="model-delete" id="model-delete-{{$user->id}}" data-id="{{$user->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
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

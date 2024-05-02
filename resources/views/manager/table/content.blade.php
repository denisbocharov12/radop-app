<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Имя/Фамилия</span></div>
            <div class="nk-tb-col"><span class="sub-text">Email</span></div>
            <div class="nk-tb-col"><span class="sub-text">Телефон</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Тип</span></div>
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
                            <span class="tb-lead">{{$user->profile->first_name}} {{$user->profile->last_name}}</span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col">
                    <div class="user-card">
                        <div class="user-name">
                            <span class="tb-lead"><a class="text-decoration-underline" href="#">{{$user->email}}</a></span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col">
                    <div class="user-card">
                        <div class="user-name">
                            <span>{{$user->profile->phone}}</span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    @if($user->type_id == 1)
                        <span class="profile-ud-value">Физ. лицо</span>
                    @else
                        <span class="profile-ud-value">Юр. лицо</span>
                    @endif
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('manager.edit', $user)}}"><em class="icon ni ni-edit"></em><span>Назначить менеджера</span></a></li>
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

<!-- @@ Lead Add Modal @e -->
<div class="modal fade" role="dialog" id="addModel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Добавить пользователя</h5>
                <div class="tab-content">
                    <div class="tab-pane active" id="subject-create">
                        <form action="{{route('client.store')}}" method="POST">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="first_name">Имя</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('first_name') error @enderror" id="first_name" name="first_name" placeholder="Имя">
                                            @error('first_name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="last_name">Фамилия</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control @error('last_name') error @enderror" id="last_name" name="last_name" placeholder="Имя">
                                            @error('last_name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Роль</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" name="role" id="role" data-placeholder="Роль">
                                                <option value="">Выбрать роль</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->name}}">
                                                        @if($role->name === 'user')
                                                            Пользователь
                                                        @elseif($role->name === 'manager')
                                                            Менеджер
                                                        @elseif($role->name === 'accountant')
                                                            Бухгалтер
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Филиал</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" data-search="on" name="filial_id" id="filial_id" data-placeholder="Без Филиала">
                                                <option value="">Без филиала</option>
                                                @foreach($filials as $filial)
                                                    <option value="{{$filial->id}}">{{$filial->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email</label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-mail"></em>
                                            </div>
                                            <input type="text" class="form-control" id="email" placeholder="example@mail.ru" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Пароль</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input style="border-color: #a52834" type="password" class="form-control" id="password" name="password" placeholder="Новый пароль">
                                            @error('password')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="mobile_phone">Мобильный телефон</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control" id="mobile_phone" name="mobile_phone" placeholder="373 777 77 777">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Статус</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                <option value="true">Активный</option>
                                                <option value="false">Неактивный</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary">Создать пользователя</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

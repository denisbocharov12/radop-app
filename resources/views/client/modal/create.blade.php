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
                                            <input type="text" class="form-control @error('last_name') error @enderror" id="last_name" name="last_name" placeholder="Фамилия">
                                            @error('last_name')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="role">Роль</label>
                                        <div class="form-control-wrap">
                                            <select required class="form-select js-select2" data-search="on" name="role" id="role" data-placeholder="Выбрать роль">
                                                <option value="">Выбрать роль</option>
                                                @foreach($roles as $role)
                                                    @if($role->name === 'user')
                                                        <option value="{{$role->name}}">
                                                            Пользователь
                                                        </option>
                                                    @elseif($role->name === 'manager')
                                                        <option value="{{$role->name}}">
                                                            Менеджер
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address">Адрес</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="address" placeholder="Ул. Пушкина 22" name="address">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="sale">Персональная скидка</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="sale" placeholder="15" name="sale">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="phone">Мобильный телефон</label>
                                        <div class="form-control-wrap">
                                            <input type="text" required class="form-control" id="phone" name="phone" placeholder="373 777 77 777">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="type_id">Тип пользователя</label>
                                        <div class="form-control-wrap">
                                            <select required class="form-select js-select2" data-search="on" name="type_id" id="type_id" data-placeholder="Тип пользователя">
                                                <option value="">Выбрать роль</option>
                                                @foreach($userTypes as $userType)
                                                    @if($userType->key_name === 'iur')
                                                        <option value="{{$userType->id}}">
                                                            Юр. лицо
                                                        </option>
                                                    @elseif($userType->key_name === 'fiz')
                                                        <option value="{{$userType->id}}">
                                                            Физ. лицо
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="organization_name">Название организации</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="organization_name" placeholder="Название организации" name="organization_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="cod_fiscal">Фискальный код</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="cod_fiscal" placeholder="1234567891234" name="cod_fiscal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="contact_name">Контактное лицо</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="contact_name" placeholder="Контактное лицо" name="contact_name">
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
                                            <input required type="text" class="form-control" id="email" placeholder="example@mail.ru" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="city_id">Город</label>
                                        <div class="form-control-wrap">
                                            <select required class="form-select js-select2" data-search="on" name="city_id" id="city_id" data-placeholder="Город">
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
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
                                            <input required style="border-color: #a52834" type="password" class="form-control" id="password" name="password" placeholder="Новый пароль">
                                            @error('password')
                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="status">Статус</label>
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

@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('v1.errors.errors')
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="title nk-block-title">Редактирование пользователя {{$user->profile->first_name}} {{$user->profile->last_name}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('client.update', $user)}}" enctype="multipart/form-data" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="first_name">Имя</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('first_name') error @enderror" value="{{$user->profile->first_name}}" id="first_name" name="first_name" placeholder="Имя">
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
                                                    <input type="text" class="form-control @error('last_name') error @enderror" value="{{$user->profile->last_name}}" id="last_name" name="last_name" placeholder="Имя">
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
                                                    <select class="form-select js-select2" name="role" id="role" data-placeholder="Роль">
                                                        <option value="">Роль</option>
                                                        @foreach($roles as $role)
                                                            <option {{$role->name == $user->roles->first()->name ? 'selected' : ''}} value="{{$role->name}}">
                                                                @if($role->name === 'user')
                                                                    Пользователь
                                                                @elseif($role->name === 'manager')
                                                                    Менеджер
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">Адрес</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="address" value="{{$user->profile->address}}" placeholder="Ул. Пушкина 22" name="address">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="sale">Персональная скидка</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="sale" placeholder="15" name="sale" value="{{$user->sale}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">Мобильный телефон</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control" id="phone" value="{{$user->profile->phone}}" name="phone" placeholder="373 777 77 777">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
{{--                                                @dd($userTypes)--}}
                                                <label class="form-label">Тип пользователя</label>
                                                <div class="form-control-wrap">
                                                    <select required class="form-select js-select2" data-search="on" name="type_id" id="type_id" data-placeholder="Тип пользователя">
                                                        <option value="">Выбрать роль</option>
                                                        @foreach($userTypes as $userType)
                                                            <option {{$userType->id == $user->type_id ? 'selected' : ''}} value="{{$userType->id}}">
                                                                @if($userType->key_name === 'fiz')
                                                                    Физ. лицо
                                                                @elseif($userType->key_name === 'iur')
                                                                    Юр. лицо
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="organization_name">Название организации</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="organization_name" value="{{$user->profile->organization_name}}" placeholder="Название организации" name="organization_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="cod_fiscal">Фискальный код</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="cod_fiscal" value="{{$user->profile->cod_fiscal}}" placeholder="1234567891234" name="cod_fiscal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="contact_name">Контактное лицо</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="contact_name" value="{{$user->profile->contact_name}}" placeholder="Контактное лицо" name="contact_name">
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
                                                    <input type="text" class="form-control" id="email" value="{{$user->email}}" placeholder="example@mail.ru" name="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                        <option {{$user->status == true ? 'selected' : ''}} value="true">Активный</option>
                                                        <option {{$user->status == false ? 'selected' : ''}} value="false">Неактивный</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Проверенный клиент</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="verified_status" id="verified_status" data-placeholder="Выберите статус проверки">
                                                        <option {{$user->verified_status == true ? 'selected' : ''}} value="true">Активный</option>
                                                        <option {{$user->verified_status == false ? 'selected' : ''}} value="false">Неактивный</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить пользователя</button>
                                                </li>
                                                <li>
                                                    <a href="{{route('client.generate', $user)}}" class="btn btn-warning text-dark ">Распечатать новый пароль</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2({
                allowClear: true
            });
        });
    </script>
@endsection

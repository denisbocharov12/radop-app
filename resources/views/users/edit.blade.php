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
                                                    <input type="text" required class="form-control @error('first_name') error @enderror" value="{{$user->profile->first_name}}" id="first_name" name="first_name" placeholder="Имя">
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
                                                    <input type="text" required class="form-control @error('last_name') error @enderror" value="{{$user->profile->last_name}}" id="last_name" name="last_name" placeholder="Имя">
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
                                                        <option value="">Родительская категория</option>
                                                        @foreach($roles as $role)
                                                            <option {{$role->name == $user->roles->first()->name ? 'selected' : ''}} value="{{$role->name}}">
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
                                                    <select class="form-select js-select2" name="filial_id" id="filial_id" data-placeholder="Без Филиала">
                                                        <option value="">Без филиала</option>
                                                        @foreach($filials as $filial)
                                                            <option {{$filial->id ===  $user->filial_id ? 'selected' : ''}} value="{{$filial->id}}">{{$filial->name}}</option>
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
                                                    <input type="text" class="form-control" id="email" value="{{$user->email}}" placeholder="example@mail.ru" name="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="mobile_phone">Мобильный телефон</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control" value="{{$user->profile->contact_phone}}" id="mobile_phone" name="mobile_phone" placeholder="373 777 77 777">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                        <option {{$user->active == true ? 'selected' : ''}} value="true">Активный</option>
                                                        <option {{$user->active == false ? 'selected' : ''}} value="false">Неактивный</option>
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
{{--                                                    <a href="{{route('client.generate', $user)}}" class="btn btn-warning text-dark ">Распечатать новый пароль</a>--}}
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

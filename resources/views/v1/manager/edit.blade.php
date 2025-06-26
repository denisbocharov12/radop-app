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
                                <h4 class="title nk-block-title">Редактировать менеджера #{{ $manager->id }}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('manager.list.update.form', $manager->id)}}" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="first_name">Имя</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('first_name') error @enderror" id="first_name" name="first_name" value="{{ $manager->profile->first_name }}" placeholder="Имя">
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
                                                    <input type="text" class="form-control @error('last_name') error @enderror" id="last_name" name="last_name" value="{{ $manager->profile->last_name }}" placeholder="Фамилия">
                                                    @error('last_name')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('last_name') error @enderror" id="email" name="email" value="{{ $manager->email }}" placeholder="Email">
                                                    @error('email')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">Телефон</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('phone') error @enderror" id="phone" name="phone" value="{{ $manager->profile->phone }}" placeholder="Телефон">
                                                    @error('phone')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="city_id">Город</label>
                                                <div class="form-control-wrap">
                                                    <select required class="form-select js-select2" data-search="on" name="city_id" id="city_id" data-placeholder="Город">
                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}" {{$city->id === $manager->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                        <option {{$manager->status == true ? 'selected' : ''}} value="true">Активный</option>
                                                        <option {{$manager->status == false ? 'selected' : ''}} value="false">Неактивный</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить менеджера</button>
                                                </li>
                                                <li>
                                                    <a href="{{route('client.generate', $manager)}}" class="btn btn-warning text-dark ">Распечатать новый пароль</a>
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

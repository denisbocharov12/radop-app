@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Менеджер #{{ $manager->id }}</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Email: {{ $manager->email }}</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="{{ route('manager.list.edit.form', $manager->id) }}" class="btn btn-warning">Редактировать</a>
                                <a href="{{ route('manager.list.index') }}" class="btn btn-light">Назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <h5>Username: {{ $manager->name }}</h5>
                                <h6>Имя: {{ $manager?->profile->first_name }}</h6>
                                <h6>Фамилия: {{ $manager?->profile->last_name }}</h6>
                                <h6>Email: {{ $manager->email }}</h6>
                                <h6>Телефон: {{ $manager?->profile->phone }}</h6>
                                <h6>Город: {{ $manager?->city->name}}</h6>
                                <h6>Статус:
                                    {{$manager->status ? 'Активный' : 'Неактивный'}}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
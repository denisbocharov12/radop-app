@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
{{--                                        @foreach($errors->all() as $error)--}}
{{--                                            <li>{{$error}}</li>--}}
{{--                                        @endforeach--}}
                                    </ul>
                                </div>
                            @endif
                            <div class="nk-block-head-content">
                                <h4 class="title nk-block-title">Назначение менеджера пользователю №{{$user->id}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('manager.update')}}" method="post" class="form-validate is-alter">
                                    @csrf
                                    <input type="hidden" name="user" value="{{$user->id}}">
                                    <div class="row g-gs">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h6>Назначение менеджера пользователю - {{$user->profile->first_name}} {{$user->profile->last_name}}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Выбор менеджера</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-control-select">
                                                        <select name="manager_id" class="form-select js-select2" data-search="on">
                                                            @foreach($managers as $manager)
                                                                <option value="{{$manager->id}}" {{$user->manager_id !== $manager->id ? 'selected' : ''}}>{{$manager->profile->first_name}} {{$manager->profile->last_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary">Назначить</button>
                                            </div>
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

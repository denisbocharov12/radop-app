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
                                <h4 class="title nk-block-title">Создание меню</h4>
                                <div class="nk-block-des">
                                    <p>Заполните форму для создания нового меню</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('admin.menus.store')}}" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="code">Код меню<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('code') error @enderror" id="code" name="code" value="{{old('code')}}" placeholder="main_menu">
                                                    @error('code')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                    <span class="form-note">Уникальный код для идентификации меню (например: main_catalog, header_menu)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Название меню<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('name') error @enderror" id="name" name="name" value="{{old('name')}}" placeholder="Главное меню">
                                                    @error('name')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="link">Ссылка</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('link') error @enderror" id="link" name="link" value="{{old('link')}}" placeholder="/catalog">
                                                    @error('link')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                    <span class="form-note">Основная ссылка меню (необязательно)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="is_active" id="is_active" data-placeholder="Выберите статус">
                                                        <option value="1" selected>Активное</option>
                                                        <option value="0">Неактивное</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="description">Описание</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control no-resize @error('description') error @enderror" id="description" name="description" placeholder="Описание меню">{{old('description')}}</textarea>
                                                    @error('description')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Отмена</a>
                                                <button type="submit" class="btn btn-primary">Создать меню</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


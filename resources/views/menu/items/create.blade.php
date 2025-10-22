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
                                <h4 class="title nk-block-title">Создание элемента меню</h4>
                                <div class="nk-block-des">
                                    <p>Меню: <strong>{{$menu->name}}</strong> (<code>{{$menu->code}}</code>)</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('admin.menus.items.store', $menu->id)}}" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="type">Тип элемента<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="type" id="type">
                                                        <option value="">Выберите тип</option>
                                                        <option value="category">Категория</option>
                                                        <option value="custom_link">Пользовательская ссылка</option>
                                                        <option value="promo_block">Промо-блок</option>
                                                    </select>
                                                    @error('type')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title">Название<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('title') error @enderror" id="title" name="title" value="{{old('title')}}" placeholder="Название элемента">
                                                    @error('title')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="parent_id">Родительский элемент</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="parent_id" id="parent_id">
                                                        <option value="">Нет (корневой элемент)</option>
                                                        @foreach($menu->items as $item)
                                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="link">Ссылка</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="link" name="link" value="{{old('link')}}" placeholder="/category/office">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="target">Target</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="target" id="target">
                                                        <option value="_self">_self (текущее окно)</option>
                                                        <option value="_blank">_blank (новое окно)</option>
                                                        <option value="_parent">_parent</option>
                                                        <option value="_top">_top</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="icon_class">CSS класс иконки</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="icon_class" name="icon_class" value="{{old('icon_class')}}" placeholder="fas fa-home">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="order">Порядок</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" id="order" name="order" value="{{old('order', 0)}}" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="is_active" id="is_active">
                                                        <option value="1" selected>Активный</option>
                                                        <option value="0">Неактивный</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Дополнительные данные (JSON)</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control no-resize" name="content_data[description]" placeholder='Описание для промо-блока'></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-secondary">Отмена</a>
                                                <button type="submit" class="btn btn-primary">Создать элемент</button>
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


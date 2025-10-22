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
                                <h4 class="title nk-block-title">Редактирование меню: {{$menu->name}}</h4>
                                <div class="nk-block-des">
                                    <p>Код меню: <code>{{$menu->code}}</code></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Основные настройки</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Элементы меню ({{$menu->items->count()}})</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabItem1">
                                        <form action="{{route('admin.menus.update', $menu->id)}}" method="POST" class="form-validate is-alter">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-gs mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="code">Код меню<span class="text-danger">*</span></label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" required class="form-control @error('code') error @enderror" id="code" name="code" value="{{$menu->code}}" placeholder="main_menu">
                                                            @error('code')
                                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">Название меню<span class="text-danger">*</span></label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" required class="form-control @error('name') error @enderror" id="name" name="name" value="{{$menu->name}}" placeholder="Главное меню">
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
                                                            <input type="text" class="form-control @error('link') error @enderror" id="link" name="link" value="{{$menu->link}}" placeholder="/catalog">
                                                            @error('link')
                                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Статус</label>
                                                        <div class="form-control-wrap">
                                                            <select class="form-select js-select2" required name="is_active" id="is_active">
                                                                <option value="1" {{$menu->is_active ? 'selected' : ''}}>Активное</option>
                                                                <option value="0" {{!$menu->is_active ? 'selected' : ''}}>Неактивное</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="description">Описание</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control no-resize @error('description') error @enderror" id="description" name="description">{{$menu->description}}</textarea>
                                                            @error('description')
                                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Назад</a>
                                                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tabItem2">
                                        <div class="mt-3">
                                            <div class="nk-block-head nk-block-head-sm">
                                                <div class="nk-block-between">
                                                    <div class="nk-block-head-content">
                                                        <h5 class="nk-block-title">Элементы меню</h5>
                                                    </div>
                                                    <div class="nk-block-head-content">
                                                        <a href="{{ route('admin.menus.items.create', $menu->id) }}" class="btn btn-primary btn-sm">
                                                            <em class="icon ni ni-plus"></em> Добавить элемент
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($menu->items->count() > 0)
                                                <div class="nk-tb-list is-separate mb-3">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col"><span>Название</span></div>
                                                        <div class="nk-tb-col"><span>Тип</span></div>
                                                        <div class="nk-tb-col"><span>Ссылка</span></div>
                                                        <div class="nk-tb-col"><span>Родитель</span></div>
                                                        <div class="nk-tb-col"><span>Порядок</span></div>
                                                        <div class="nk-tb-col"><span>Статус</span></div>
                                                        <div class="nk-tb-col nk-tb-col-tools text-end"></div>
                                                    </div>
                                                    @foreach($flatMenuItems as $item)
                                                        <div class="nk-tb-item">
                                                            <div class="nk-tb-col">
                                                                <span class="tb-product">
                                                                    @for($i = 0; $i < $item['depth']; $i++)
                                                                        <span class="text-muted">— </span>
                                                                    @endfor
                                                                    <span class="title">{{ $item['title'] }}</span>
                                                                </span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span class="badge bg-info">{{ $item['type'] }}</span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span class="tb-sub">{{ \Illuminate\Support\Str::limit($item['link'] ?? '—', 30) }}</span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span class="tb-sub">{{ $item['parent_id'] ?? '—' }}</span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span class="tb-sub">{{ $item['order'] }}</span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                @if($item['is_active'])
                                                                    <span class="badge bg-success">Активен</span>
                                                                @else
                                                                    <span class="badge bg-secondary">Неактивен</span>
                                                                @endif
                                                            </div>
                                                            <div class="nk-tb-col nk-tb-col-tools">
                                                                <ul class="nk-tb-actions gx-1 my-n1">
                                                                    <li class="me-n1">
                                                                        <div class="dropdown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li><a href="{{ route('admin.menus.items.edit', [$menu->id, $item['id']]) }}"><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('delete-item-{{ $item['id'] }}').submit();"><em class="icon ni ni-trash"></em><span>Удалить</span></a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <form id="delete-item-{{ $item['id'] }}" action="{{ route('admin.menus.items.destroy', [$menu->id, $item['id']]) }}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    <p class="mb-0">Нет элементов меню. <a href="{{ route('admin.menus.items.create', $menu->id) }}">Добавить первый элемент</a></p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


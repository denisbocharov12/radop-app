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
                                <h4 class="title nk-block-title">Редактирование категории {{$category->name}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('category.update', $category)}}" enctype="multipart/form-data" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Название категории</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('name') error @enderror" id="name" name="name" value="{{$category->name}}" placeholder="Категория">
                                                    @error('name')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Родительская категория</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="parent_id" id="parent_id" data-placeholder="Родительская категория">
                                                        <option value="">Родительская категория</option>
                                                        @foreach($categories as $item)
                                                            <option {{$category->parent_id == $item->id ? 'selected' : ''}}  value="{{$item->id}}">{{$item->name}}</option>
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
                                                        <option value="">Статус</option>
                                                        <option {{$category->status == true ? 'selected' : ''}} value="true">Активная</option>
                                                        <option {{$category->status == false ? 'selected' : ''}} value="false">Неактивная</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="summary">Краткое описание</label>
                                                <div class="form-control-wrap">
                                                    <textarea type="text" class="form-control @error('summary') error @enderror" id="summary" name="summary" placeholder="Краткое описание">{{$category->summary}}</textarea>
                                                    @error('summary')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-block-head nk-block-head-sm">
                                            <div class="nk-block-between g-3">
                                                <div class="nk-block-head-content">
                                                    <h3 class="nk-block-title page-title">Изображения категории</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-gs">
                                            @foreach($category->getMedia('media') as $image)
                                                <div class="col-sm-6 col-lg-4 col-xxl-3" id="model-media-{{$image->id}}">
                                                    <div class="gallery card card-bordered">
                                                        <a class="gallery-image popup-image" href="{{$image->getUrl()}}">
                                                            <img class="w-100 rounded-top" src="{{$image->getUrl()}}" alt="">
                                                        </a>
                                                        <div class="gallery-body card-inner align-center justify-between flex-wrap g-2">
                                                            <div class="user-card">
                                                                <div class="user-info">
                                                                    <span class="lead-text">#{{$image->id}} - {{$image->name}}</span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <a id="model-media-delete-{{$image->id}}" href="#" data-id="{{$image->id}}" data-model-id="{{$category->id}}" class="product-media-delete btn btn-p-0 btn-nofocus" title="Удалить"><em class="icon ni ni-trash"></em></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить категорию</button>
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

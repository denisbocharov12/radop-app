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
                                <h4 class="title nk-block-title">Редактирование бренда {{$brand->title}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('brand.update', $brand)}}" enctype="multipart/form-data" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title">Название бренда</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('title') error @enderror" id="title" name="title" value="{{$brand->title}}" placeholder="Бренд">
                                                    @error('title')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                        <option value="">Статус</option>
                                                        <option {{$brand->status == true ? 'selected' : ''}} value="true">Активная</option>
                                                        <option {{$brand->status == false ? 'selected' : ''}} value="false">Неактивная</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Описание бренда</label>
                                                <div class="form-control-wrap">
                                                    <textarea type="text" name="description" class="form-control no-resize @error('description') error @enderror" id="description">{{$brand->description}}</textarea>
                                                    @error('description')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Фотография категории</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-file">
                                                        <input type="file" name="attachments[]" multiple="" class="form-file-input" id="categoryAttachments">
                                                        <label class="form-file-label" for="categoryAttachments">Выбрать</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-block-head nk-block-head-sm">
                                            <div class="nk-block-between g-3">
                                                <div class="nk-block-head-content">
                                                    <h3 class="nk-block-title page-title">Изображения бренда</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-gs">
                                            @foreach($brand->getMedia('media') as $image)
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
                                                                <a id="model-media-delete-{{$image->id}}" href="#" data-id="{{$image->id}}" data-model-id="{{$brand->id}}" class="model-media-delete btn btn-p-0 btn-nofocus" title="Удалить"><em class="icon ni ni-trash"></em></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить бренд</button>
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
        $(document).on('click','.model-media-delete',function (e) {
            e.preventDefault();
            var image_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('brand.media.delete', $brand)}}";
            $.ajax({
                url: path,
                type: "POST",
                dataType:"JSON",
                data:{
                    id: image_id,
                    _token: token
                },
                success:function (response) {
                    if(response.status) {
                        $('#model-media-'+image_id).fadeOut();
                    } else {
                    }
                }
            });
        });
    </script>
@endsection

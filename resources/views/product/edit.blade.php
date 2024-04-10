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
                                <h4 class="title nk-block-title">Редактирование товара #{{$product->title}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('product.update', $product)}}" enctype="multipart/form-data" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title">Название товара</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('title') error @enderror" value="{{$product->title}}" id="title" name="title" placeholder="Видеокамера 720HD">
                                                    @error('title')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="price">Цена</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('price') error @enderror" id="price" value="{{$product->price}}" name="price" placeholder="560">
                                                    @error('price')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="sale_price">Цена на скидке</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('sale_price') error @enderror" value="{{$product->sale_price}}" id="sale_price" name="sale_price" placeholder="254">
                                                    @error('sale_price')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="unit">Единица измерения</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('unit') error @enderror" id="unit" value="{{$product->unit}}" name="unit" placeholder="штук.">
                                                    @error('unit')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="stock">Кол-во на складе</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control @error('stock') error @enderror" id="stock" value="{{$product->stock}}" name="stock" placeholder="234">
                                                    @error('stock')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="category_id">Категория</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" required name="category_id[]" multiple id="category_id" data-placeholder="Выберите категорию">
                                                        <option value="">Категория</option>
                                                        @foreach($categories as $category)

                                                            @php
                                                            if (count($product->categories) > 1) {
                                                                $existedProductCategory = \App\Models\ProductCategory::query()->where('product_id', $product->onec_id)->where('category_id', $category->onec_id)->first();
                                                            }
                                                            else {
                                                                $existedProductCategory = \App\Models\ProductCategory::query()->where('product_id', $product->onec_id)->first();
                                                            }

                                                            @endphp

                                                            <option {{$existedProductCategory->category_id === $category->onec_id ? 'selected' : ''}} value="{{$category->onec_id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="brand_id">Брэнд</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" required name="brand_id" id="brand_id" data-placeholder="Выберите брэнд">
                                                        <option value="">Брэнд</option>
                                                        @foreach($brands as $brand)
                                                            <option {{$product->brand_id === $brand->onec_id ? 'selected' : ''}}  value="{{$brand->onec_id}}">{{$brand->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="status">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                        <option value="">Статус</option>
                                                        <option {{$product->status == true ? 'selected' : ''}} value="true">Активный</option>
                                                        <option {{$product->status == false ? 'selected' : ''}} value="false">Неактивный</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="description">Описание товара</label>
                                                <div class="form-control-wrap">
                                                    <textarea name="description" class="form-control no-resize" id="description">{{$product->description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Фотографии к товару</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-file">
                                                        <input type="file" name="attachments[]" multiple="" class="form-file-input" id="productAttachments">
                                                        <label class="form-file-label" for="productAttachments">Выбрать</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit"  class="btn btn-primary">Обновить товар</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between g-3">
                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title">Изображения товара</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row g-gs">
                            @foreach($product->getMedia('media') as $image)
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
                                                <a id="model-media-delete-{{$image->id}}" href="#" data-id="{{$image->id}}" data-model-id="{{$product->id}}" class="model-media-delete product-media-delete btn btn-p-0 btn-nofocus" title="Удалить"><em class="icon ni ni-trash"></em></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
            var path = "{{route('product.media.delete', $product)}}";
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

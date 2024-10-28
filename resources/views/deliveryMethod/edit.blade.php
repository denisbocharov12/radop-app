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
                                <h4 class="title nk-block-title">Редактирование метода доставки {{$deliveryMethod->name}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('deliveryMethod.update', $deliveryMethod)}}" enctype="multipart/form-data" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Название метода доставки (RO)</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('name_ro') error @enderror" id="name_ro" name="name_ro" value="{{$deliveryMethod->getTranslation('name', 'ro')}}" placeholder="Категория">
                                                    @error('name_ro')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Название метода доставки (RU)</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('name_ru') error @enderror" id="name_ru" name="name_ru" value="{{$deliveryMethod->getTranslation('name', 'ru')}}" placeholder="Категория">
                                                    @error('name_ru')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="delivery_price">Стоимость доставки</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('delivery_price') error @enderror" id="delivery_price" name="delivery_price" value="{{$deliveryMethod->delivery_price}}" placeholder="123">
                                                    @error('delivery_price')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="min_cart_sum">Мин. сумма для бесплатной доставки</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('min_cart_sum') error @enderror" id="min_cart_sum" name="min_cart_sum" value="{{$deliveryMethod->min_cart_sum}}" placeholder="123">
                                                    @error('min_cart_sum')
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
                                                        <option {{$deliveryMethod->status == true ? 'selected' : ''}} value="true">Активная</option>
                                                        <option {{$deliveryMethod->status == false ? 'selected' : ''}} value="false">Неактивная</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить метода доставки</button>
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

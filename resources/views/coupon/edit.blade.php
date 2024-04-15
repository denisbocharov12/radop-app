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
                                <h4 class="title nk-block-title">Редактирование купона {{$coupon->code}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('category.update', $coupon)}}" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="value">Тип купона</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" name="type" id="type" data-placeholder="Тип купона">
                                                        <option value="">Тип купона</option>
                                                    @if($coupon->type === $couponTypes['percent'])
                                                        <option {{"selected"}} value={{$coupon->type}}>Процентная ставка</option>
                                                        <option value={{$coupon->type}}>Фиксированная ставка</option>
                                                    @else
                                                        <option {{"selected"}} value={{$coupon->type}}>Фиксированная ставка</option>
                                                        <option value={{$coupon->type}}>Процентная ставка</option>
                                                    @endif
                                                    </select>

{{--                                                    @dd($couponTypes['percent'])--}}
{{--                                                    @if ($coupon->type === $couponTypes['percent']){--}}
{{--                                                    <option class="selected">Процентная ставка</option>--}}
{{--                                                }--}}
{{--                                                    @else ($coupon->type === $couponTypes['fixed']){--}}
{{--                                                    <option>Фиксированная ставка</option>--}}

{{--                                                    <input type="number" required class="form-control @error('type') error @enderror" value="{{$coupon->type}}" id="type" name="type">--}}
{{--                                                    @error('type')--}}
{{--                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>--}}
{{--                                                    @enderror--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="value">Значение %</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" required class="form-control @error('value') error @enderror" value="{{$coupon->value}}" id="value" name="value">
                                                    @error('value')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="minimal_total">Минимальная сумма для активации купона</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" required class="form-control @error('minimal_total') error @enderror" value="{{$coupon->minimal_total}}" id="minimal_total" name="minimal_total">
                                                    @error('minimal_total')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="value">Код</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('code') error @enderror" value="{{$coupon->code}}" id="code" name="code">
                                                    @error('code')
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
                                                        <option {{$coupon->status == true ? 'selected' : ''}} value="true">Активная</option>
                                                        <option {{$coupon->status == false ? 'selected' : ''}} value="false">Неактивная</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Начало действия купона</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="start_date" id="start_date" value="{{$coupon->start_date}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Конец действия купона</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="end_date" id="end_date" value="{{$coupon->end_date}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить купон</button>
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

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
                                <h4 class="title nk-block-title">Редактирование периода скидки {{$discountPeriod->id}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('discount-period.update', $discountPeriod)}}" enctype="multipart/form-data" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="sum_from">Сумма от</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('sum_from') error @enderror" id="sum_from" name="sum_from" value="{{(float)$discountPeriod->sum_from}}" placeholder="500">
                                                    @error('sum_from')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="sum_to">Сумма до</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('sum_from') error @enderror" id="sum_to" name="sum_to" value="{{(float)$discountPeriod->sum_to}}" placeholder="1500">
                                                    @error('sum_to')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="discount_koef">Коэф скидки</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.001" required class="form-control @error('discount_koef') error @enderror" id="discount_koef" name="discount_koef" value="{{(float)$discountPeriod->discount_koef}}" placeholder="1.25">
                                                    @error('discount_koef')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить период скидеи</button>
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

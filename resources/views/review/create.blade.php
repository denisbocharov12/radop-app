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
                                <h4 class="title nk-block-title">Создание отзыва</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('review.store')}}" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Пользователь</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="user_id" id="user_id" data-placeholder="Выберите пользователя">
                                                        <option value="">Выберите пользователя</option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Товар</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="product_onec_id" id="product_onec_id" data-placeholder="Выберите товар">
                                                        <option value="">Выберите товар</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->onec_id}}">{{$product->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_onec_id')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="score">Оценка (от 0 до 5)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.5" min="0" max="5" required class="form-control @error('score') error @enderror" id="score" name="score" value="5" placeholder="5">
                                                    @error('score')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="status" id="status" data-placeholder="Выберите статус">
                                                        <option value="0">На модерации</option>
                                                        <option value="1">Одобрен</option>
                                                    </select>
                                                    @error('status')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Подтвержденная покупка</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="is_verified" id="is_verified" data-placeholder="Подтвержденная покупка">
                                                        <option value="0">Нет</option>
                                                        <option value="1">Да</option>
                                                    </select>
                                                    @error('is_verified')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="text">Текст отзыва</label>
                                                <div class="form-control-wrap">
                                                    <textarea required class="form-control @error('text') error @enderror" id="text" name="text" rows="5" placeholder="Введите текст отзыва"></textarea>
                                                    @error('text')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary">Создать отзыв</button>
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

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2();
        });
    </script>
@endsection


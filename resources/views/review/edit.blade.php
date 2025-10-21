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
                                <h4 class="title nk-block-title">Редактирование отзыва #{{$review->id}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('review.update', $review)}}" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Пользователь</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="user_id" id="user_id" data-placeholder="Выберите пользователя">
                                                        <option value="">Выберите пользователя</option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}" {{$review->user_id == $user->id ? 'selected' : ''}}>{{$user->name}} ({{$user->email}})</option>
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
                                                            <option value="{{$product->onec_id}}" {{$review->product_onec_id == $product->onec_id ? 'selected' : ''}}>{{$product->title}}</option>
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
                                                    <input type="number" step="0.5" min="0" max="5" required class="form-control @error('score') error @enderror" id="score" name="score" value="{{$review->score}}" placeholder="5">
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
                                                        <option value="0" {{$review->status == false ? 'selected' : ''}}>На модерации</option>
                                                        <option value="1" {{$review->status == true ? 'selected' : ''}}>Одобрен</option>
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
                                                        <option value="0" {{$review->is_verified == false ? 'selected' : ''}}>Нет</option>
                                                        <option value="1" {{$review->is_verified == true ? 'selected' : ''}}>Да</option>
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
                                                    <textarea required class="form-control @error('text') error @enderror" id="text" name="text" rows="5" placeholder="Введите текст отзыва">{{$review->text}}</textarea>
                                                    @error('text')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary">Обновить отзыв</button>
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


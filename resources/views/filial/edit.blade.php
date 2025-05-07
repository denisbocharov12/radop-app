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
                                <h4 class="title nk-block-title">Редактирование филиала {{$filial->name}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('filial.update', $filial)}}" enctype="multipart/form-data" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">Адрес</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('address') error @enderror" id="address" name="address" value="{{$filial->address}}" placeholder="Адрес">
                                                    @error('address')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">Телефон</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('phone') error @enderror" id="phone" name="phone" value="{{$filial->phone}}" placeholder="06255122">
                                                    @error('phone')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="city_id">Город</label>
                                                <div class="form-control-wrap">
                                                    <select required class="form-select js-select2" data-search="on" name="city_id" id="city_id" data-placeholder="Город">
                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}" {{$city->id === $filial->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить</button>
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
        $(document).ready(function() {
            $('.js-select2').select2({
                allowClear: true
            });
        });
    </script>
@endsection

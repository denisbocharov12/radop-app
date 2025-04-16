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
                                                <label class="form-label" for="name">Название филиала</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('name') error @enderror" id="name" name="name" value="{{$filial->name}}" placeholder="Филиал #1">
                                                    @error('name')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
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
                                                <label class="form-label" for="contact_name">Контактное лицо</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('contact_name') error @enderror" id="contact_name" name="contact_name" value="{{$filial->contact_name}}" placeholder="Контакное лицо">
                                                    @error('contact_name')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить пользователя</button>
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

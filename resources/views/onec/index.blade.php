@extends('v1.layouts.layout')

@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
{{--                    @include('backend.errors.errors')--}}
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title">1С Предприятие</h4>
                            </div>
                        </div>
                        <div class="nk-block">
                            <div class="card">
                                <div class="card-inner">
                                    <h5 class="card-title">Импорт категорий</h5>
                                    <form action="{{route('import-export-data.categories')}}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-control" name="attachment">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><span>Импортировать категории</span><em class="icon ni ni-setting"></em></button>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-inner">
                                    <h5 class="card-title">Импорт брэндов</h5>
                                    <form action="{{route('import-export-data.brands')}}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-control" name="attachment">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><span>Импортировать брэнды</span><em class="icon ni ni-setting"></em></button>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-inner">
                                    <h5 class="card-title">Импорт номенклатуры</h5>
                                    <form action="{{route('import-export-data.nomenclature')}}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-control" name="attachment">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><span>Импортировать номенклатуру</span><em class="icon ni ni-setting"></em></button>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-inner">
                                    <h5 class="card-title">Импорт аттрибутов</h5>
                                    <form action="{{route('import-export-data.attribute')}}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-control" name="attachment">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><span>Импортировать аттрибуты</span><em class="icon ni ni-setting"></em></button>
                                    </form>
                                </div>
                            </div>
                            @if(!\App\Models\Attribute::query()->count() < 1)
                                <div class="card">
                                    <div class="card-inner">
                                        <h5 class="card-title">Импорт значений аттрибутов</h5>
                                        <form action="{{route('import-export-data.attribute.values')}}" enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="form-file">
                                                        <input type="file" class="form-control" name="attachment">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary"><span>Импортировать значения</span><em class="icon ni ni-setting"></em></button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-inner">
                                    <h5 class="card-title">Синхронизация изображений</h5>
                                    <form action="{{route('import-export-data.images')}}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-control" name="attachment">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><span>Синхронизировать изображения</span><em class="icon ni ni-setting"></em></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- nk-block -->
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

@endsection

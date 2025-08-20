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
                                @if($categoryBatch !== null)
                                    @php
                                        $batch = \Illuminate\Support\Facades\Bus::findBatch($categoryBatch->id);
                                    @endphp
                                    <div class="card-inner">
                                        <h6 class="card-title">Последний импорт - {{$batch->createdAt}}</h6>
                                        <p class="fs-12px"><span class="fw-bold"> Завершен: </span> <span class="fw-italic">{{$batch->finishedAt}}</span></p>
                                        <p class="fs-12px"><span class="fw-bold"> Ошибки: </span><span class="fw-italic">{{$batch->failedJobs}}</span></p>
                                        <p class="fs-12px"><span class="fw-bold">Кол-во: </span><span class="fw-italic">{{\App\Models\Category::all()->count()}} </span></p>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" data-progress="{{$batch->progress()}}">{{$batch->progress()}}%</div>
                                        </div>
                                    </div>
                                @endif
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
                                @if($brandBatch !== null)
                                    @php
                                        $batch = \Illuminate\Support\Facades\Bus::findBatch($brandBatch->id);
                                    @endphp
                                    <div class="card-inner">
                                        <h6 class="card-title">Последний импорт - {{$batch->createdAt}}</h6>
                                        <p class="fs-12px"><span class="fw-bold"> Завершен: </span> <span class="fw-italic">{{$batch->finishedAt}}</span></p>
                                        <p class="fs-12px"><span class="fw-bold"> Ошибки: </span><span class="fw-italic">{{$batch->failedJobs}}</span></p>
                                        <p class="fs-12px"><span class="fw-bold">Кол-во: </span><span class="fw-italic">{{\App\Models\Brand::all()->count()}} </span></p>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" data-progress="{{$batch->progress()}}">{{$batch->progress()}}%</div>
                                        </div>
                                    </div>
                                @endif
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
                                @if($productBatch !== null)
                                    @php
                                        $batch = \Illuminate\Support\Facades\Bus::findBatch($productBatch->id);
                                    @endphp
                                    <div class="card-inner">
                                        <h6 class="card-title">Последний импорт - {{$batch->createdAt}}</h6>
                                        <p class="fs-12px"><span class="fw-bold"> Завершен: </span> <span class="fw-italic">{{$batch->finishedAt}}</span></p>
                                        <p class="fs-12px"><span class="fw-bold"> Ошибки: </span><span class="fw-italic">{{$batch->failedJobs}}</span></p>
                                        <p class="fs-12px"><span class="fw-bold">Кол-во: </span><span class="fw-italic">{{\App\Models\Product::all()->count()}} </span></p>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" data-progress="{{$batch->progress()}}">{{$batch->progress()}}%</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if(!\App\Models\Product::query()->count() < 1)
                                <div class="card">
                                    <div class="card-inner">
                                        <h5 class="card-title">Импорт упаковки</h5>
                                        <form action="{{route('import-export-data.package')}}" enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="form-file">
                                                        <input type="file" class="form-control" name="attachment">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary"><span>Импортировать упаковку</span><em class="icon ni ni-setting"></em></button>
                                        </form>
                                    </div>
                                    @if($packageBatch !== null)
                                        @php
                                            $batch = \Illuminate\Support\Facades\Bus::findBatch($packageBatch->id);
                                        @endphp
                                        <div class="card-inner">
                                            <h6 class="card-title">Последний импорт - {{$batch->createdAt}}</h6>
                                            <p class="fs-12px"><span class="fw-bold"> Завершен: </span> <span class="fw-italic">{{$batch->finishedAt}}</span></p>
                                            <p class="fs-12px"><span class="fw-bold"> Ошибки: </span><span class="fw-italic">{{$batch->failedJobs}}</span></p>
                                            <div class="progress progress-lg">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" data-progress="{{$batch->progress()}}">{{$batch->progress()}}%</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @if(!\App\Models\Product::query()->count() < 1)
                                <div class="card">
                                    <div class="card-inner">
                                        <h5 class="card-title">Импорт описания</h5>
                                        <form action="{{route('import-export-data.description')}}" enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="form-file">
                                                        <input type="file" class="form-control" name="attachment">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary"><span>Импортировать описания</span><em class="icon ni ni-setting"></em></button>
                                        </form>
                                    </div>
                                    @if($descriptionBatch !== null)
                                        @php
                                            $batch = \Illuminate\Support\Facades\Bus::findBatch($descriptionBatch->id);
                                        @endphp
                                        <div class="card-inner">
                                            <h6 class="card-title">Последний импорт - {{$batch->createdAt}}</h6>
                                            <p class="fs-12px"><span class="fw-bold"> Завершен: </span> <span class="fw-italic">{{$batch->finishedAt}}</span></p>
                                            <p class="fs-12px"><span class="fw-bold"> Ошибки: </span><span class="fw-italic">{{$batch->failedJobs}}</span></p>
                                            <div class="progress progress-lg">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" data-progress="{{$batch->progress()}}">{{$batch->progress()}}%</div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endif
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
                                @if($attributeBatch !== null)
                                    @php
                                        $batch = \Illuminate\Support\Facades\Bus::findBatch($attributeBatch->id);
                                    @endphp
                                    <div class="card-inner">
                                        <h6 class="card-title">Последний импорт - {{$batch->createdAt}}</h6>
                                        <p class="fs-12px"><span class="fw-bold"> Завершен: </span> <span class="fw-italic">{{$batch->finishedAt}}</span></p>
                                        <p class="fs-12px"><span class="fw-bold"> Ошибки: </span><span class="fw-italic">{{$batch->failedJobs}}</span></p>
                                        <p class="fs-12px"><span class="fw-bold">Кол-во: </span><span class="fw-italic">{{\App\Models\Attribute::all()->count()}} </span></p>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" data-progress="{{$batch->progress()}}">{{$batch->progress()}}%</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if(!\App\Models\Attribute::query()->count() < 1)
                                <div class="card">
                                    <div class="card-inner">
                                        <h5 class="card-title">Импорт значений аттрибутов</h5>
                                        <form action="{{route('import-export-data.values')}}" enctype="multipart/form-data" method="POST">
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
                                    @if($attributeValueBatch !== null)
                                        @php
                                            $batch = \Illuminate\Support\Facades\Bus::findBatch($attributeValueBatch->id);
                                        @endphp
                                        <div class="card-inner">
                                            <h6 class="card-title">Последний импорт - {{$batch->createdAt}}</h6>
                                            <p class="fs-12px"><span class="fw-bold"> Завершен: </span> <span class="fw-italic">{{$batch->finishedAt}}</span></p>
                                            <p class="fs-12px"><span class="fw-bold"> Ошибок в процессах: </span><span class="fw-italic">{{$batch->failedJobs}}</span></p>
                                            <p class="fs-12px"><span class="fw-bold"> Всего процессов: </span><span class="fw-italic">{{$batch->totalJobs}}</span></p>
                                            <p class="fs-12px"><span class="fw-bold"> Кол-во: </span><span class="fw-italic">{{\App\Models\AttributeValue::all()->count()}} </span></p>
                                            <div class="progress progress-lg">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" data-progress="{{$batch->progress()}}">{{$batch->progress()}}%</div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endif
                            <div class="card">
                                <div class="card-inner">
                                    <h5 class="card-title">Импорт изображений товаров</h5>
                                    <p class="text-muted">Оптимизация и создание responsive изображений для всех товаров</p>
                                    <form action="{{route('import-export-data.images')}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success"><span>Импортировать и оптимизировать изображения</span><em class="icon ni ni-image"></em></button>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-inner">
                                    <h5 class="card-title">Оптимизация изображений для брендов</h5>
                                    <p class="text-muted">Оптимизация изображений для всех брендов</p>
                                    <form action="{{route('import-export-data.brand-images.optimize')}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary"><span>Оптимизировать изображения для уже загруженных брендов</span><em class="icon ni ni-reload"></em></button>
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
@extends('v1.layouts.layout')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Настройки сортировки страниц</h3>
                        </div>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card">
                    <div class="card-inner">
                        <form method="POST" action="{{ route('page-setting.page-sort-settings.update') }}">
                            @csrf
                            <div class="row g-4">
                                @foreach($pages as $key => $label)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="{{ $key }}">{{ $label }}</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select" id="{{ $key }}" name="{{ $key }}">
                                                    @foreach($sortOptionsByPage[$key] as $value => $text)
                                                        <option value="{{ $value }}" @if(isset($settings[$key]) && $settings[$key]->default_sort == $value) selected @endif>{{ $text }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

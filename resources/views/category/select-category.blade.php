@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content" style="margin-top: 70px">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('v1.errors.errors')
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="title nk-block-title">Выбор категории для сортировки товаров</h4>
                                <div class="nk-block-des text-soft">
                                    <p>Выберите категорию из списка для настройки сортировки товаров</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form method="GET" action="{{ route('category.sort.products.order.index') }}">
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-label" for="category_id">Выберите категорию</label>
                                                <select class="form-select js-select2" id="category_id" name="category_id" required>
                                                    <option value="">-- Выберите категорию --</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->onec_id }}"
                                                                @if(request('category_id') == $category->onec_id) selected @endif>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary d-block w-100">
                                                    <em class="icon ni ni-sort"></em>
                                                    Перейти к сортировке
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if(request('category_id'))
                            <div class="card mt-4">
                                <div class="card-inner">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h5 class="title">Товары в выбранной категории</h5>
                                        </div>
                                    </div>
                                    @if($selectedCategory && $selectedCategory->products->count() > 0)
                                        <div class="alert alert-info">
                                            <p>В категории "{{ $selectedCategory->name }}" найдено {{ $selectedCategory->products->count() }} товаров.</p>
                                             <a href="{{ route('category.sort.products.order.index', ['category_id' => $selectedCategory->onec_id]) }}" class="btn btn-primary">
                                                <em class="icon ni ni-sort"></em>
                                                Настроить сортировку
                                            </a>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <p>В выбранной категории нет товаров для сортировки.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2({
                placeholder: 'Выберите категорию',
                allowClear: true
            });
        });
    </script>
@endsection

@extends('v1.layouts.layout')

@section('content')
    <style>
        .toast.toast-success,
        .toast.toast-error {
            padding: 20px;
            font-size: 16px;
            text-align: center;
            margin-left: auto;
        }
        .toast.toast-success {
            background-color: #0a7859;
            color: white;
        }
        .toast.toast-error {
            background-color: #a52834;
            color: white;
        }
    </style>
    <div class="nk-content" style="margin-top: 70px">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('v1.errors.errors')
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="title nk-block-title">Сортировка атрибутов по категории</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form method="get" action="{{ route('attribute.sort.category.index') }}" class="mb-4">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-8">
                                            <label class="form-label" for="category">Категория</label>
                                            <select class="form-select js-select2" name="category" id="category" data-placeholder="Выберите категорию">
                                                <option value="">Выберите категорию</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->onec_id }}" {{ $selectedCategory && $selectedCategory->onec_id === $cat->onec_id ? 'selected' : '' }}>{{ $cat->path_label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">Показать</button>
                                        </div>
                                    </div>
                                </form>
                                @if($selectedCategory)
                                    <p class="text-soft small mb-3">Порядок атрибутов для категории «{{ $selectedCategory->name }}». Перетаскивайте элементы для изменения порядка.</p>
                                    <ul id="category-attribute-contents" class="">
                                        @foreach($attributesForSort as $attribute)
                                            <li class="item-sortable p-2 border mb-1" data-id="{{ $attribute->id }}">
                                                <span class="fw-bold"><em class="icon ni ni-sort"></em> {{ $attribute->name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-soft">Выберите категорию и нажмите «Показать», чтобы настроить порядок атрибутов.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#category').select2({
                placeholder: 'Выберите категорию',
                allowClear: true,
                minimumResultsForSearch: 0
            });
            var categoryId = "{{ $selectedCategory ? $selectedCategory->onec_id : '' }}";
            if (!categoryId) return;

            $('#category-attribute-contents').sortable({
                items: '.item-sortable',
                cursor: 'all-scroll',
                opacity: 0.6,
                placeholder: 'highlights',
                forcePlaceholderSize: true,
                update: function() {
                    var order = [];
                    $('li.item-sortable', '#category-attribute-contents').each(function(index) {
                        order.push({ id: $(this).data('id'), position: index });
                    });
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: "{{ route('attribute.sort.category.order') }}",
                        data: {
                            category_id: categoryId,
                            order: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status) toastr.success(response.text);
                            else toastr.error('Ошибка');
                        },
                        error: function() { toastr.error('Ошибка'); }
                    });
                }
            });
        });
    </script>
@endsection

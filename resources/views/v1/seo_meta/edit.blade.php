@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Редактировать SEO-запись</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Редактирование SEO записи для страницы</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('v1.errors.errors')
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="page_type">Тип страницы</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" id="page_type" required>
                                                        <option value="">Выберите тип страницы</option>
                                                        @foreach($pageTypes as $value => $label)
                                                            <option value="{{ $value }}" {{ old('page_type', $seoMeta->page_type) == $value ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" id="page_id_container" style="display: none;">
                                            <div class="form-group">
                                                <label class="form-label" for="page_id">ID страницы</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="page_id" value="{{ old('page_id', $seoMeta->page_id) }}" placeholder="Введите ID страницы">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs mt-3">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tab-ru">RU</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab-ro">RO</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-ru">
                                            <form action="{{ $seoMetaRu ? route('seo_meta.update', $seoMetaRu) : route('seo_meta.store') }}" method="POST" enctype="multipart/form-data" class="pt-3">
                                                @csrf
                                                @if($seoMetaRu)
                                                    @method('PUT')
                                                @endif
                                                <input type="hidden" name="page_type" id="hidden_page_type_ru" value="{{ $seoMeta->page_type }}">
                                                <input type="hidden" name="page_id" id="hidden_page_id_ru" value="{{ $seoMeta->page_id }}">
                                                <input type="hidden" name="locale" value="ru">
                                                <div class="row g-4">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="title_ru">Заголовок (RU)</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="title_ru" name="title" value="{{ old('title', $seoMetaRu->title ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="description_ru">Описание (RU)</label>
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control" id="description_ru" name="description" rows="4">{{ old('description', $seoMetaRu->description ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="keywords_ru">Ключевые слова (RU) (без пробелов через запятую до 5 ед.)</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="keywords_ru" name="keywords" value="{{ old('keywords', $seoMetaRu->keywords ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="canonical_ru">Каноническая ссылка (RU)</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="canonical_ru" name="canonical" value="{{ old('canonical', $seoMetaRu->canonical ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="robots_ru">Robots (RU)</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="robots_ru" name="robots" value="{{ old('robots', $seoMetaRu->robots ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Загрузить изображение (RU)</label>
                                                            <div class="form-control-wrap">
                                                                <div class="form-file">
                                                                    <input type="file" name="attachments[]" multiple class="form-file-input">
                                                                    <label class="form-file-label">Выбрать</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head nk-block-head-sm">
                                                        <div class="nk-block-between g-3">
                                                            <div class="nk-block-head-content">
                                                                <h3 class="nk-block-title page-title">Изображениe SEO (RU)  (Рекомендуемый размер: 1200x630)</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-gs">
                                                        @foreach(($seoMetaRu?->getMedia('files') ?? collect()) as $image)
                                                            <div class="col-sm-6 col-lg-4 col-xxl-3" id="model-media-{{ $image->id }}">
                                                                <div class="gallery card card-bordered">
                                                                    <a class="gallery-image popup-image" href="{{ $image->getUrl() }}">
                                                                        <img class="w-100 rounded-top" src="{{ $image->getUrl() }}" alt="">
                                                                    </a>
                                                                    <div class="gallery-body card-inner align-center justify-between flex-wrap g-2">
                                                                        <div class="user-card">
                                                                            <div class="user-info">
                                                                                <span class="lead-text">#{{ $image->id }} - {{ $image->name }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" data-id="{{ $image->id }}" data-model-id="{{ $seoMetaRu?->id }}" class="model-media-delete btn btn-p-0 btn-nofocus" title="Удалить"><em class="icon ni ni-trash"></em></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary">
                                                                <em class="icon ni ni-save"></em>
                                                                <span>Сохранить RU</span>
                                                            </button>
                                                            @if($seoMetaRu)
                                                                <form action="{{ route('seo_meta.destroy', $seoMetaRu) }}" method="POST" style="display:inline-block">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger ms-2" onclick="return confirm('Удалить RU?')">
                                                                        <em class="icon ni ni-trash"></em>
                                                                        <span>Удалить RU</span>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="tab-ro">
                                            <form action="{{ $seoMetaRo ? route('seo_meta.update', $seoMetaRo) : route('seo_meta.store') }}" method="POST" enctype="multipart/form-data" class="pt-3">
                                                @csrf
                                                @if($seoMetaRo)
                                                    @method('PUT')
                                                @endif
                                                <input type="hidden" name="page_type" id="hidden_page_type_ro" value="{{ $seoMeta->page_type }}">
                                                <input type="hidden" name="page_id" id="hidden_page_id_ro" value="{{ $seoMeta->page_id }}">
                                                <input type="hidden" name="locale" value="ro">
                                                <div class="row g-4">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="title_ro">Заголовок (RO)</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="title_ro" name="title" value="{{ old('title', $seoMetaRo->title ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="description_ro">Описание (RO)</label>
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control" id="description_ro" name="description" rows="4">{{ old('description', $seoMetaRo->description ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="keywords_ro">Ключевые слова (RO) (без пробелов через запятую до 5 ед.)</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="keywords_ro" name="keywords" value="{{ old('keywords', $seoMetaRo->keywords ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="canonical_ro">Каноническая ссылка (RO)</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="canonical_ro" name="canonical" value="{{ old('canonical', $seoMetaRo->canonical ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="robots_ro">Robots (RO)</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="robots_ro" name="robots" value="{{ old('robots', $seoMetaRo->robots ?? '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Загрузить изображение (RO) (Рекомендуемый размер: 1200x630)</label>
                                                            <div class="form-control-wrap">
                                                                <div class="form-file">
                                                                    <input type="file" name="attachments[]" multiple class="form-file-input">
                                                                    <label class="form-file-label">Выбрать</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head nk-block-head-sm">
                                                        <div class="nk-block-between g-3">
                                                            <div class="nk-block-head-content">
                                                                <h3 class="nk-block-title page-title">Изображениe SEO (RO)</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-gs">
                                                        @foreach(($seoMetaRo?->getMedia('files') ?? collect()) as $image)
                                                            <div class="col-sm-6 col-lg-4 col-xxl-3" id="model-media-{{ $image->id }}">
                                                                <div class="gallery card card-bordered">
                                                                    <a class="gallery-image popup-image" href="{{ $image->getUrl() }}">
                                                                        <img class="w-100 rounded-top" src="{{ $image->getUrl() }}" alt="">
                                                                    </a>
                                                                    <div class="gallery-body card-inner align-center justify-between flex-wrap g-2">
                                                                        <div class="user-card">
                                                                            <div class="user-info">
                                                                                <span class="lead-text">#{{ $image->id }} - {{ $image->name }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" data-id="{{ $image->id }}" data-model-id="{{ $seoMetaRo?->id }}" class="model-media-delete btn btn-p-0 btn-nofocus" title="Удалить"><em class="icon ni ni-trash"></em></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary">
                                                                <em class="icon ni ni-save"></em>
                                                                <span>Сохранить RO</span>
                                                            </button>
                                                            @if($seoMetaRo)
                                                                <form action="{{ route('seo_meta.destroy', $seoMetaRo) }}" method="POST" style="display:inline-block">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger ms-2" onclick="return confirm('Удалить RO?')">
                                                                        <em class="icon ni ni-trash"></em>
                                                                        <span>Удалить RO</span>
                                                                    </button>
                                                                </form>
                                                            @endif
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageTypeSelect = document.getElementById('page_type');
    const pageIdContainer = document.getElementById('page_id_container');
    const pageIdInput = document.getElementById('page_id');

    const hiddenPageTypeRu = document.getElementById('hidden_page_type_ru');
    const hiddenPageIdRu = document.getElementById('hidden_page_id_ru');
    const hiddenPageTypeRo = document.getElementById('hidden_page_type_ro');
    const hiddenPageIdRo = document.getElementById('hidden_page_id_ro');

    const staticPages = @json(array_keys($staticPages));
    const dynamicPages = @json(array_keys($dynamicPages));

    function syncHidden() {
        if (hiddenPageTypeRu) hiddenPageTypeRu.value = pageTypeSelect.value;
        if (hiddenPageTypeRo) hiddenPageTypeRo.value = pageTypeSelect.value;
        if (hiddenPageIdRu) hiddenPageIdRu.value = pageIdInput.value;
        if (hiddenPageIdRo) hiddenPageIdRo.value = pageIdInput.value;
    }

    function togglePageIdField() {
        const selectedValue = pageTypeSelect.value;

        if (dynamicPages.includes(selectedValue)) {
            pageIdContainer.style.display = 'block';
            pageIdInput.required = true;
            pageIdInput.placeholder = 'Введите ID страницы';
        } else {
            pageIdContainer.style.display = 'none';
            pageIdInput.required = false;
            pageIdInput.value = '';
        }
        syncHidden();
    }

    pageTypeSelect.addEventListener('change', togglePageIdField);
    pageIdInput.addEventListener('input', syncHidden);

    togglePageIdField();
});

$(document).on('click','.model-media-delete',function (e) {
    e.preventDefault();
    var image_id = $(this).data('id');
    var token = "{{csrf_token()}}";
    var path = "{{ route('seo_meta.media.delete', $seoMeta) }}";
    $.ajax({
        url: path,
        type: "GET",
        dataType:"JSON",
        data:{
            id: image_id,
            _token: token
        },
        success:function (response) {
            if(response.status) {
                $('#model-media-'+image_id).fadeOut();
            }
        }
    });
});
</script>
@endsection

@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Добавить SEO-запись</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Создание новой SEO записи для страницы</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('v1.errors.errors')
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner">
                                    <form action="{{ route('seo_meta.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row g-4">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="page_type">Тип страницы</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-select" id="page_type" name="page_type" required>
                                                            <option value="">Выберите тип страницы</option>
                                                            @foreach($pageTypes as $value => $label)
                                                                <option value="{{ $value }}" {{ old('page_type') == $value ? 'selected' : '' }}>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('page_type')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" id="page_id_container" style="display: none;">
                                                <div class="form-group">
                                                    <label class="form-label" for="page_id">ID страницы</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="page_id" name="page_id" value="{{ old('page_id') }}" placeholder="Введите ID страницы">
                                                        @error('page_id')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="locale">Язык</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-select" id="locale" name="locale" required>
                                                            <option value="">Выберите язык</option>
                                                            <option value="ru" {{ old('locale') == 'ru' ? 'selected' : '' }}>Русский</option>
                                                            <option value="ro" {{ old('locale') == 'ro' ? 'selected' : '' }}>Română</option>
                                                        </select>
                                                        @error('locale')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="title">Заголовок страницы</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                                                        @error('title')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="description">Описание страницы</label>
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                                        @error('description')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="keywords">Ключевые слова (без пробелов через запятую до 5 ед.)</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="keywords" name="keywords" value="{{ old('keywords') }}">
                                                        @error('keywords')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="canonical">Каноническая ссылка</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="canonical" name="canonical" value="{{ old('canonical') }}">
                                                        @error('canonical')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="robots">Инструкции для роботов</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="robots" name="robots" value="{{ old('robots') }}">
                                                        @error('robots')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Изображениe (Рекомендуемый размер: 1200x630)</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-file">
                                                            <input type="file" name="attachments[]" multiple class="form-file-input" id="seoMetaAttachments">
                                                            <label class="form-file-label" for="seoMetaAttachments">Выбрать</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <em class="icon ni ni-save"></em>
                                                        <span>Сохранить</span>
                                                    </button>
                                                    <a href="{{ route('seo_meta.index') }}" class="btn btn-outline-secondary">
                                                        <em class="icon ni ni-arrow-left"></em>
                                                        <span>Назад</span>
                                                    </a>
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageTypeSelect = document.getElementById('page_type');
    const pageIdContainer = document.getElementById('page_id_container');
    const pageIdInput = document.getElementById('page_id');

    const staticPages = @json(array_keys($staticPages));
    const dynamicPages = @json(array_keys($dynamicPages));

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
    }

    pageTypeSelect.addEventListener('change', togglePageIdField);

    togglePageIdField();
});
</script>
@endsection

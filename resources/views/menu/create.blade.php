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
                                <h4 class="title nk-block-title">Создание меню</h4>
                                <div class="nk-block-des">
                                    <p>Заполните форму для создания нового меню</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('admin.menus.store')}}" method="POST" class="form-validate is-alter" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="code">Код меню<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('code') error @enderror" id="code" name="code" value="{{old('code')}}" placeholder="main_menu">
                                                    @error('code')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                    <span class="form-note">Уникальный код для идентификации меню (например: main_catalog, header_menu)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name_ro">Название меню (RO)<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('name_ro') error @enderror" id="name_ro" name="name_ro" value="{{old('name_ro')}}" placeholder="Meniu principal">
                                                    @error('name_ro')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name_ru">Название меню (RU)<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('name_ru') error @enderror" id="name_ru" name="name_ru" value="{{old('name_ru')}}" placeholder="Главное меню">
                                                    @error('name_ru')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="link_ro">Ссылка (RO)</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('link_ro') error @enderror" id="link_ro" name="link_ro" value="{{old('link_ro')}}" placeholder="/catalog">
                                                    @error('link_ro')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="link_ru">Ссылка (RU)</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('link_ru') error @enderror" id="link_ru" name="link_ru" value="{{old('link_ru')}}" placeholder="/catalog">
                                                    @error('link_ru')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                    <span class="form-note">Основная ссылка меню (необязательно)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="is_active" id="is_active" data-placeholder="Выберите статус">
                                                        <option value="1" selected>Активное</option>
                                                        <option value="0">Неактивное</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="description_ro">Описание (RO)</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control no-resize @error('description_ro') error @enderror" id="description_ro" name="description_ro" placeholder="Descrierea meniului">{{old('description_ro')}}</textarea>
                                                    @error('description_ro')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="description_ru">Описание (RU)</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control no-resize @error('description_ru') error @enderror" id="description_ru" name="description_ru" placeholder="Описание меню">{{old('description_ru')}}</textarea>
                                                    @error('description_ru')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="menu_image">Изображение меню (PNG, SVG)</label>
                                                <div class="form-control-wrap">
                                                    <input type="file" class="form-control" id="menu_image" name="image" accept="image/png,image/svg+xml">
                                                    <small class="form-text text-muted">Максимальный размер: 2MB. Форматы: PNG, SVG</small>
                                                    <div id="menu-image-preview" style="min-height: 60px;">
                                                        <img id="menu-image-preview-img" src="" alt="Preview" style="max-width: 100px; max-height: 100px; display: none; border: 1px solid #e5e9f2; border-radius: 4px; padding: 4px; margin-top: 8px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Отмена</a>
                                                <button type="submit" class="btn btn-primary">Создать меню</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Превью изображения меню
            const menuImageInput = document.getElementById('menu_image');
            const menuImagePreview = document.getElementById('menu-image-preview-img');

            if (menuImageInput && menuImagePreview) {
                menuImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            menuImagePreview.src = e.target.result;
                            menuImagePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        menuImagePreview.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection


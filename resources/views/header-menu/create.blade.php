@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Создание шапки меню" description="Заполните форму для создания нового шапки меню">
        <x-slot:actions>
            <a href="{{ route('admin.header-menus.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Назад
            </a>
        </x-slot:actions>
    </x-page-header>

    @include('v1.errors.errors')

    <x-card>
        <form action="{{ route('admin.header-menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Код меню<span class="text-red-500">*</span></label>
                    <input type="text" required id="code" name="code" value="{{ old('code') }}" placeholder="main_menu"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('code') border-red-400 @enderror">
                    @error('code')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    <small class="mt-1 block text-xs text-gray-500">Уникальный код для идентификации меню (например: main_catalog, header_menu)</small>
                </div>
                <div>
                    <label for="name_ro" class="block text-sm font-medium text-gray-700 mb-1">Название меню (RO)<span class="text-red-500">*</span></label>
                    <input type="text" required id="name_ro" name="name_ro" value="{{ old('name_ro') }}" placeholder="Meniu principal"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('name_ro') border-red-400 @enderror">
                    @error('name_ro')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="name_ru" class="block text-sm font-medium text-gray-700 mb-1">Название меню (RU)<span class="text-red-500">*</span></label>
                    <input type="text" required id="name_ru" name="name_ru" value="{{ old('name_ru') }}" placeholder="Главное меню"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('name_ru') border-red-400 @enderror">
                    @error('name_ru')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="link_ro" class="block text-sm font-medium text-gray-700 mb-1">Ссылка (RO)</label>
                    <input type="text" id="link_ro" name="link_ro" value="{{ old('link_ro') }}" placeholder="/catalog"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('link_ro') border-red-400 @enderror">
                    @error('link_ro')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="link_ru" class="block text-sm font-medium text-gray-700 mb-1">Ссылка (RU)</label>
                    <input type="text" id="link_ru" name="link_ru" value="{{ old('link_ru') }}" placeholder="/catalog"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('link_ru') border-red-400 @enderror">
                    @error('link_ru')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    <small class="mt-1 block text-xs text-gray-500">Основная ссылка меню (необязательно)</small>
                </div>
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                    <select required name="is_active" id="is_active"
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                        <option value="1" selected>Активное</option>
                        <option value="0">Неактивное</option>
                    </select>
                </div>
                <div>
                    <label for="description_ro" class="block text-sm font-medium text-gray-700 mb-1">Описание (RO)</label>
                    <textarea id="description_ro" name="description_ro" rows="3" placeholder="Descrierea meniului"
                              class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('description_ro') border-red-400 @enderror">{{ old('description_ro') }}</textarea>
                    @error('description_ro')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="description_ru" class="block text-sm font-medium text-gray-700 mb-1">Описание (RU)</label>
                    <textarea id="description_ru" name="description_ru" rows="3" placeholder="Описание меню"
                              class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('description_ru') border-red-400 @enderror">{{ old('description_ru') }}</textarea>
                    @error('description_ru')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="menu_image" class="block text-sm font-medium text-gray-700 mb-1">Изображение меню (PNG, SVG)</label>
                    <input type="file" id="menu_image" name="image" accept="image/png,image/svg+xml"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                    <small class="mt-1 block text-xs text-gray-500">Максимальный размер: 2MB. Форматы: PNG, SVG</small>
                    <div id="menu-image-preview" class="mt-2">
                        <img id="menu-image-preview-img" src="" alt="Preview" class="hidden max-h-24 max-w-[100px] rounded-lg border border-gray-200 p-1">
                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="btn-primary">Создать шапку меню</button>
                <a href="{{ route('admin.header-menus.index') }}" class="btn-secondary">Отмена</a>
            </div>
        </form>
    </x-card>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuImageInput = document.getElementById('menu_image');
            const menuImagePreview = document.getElementById('menu-image-preview-img');
            if (menuImageInput && menuImagePreview) {
                menuImageInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (ev) { menuImagePreview.src = ev.target.result; menuImagePreview.classList.remove('hidden'); };
                        reader.readAsDataURL(file);
                    } else { menuImagePreview.classList.add('hidden'); }
                });
            }
        });
    </script>
@endsection

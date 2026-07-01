@extends('v2.layouts.app')

@section('content')
    <x-page-header title="Создание элемента меню" description="Меню: {{ $menu->name }} ({{ $menu->code }})">
        <x-slot:actions>
            <a href="{{ route('admin.header-menus.edit', $menu->id) }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Назад
            </a>
        </x-slot:actions>
    </x-page-header>

    @include('v1.errors.errors')

    <x-card>
        <form action="{{ route('admin.header-menus.items.store', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Тип элемента<span class="text-red-500">*</span></label>
                    <select required name="type" id="type"
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('type') border-red-400 @enderror">
                        <option value="">Выберите тип</option>
                        <option value="category" data-autofill="true">Категория</option>
                        <option value="custom_link">Пользовательская ссылка</option>
                        <option value="promo_block">Промо-блок</option>
                        <option value="widget_link">Виджет ссылки</option>
                    </select>
                    @error('type')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="title_ro" class="block text-sm font-medium text-gray-700 mb-1">Название (RO)<span class="text-red-500">*</span></label>
                    <input type="text" required id="title_ro" name="title_ro" value="{{ old('title_ro') }}" placeholder="Titlul elementului"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('title_ro') border-red-400 @enderror">
                    @error('title_ro')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="title_ru" class="block text-sm font-medium text-gray-700 mb-1">Название (RU)<span class="text-red-500">*</span></label>
                    <input type="text" required id="title_ru" name="title_ru" value="{{ old('title_ru') }}" placeholder="Название элемента"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('title_ru') border-red-400 @enderror">
                    @error('title_ru')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Родительский элемент</label>
                    <select name="parent_id" id="parent_id"
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                        <option value="">Нет (корневой элемент)</option>
                        @foreach($parentOptions as $option)
                            <option value="{{ $option['value'] }}" {{ old('parent_id') == $option['value'] ? 'selected' : '' }}>{{ $option['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="category-select-wrapper" style="display: none;">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Категория (для автозаполнения)</label>
                    <select class="js-select2 no-select2 block w-full" name="category_id" id="category_id" data-placeholder="Выберите категорию" data-search="true">
                        <option value="">Выберите категорию</option>
                    </select>
                </div>
                <div>
                    <label for="link_ro" class="block text-sm font-medium text-gray-700 mb-1">Ссылка (RO)</label>
                    <input type="text" id="link_ro" name="link_ro" value="{{ old('link_ro') }}" placeholder="/category/office"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label for="link_ru" class="block text-sm font-medium text-gray-700 mb-1">Ссылка (RU)</label>
                    <input type="text" id="link_ru" name="link_ru" value="{{ old('link_ru') }}" placeholder="/category/office"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label for="target" class="block text-sm font-medium text-gray-700 mb-1">Действие</label>
                    <select name="target" id="target"
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                        <option value="_self">_self (текущее окно)</option>
                        <option value="_blank">_blank (новое окно)</option>
                        <option value="_parent">_parent</option>
                        <option value="_top">_top</option>
                    </select>
                </div>
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Порядок</label>
                    <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Изображение (PNG, SVG)</label>
                    <input type="file" id="image" name="image" accept="image/png,image/svg+xml"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                    <small class="mt-1 block text-xs text-gray-500">Максимальный размер: 2MB. Форматы: PNG, SVG</small>
                    <div id="image-preview" class="mt-2">
                        <img id="image-preview-img" src="" alt="Preview" class="hidden max-h-24 max-w-[100px] rounded-lg border border-gray-200 p-1">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                    <select name="is_active" id="is_active"
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                        <option value="1" selected>Активный</option>
                        <option value="0">Неактивный</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Дополнительные данные (JSON)</label>
                    <textarea name="content_data[description]" rows="3" placeholder="Описание для промо-блока"
                              class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none"></textarea>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="btn-primary">Создать элемент</button>
                <a href="{{ route('admin.header-menus.edit', $menu->id) }}" class="btn-secondary">Отмена</a>
            </div>
        </form>
    </x-card>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const categorySelectWrapper = document.getElementById('category-select-wrapper');
            const categorySelect = document.getElementById('category_id');
            const titleRoInput = document.getElementById('title_ro');
            const titleRuInput = document.getElementById('title_ru');
            const linkRoInput = document.getElementById('link_ro');
            const linkRuInput = document.getElementById('link_ru');
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview-img');
            let categories = [];
            let categoriesLoading = false;

            function notify(text, type) {
                if (window.Alpine && window.Alpine.store('toast')) window.Alpine.store('toast').add(text, type === 'error' ? 'error' : 'success');
                else alert(text);
            }

            if (!typeSelect || !categorySelectWrapper || !categorySelect) return;

            function loadCategories() {
                if (categories.length > 0 || categoriesLoading) return;
                categoriesLoading = true;
                fetch('{{ route("admin.header-menus.categories.list") }}')
                    .then(response => { if (!response.ok) throw new Error('Network response was not ok: ' + response.status); return response.json(); })
                    .then(data => {
                        if (!Array.isArray(data)) throw new Error('Invalid data format: expected array');
                        categories = data;
                        while (categorySelect.options.length > 1) categorySelect.remove(1);
                        data.forEach(category => {
                            const option = document.createElement('option');
                            option.value = String(category.id);
                            option.textContent = category.name_ru || category.name || '';
                            option.dataset.nameRo = category.name_ro || '';
                            option.dataset.nameRu = category.name_ru || '';
                            option.dataset.linkRo = category.link_ro || category.link || '';
                            option.dataset.linkRu = category.link_ru || category.link || '';
                            categorySelect.appendChild(option);
                        });
                        if (typeof $ !== 'undefined' && $.fn.select2) {
                            $(categorySelect).parent().css('position', 'relative');
                            $(categorySelect).select2({
                                placeholder: 'Выберите категорию', allowClear: true,
                                dropdownParent: $(categorySelect).parent(),
                                language: { noResults: () => 'Категории не найдены', searching: () => 'Поиск...' }
                            }).on('select2:select', function () {
                                const selectedValue = $(this).val();
                                const category = categories.find(cat => String(cat.id) === String(selectedValue));
                                if (category) {
                                    titleRoInput.value = category.name_ro || '';
                                    titleRuInput.value = category.name_ru || category.name || '';
                                    linkRoInput.value = category.link_ro || category.link || '';
                                    linkRuInput.value = category.link_ru || category.link || '';
                                } else {
                                    const selectedOption = $(this).find('option:selected')[0];
                                    if (selectedOption && selectedOption.dataset) {
                                        titleRoInput.value = selectedOption.dataset.nameRo || '';
                                        titleRuInput.value = selectedOption.dataset.nameRu || selectedOption.textContent.trim() || '';
                                        linkRoInput.value = selectedOption.dataset.linkRo || '';
                                        linkRuInput.value = selectedOption.dataset.linkRu || '';
                                    }
                                }
                            }).on('select2:clear', function () {
                                titleRoInput.value = ''; titleRuInput.value = ''; linkRoInput.value = ''; linkRuInput.value = '';
                            });
                        }
                        categoriesLoading = false;
                    })
                    .catch(error => { notify('Ошибка загрузки категорий: ' + error.message, 'error'); categoriesLoading = false; });
            }

            function handleCategoryChange() {
                const selectedValue = (typeof $ !== 'undefined' ? $(categorySelect).val() : null) || categorySelect.value;
                if (!selectedValue) return;
                const category = categories.find(cat => String(cat.id) === String(selectedValue));
                if (category) {
                    titleRoInput.value = category.name_ro || '';
                    titleRuInput.value = category.name_ru || category.name || '';
                    linkRoInput.value = category.link_ro || category.link || '';
                    linkRuInput.value = category.link_ru || category.link || '';
                } else {
                    let selectedOption = (typeof $ !== 'undefined' && $(categorySelect).data('select2'))
                        ? $(categorySelect).find('option:selected')[0]
                        : categorySelect.options[categorySelect.selectedIndex];
                    if (selectedOption) {
                        titleRoInput.value = selectedOption.dataset.nameRo || '';
                        titleRuInput.value = selectedOption.dataset.nameRu || selectedOption.textContent.trim() || '';
                        linkRoInput.value = selectedOption.dataset.linkRo || '';
                        linkRuInput.value = selectedOption.dataset.linkRu || '';
                    }
                }
            }

            function toggleCategorySelect() {
                const selectedOption = typeSelect.options[typeSelect.selectedIndex];
                const needsCategory = selectedOption && selectedOption.dataset.autofill === 'true';
                categorySelectWrapper.style.display = needsCategory ? 'block' : 'none';
                if (needsCategory) { if (categories.length === 0 && !categoriesLoading) loadCategories(); }
                else { categorySelect.value = ''; }
            }

            toggleCategorySelect();
            typeSelect.addEventListener('change', toggleCategorySelect);
            categorySelect.addEventListener('change', handleCategoryChange);

            if (imageInput && imagePreview) {
                imageInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (ev) { imagePreview.src = ev.target.result; imagePreview.classList.remove('hidden'); };
                        reader.readAsDataURL(file);
                    } else { imagePreview.classList.add('hidden'); }
                });
            }
        });
    </script>
@endsection

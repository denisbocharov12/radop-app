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
                                <h4 class="title nk-block-title">Создание элемента меню</h4>
                                <div class="nk-block-des">
                                    <p>Меню: <strong>{{$menu->name}}</strong> (<code>{{$menu->code}}</code>)</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('admin.menus.items.store', $menu->id)}}" method="POST" class="form-validate is-alter" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="type">Тип элемента<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" required name="type" id="type">
                                                        <option value="">Выберите тип</option>
                                                        <option value="category" data-autofill="true">Категория</option>
                                                        <option value="custom_link">Пользовательская ссылка</option>
                                                        <option value="promo_block">Промо-блок</option>
                                                        <option value="widget_link">Виджет ссылки</option>
                                                    </select>
                                                    @error('type')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title_ro">Название (RO)<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('title_ro') error @enderror" id="title_ro" name="title_ro" value="{{old('title_ro')}}" placeholder="Titlul elementului">
                                                    @error('title_ro')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title_ru">Название (RU)<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('title_ru') error @enderror" id="title_ru" name="title_ru" value="{{old('title_ru')}}" placeholder="Название элемента">
                                                    @error('title_ru')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="parent_id">Родительский элемент</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="parent_id" id="parent_id">
                                                        <option value="">Нет (корневой элемент)</option>
                                                        @foreach($parentOptions as $option)
                                                            <option value="{{$option['value']}}" {{old('parent_id') == $option['value'] ? 'selected' : ''}}>{{$option['label']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="category-select-wrapper" style="display: none;">
                                            <div class="form-group">
                                                <label class="form-label" for="category_id">Категория (для автозаполнения)</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="category_id" id="category_id" data-placeholder="Выберите категорию" data-search="true">
                                                        <option value="">Выберите категорию</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="link_ro">Ссылка (RO)</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="link_ro" name="link_ro" value="{{old('link_ro')}}" placeholder="/category/office">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="link_ru">Ссылка (RU)</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="link_ru" name="link_ru" value="{{old('link_ru')}}" placeholder="/category/office">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="target">Действие</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="target" id="target">
                                                        <option value="_self">_self (текущее окно)</option>
                                                        <option value="_blank">_blank (новое окно)</option>
                                                        <option value="_parent">_parent</option>
                                                        <option value="_top">_top</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="image">Изображение (PNG, SVG)</label>
                                                <div class="form-control-wrap">
                                                    <input type="file" class="form-control" id="image" name="image" accept="image/png,image/svg+xml">
                                                    <small class="form-text text-muted">Максимальный размер: 2MB. Форматы: PNG, SVG</small>
                                                    <div id="image-preview" class="mt-2" style="min-height: 60px;">
                                                        <img id="image-preview-img" src="" alt="Preview" style="max-width: 100px; max-height: 100px; display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="order">Порядок</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" id="order" name="order" value="{{old('order', 0)}}" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" name="is_active" id="is_active">
                                                        <option value="1" selected>Активный</option>
                                                        <option value="0">Неактивный</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Дополнительные данные (JSON)</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control no-resize" name="content_data[description]" placeholder='Описание для промо-блока'></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-secondary">Отмена</a>
                                                <button type="submit" class="btn btn-primary">Создать элемент</button>
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

@section('styles')
    <style>
        .icon-picker-modal .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(55px, 1fr));
            gap: 6px;
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
        }
        .icon-picker-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px 4px;
            border: 1px solid #e5e9f2;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            background: #fff;
            min-height: 60px;
        }
        .icon-picker-item:hover {
            background: #f8f9fa;
            border-color: #526484;
            transform: translateY(-1px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .icon-picker-item.selected {
            background: #526484;
            border-color: #526484;
            color: #fff;
        }
        .icon-picker-item.selected i {
            color: #fff;
        }
        .icon-picker-item i {
            font-size: 18px;
            margin-bottom: 4px;
            color: #526484;
        }
        .icon-picker-item.selected i {
            color: #fff;
        }
        .icon-picker-item span {
            font-size: 9px;
            color: #8b95a7;
            word-break: break-word;
            line-height: 1.2;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .icon-picker-item.selected span {
            color: #fff;
        }
        .icon-picker-search {
            margin-bottom: 15px;
        }
        #image-preview-img {
            border: 1px solid #e5e9f2;
            border-radius: 4px;
            padding: 4px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            
            if (!typeSelect || !categorySelectWrapper || !categorySelect || !titleRoInput || !titleRuInput || !linkRoInput || !linkRuInput) {
                console.error('Required elements not found');
                return;
            }

            // Загрузка категорий
            let categoriesLoading = false;
            function loadCategories() {
                // Если категории уже загружены, не загружаем повторно
                if (categories.length > 0 || categoriesLoading) {
                    return;
                }
                
                categoriesLoading = true;
                console.log('Начинаем загрузку категорий...');
                
                fetch('{{ route("admin.menus.categories.list") }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!Array.isArray(data)) {
                            throw new Error('Invalid data format: expected array');
                        }
                        
                        categories = data;
                        console.log('Загружено категорий:', categories.length, categories);
                        
                        // Очищаем существующие опции (кроме первой пустой)
                        while (categorySelect.options.length > 1) {
                            categorySelect.remove(1);
                        }
                        
                        // Добавляем категории
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
                        
                        console.log('Категории добавлены в селект. Всего опций:', categorySelect.options.length);
                        
                        // Инициализируем select2 с поиском
                        if (typeof $ !== 'undefined' && $.fn.select2) {
                            $(categorySelect).select2({
                                placeholder: 'Выберите категорию',
                                allowClear: true,
                                language: {
                                    noResults: function() {
                                        return 'Категории не найдены';
                                    },
                                    searching: function() {
                                        return 'Поиск...';
                                    }
                                }
                            }).on('select2:select', function(e) {
                                const selectedValue = $(this).val();
                                console.log('Select2 выбрано значение:', selectedValue);
                                
                                const category = categories.find(cat => String(cat.id) === String(selectedValue));
                                console.log('Найденная категория для автозаполнения:', category);
                                
                                if (category) {
                                    titleRoInput.value = category.name_ro || '';
                                    titleRuInput.value = category.name_ru || category.name || '';
                                    linkRoInput.value = category.link_ro || category.link || '';
                                    linkRuInput.value = category.link_ru || category.link || '';
                                    console.log('Автозаполнение из массива:', {
                                        name_ro: category.name_ro,
                                        name_ru: category.name_ru,
                                        link_ro: category.link_ro,
                                        link_ru: category.link_ru
                                    });
                                } else {
                                    const selectedOption = $(this).find('option:selected')[0];
                                    if (selectedOption && selectedOption.dataset) {
                                        titleRoInput.value = selectedOption.dataset.nameRo || '';
                                        titleRuInput.value = selectedOption.dataset.nameRu || selectedOption.textContent.trim() || '';
                                        linkRoInput.value = selectedOption.dataset.linkRo || '';
                                        linkRuInput.value = selectedOption.dataset.linkRu || '';
                                        console.log('Автозаполнение из option:', {
                                            name_ro: selectedOption.dataset.nameRo,
                                            name_ru: selectedOption.dataset.nameRu,
                                            link_ro: selectedOption.dataset.linkRo,
                                            link_ru: selectedOption.dataset.linkRu
                                        });
                                    }
                                }
                            }).on('select2:clear', function(e) {
                                titleRoInput.value = '';
                                titleRuInput.value = '';
                                linkRoInput.value = '';
                                linkRuInput.value = '';
                            });
                        }
                        
                        categoriesLoading = false;
                    })
                    .catch(error => {
                        console.error('Error loading categories:', error);
                        alert('Ошибка загрузки категорий: ' + error.message);
                        categoriesLoading = false;
                    });
            }

            // Функция автозаполнения при выборе категории
            function handleCategoryChange() {
                const selectedValue = $(categorySelect).val() || categorySelect.value;
                console.log('Выбрана категория:', selectedValue);
                
                if (!selectedValue) {
                    return;
                }
                
                // Находим категорию в массиве
                const category = categories.find(cat => {
                    return String(cat.id) === String(selectedValue);
                });
                
                console.log('Найденная категория:', category);
                
                if (category) {
                    titleRoInput.value = category.name_ro || '';
                    titleRuInput.value = category.name_ru || category.name || '';
                    linkRoInput.value = category.link_ro || category.link || '';
                    linkRuInput.value = category.link_ru || category.link || '';
                    console.log('Автозаполнение выполнено:', { 
                        name_ro: category.name_ro, 
                        name_ru: category.name_ru,
                        link_ro: category.link_ro,
                        link_ru: category.link_ru
                    });
                } else {
                    // Fallback: берем данные из выбранного option
                    let selectedOption = null;
                    if (typeof $ !== 'undefined' && $(categorySelect).data('select2')) {
                        // Если select2 инициализирован
                        selectedOption = $(categorySelect).find('option:selected')[0];
                    } else {
                        // Обычный select
                        selectedOption = categorySelect.options[categorySelect.selectedIndex];
                    }
                    if (selectedOption) {
                        titleRoInput.value = selectedOption.dataset.nameRo || '';
                        titleRuInput.value = selectedOption.dataset.nameRu || selectedOption.textContent.trim() || '';
                        linkRoInput.value = selectedOption.dataset.linkRo || '';
                        linkRuInput.value = selectedOption.dataset.linkRu || '';
                        console.log('Автозаполнение (fallback):', { 
                            name_ro: selectedOption.dataset.nameRo, 
                            name_ru: selectedOption.dataset.nameRu,
                            link_ro: selectedOption.dataset.linkRo,
                            link_ru: selectedOption.dataset.linkRu
                        });
                    } else {
                        console.warn('Категория не найдена в массиве и нет данных в option');
                    }
                }
            }

            // Показ/скрытие выбора категории при изменении типа
            function toggleCategorySelect() {
                const selectedOption = typeSelect.options[typeSelect.selectedIndex];
                const needsCategory = selectedOption && selectedOption.dataset.autofill === 'true';
                
                console.log('Изменение типа:', typeSelect.value, 'Нужна категория:', needsCategory);
                
                categorySelectWrapper.style.display = needsCategory ? 'block' : 'none';
                
                if (needsCategory) {
                    // Загружаем категории, если они еще не загружены
                    if (categories.length === 0 && !categoriesLoading) {
                        console.log('Запускаем загрузку категорий...');
                        loadCategories();
                    }
                } else {
                    // Сбрасываем выбор категории, если тип изменился
                    categorySelect.value = '';
                }
            }
            
            // Инициализация при загрузке страницы
            toggleCategorySelect();
            
            // Обработчики событий
            typeSelect.addEventListener('change', toggleCategorySelect);
            // Обработчик для обычного select (если select2 не инициализирован)
            categorySelect.addEventListener('change', handleCategoryChange);

            // Превью изображения
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                }
            });
        });
    </script>
@endsection



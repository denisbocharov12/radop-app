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
                                <h4 class="title nk-block-title">Редактирование меню: {{$menu->name}}</h4>
                                <div class="nk-block-des">
                                    <p>Код меню: <code>{{$menu->code}}</code></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Основные настройки</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Элементы меню ({{$menu->items->count()}})</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabItem1">
                                        <form action="{{route('admin.header-menus.update', $menu->id)}}" method="POST" class="form-validate is-alter" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-gs mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="code">Код меню<span class="text-danger">*</span></label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" required class="form-control @error('code') error @enderror" id="code" name="code" value="{{$menu->code}}" placeholder="main_menu">
                                                            @error('code')
                                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name_ro">Название меню (RO)<span class="text-danger">*</span></label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" required class="form-control @error('name_ro') error @enderror" id="name_ro" name="name_ro" value="{{$menu->getTranslation('name', 'ro')}}" placeholder="Meniu principal">
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
                                                            <input type="text" required class="form-control @error('name_ru') error @enderror" id="name_ru" name="name_ru" value="{{$menu->getTranslation('name', 'ru')}}" placeholder="Главное меню">
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
                                                            <input type="text" class="form-control @error('link_ro') error @enderror" id="link_ro" name="link_ro" value="{{$menu->link && is_array(json_decode($menu->getRawOriginal('link'), true)) ? $menu->getTranslation('link', 'ro') : ($menu->link ?? '')}}" placeholder="/catalog">
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
                                                            <input type="text" class="form-control @error('link_ru') error @enderror" id="link_ru" name="link_ru" value="{{$menu->link && is_array(json_decode($menu->getRawOriginal('link'), true)) ? $menu->getTranslation('link', 'ru') : ($menu->link ?? '')}}" placeholder="/catalog">
                                                            @error('link_ru')
                                                            <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Статус</label>
                                                        <div class="form-control-wrap">
                                                            <select class="form-select js-select2" required name="is_active" id="is_active">
                                                                <option value="1" {{$menu->is_active ? 'selected' : ''}}>Активное</option>
                                                                <option value="0" {{!$menu->is_active ? 'selected' : ''}}>Неактивное</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="description_ro">Описание (RO)</label>
                                                        <div class="form-control-wrap">
                                                            <textarea class="form-control no-resize @error('description_ro') error @enderror" id="description_ro" name="description_ro" placeholder="Descrierea meniului">{{$menu->description && is_array(json_decode($menu->getRawOriginal('description'), true)) ? $menu->getTranslation('description', 'ro') : ($menu->description ?? '')}}</textarea>
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
                                                            <textarea class="form-control no-resize @error('description_ru') error @enderror" id="description_ru" name="description_ru" placeholder="Описание меню">{{$menu->description && is_array(json_decode($menu->getRawOriginal('description'), true)) ? $menu->getTranslation('description', 'ru') : ($menu->description ?? '')}}</textarea>
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
                                                            <div id="menu-image-preview" class="mt-2" style="min-height: 60px;">
                                                                @php
                                                                    $menuImage = $menu->getFirstMedia('menu_image');
                                                                @endphp
                                                                @if($menuImage)
                                                                    <div class="d-flex align-items-center gap-2 mt-2">
                                                                        <img src="{{ $menuImage->getUrl() }}" alt="Menu image" style="max-width: 100px; max-height: 100px; border: 1px solid #e5e9f2; border-radius: 4px; padding: 4px;">
                                                                        <label class="form-check-label">
                                                                            <input type="checkbox" name="clear_image" value="1" class="form-check-input">
                                                                            Удалить изображение
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                                <img id="menu-image-preview-img" src="" alt="Preview" style="max-width: 100px; max-height: 100px; display: none; border: 1px solid #e5e9f2; border-radius: 4px; padding: 4px; margin-top: 8px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <a href="{{ route('admin.header-menus.index') }}" class="btn btn-secondary">Назад</a>
                                                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tabItem2">
                                        <div class="row g-gs mt-3">
                                            <div class="col-lg-8">
                                                <div class="nk-block-head nk-block-head-sm mb-3">
                                                    <div class="nk-block-between">
                                                        <div class="nk-block-head-content">
                                                            <h5 class="nk-block-title">Элементы меню</h5>
                                                        </div>
                                                        <div class="nk-block-head-content">
                                                            <a href="{{ route('admin.header-menus.items.create', $menu->id) }}" class="btn btn-primary btn-sm">
                                                                <em class="icon ni ni-plus"></em> Добавить элемент
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($menu->items->count() > 0)
                                                    <div class="card">
                                                        <div class="card-inner">
                                                            <div id="menu-items-tree" class="menu-items-tree">
                                                                @include('header-menu.partials.tree-items', ['items' => $menu->rootItems, 'menu' => $menu, 'depth' => 0])
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        <p class="mb-0">Нет элементов меню. <a href="{{ route('admin.header-menus.items.create', $menu->id) }}">Добавить первый элемент</a></p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="card">
                                                    <div class="card-inner">
                                                        <h5 class="nk-block-title mb-3">Превью меню</h5>
                                                        <div id="menu-preview" class="menu-preview">
                                                            @include('header-menu.partials.preview', ['menu' => $menu])
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card mt-3">
                                                    <div class="card-inner">
                                                        <h5 class="nk-block-title mb-3">Методы вывода</h5>
                                                        <div class="form-group">
                                                            <label class="form-label">Blade Directive</label>
                                                            <div class="form-control-wrap">
                                                                @php
                                                                    $directiveExample = "@renderMenu('{$menu->code}')";
                                                                @endphp
                                                                <input type="text" readonly class="form-control" value="{{ $directiveExample }}" onclick="this.select();">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">PHP Service</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" readonly class="form-control" value="app('App\Services\MenuRenderService')->render('{{ $menu->code }}')" onclick="this.select();">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Blade Include</label>
                                                            <div class="form-control-wrap">
                                                                @php
                                                                    $includeExample = "@include('partials.menus.mega-menu', ['menu' => \$menu, 'code' => '{$menu->code}', 'cssClass' => ''])";
                                                                @endphp
                                                                <input type="text" readonly class="form-control" value="{{ $includeExample }}" onclick="this.select();">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Код меню</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" readonly class="form-control" value="{{ $menu->code }}" onclick="this.select();">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .menu-items-tree {
            min-height: 200px;
        }
        .menu-item-row {
            margin-bottom: 8px;
            border: 1px solid #e5e9f2;
            border-radius: 4px;
            background: #fff;
            transition: all 0.2s;
        }
        .menu-item-row:hover {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .menu-item-row.sortable-ghost {
            opacity: 0.4;
            background: #f8f9fa;
        }
        .menu-item-handle {
            cursor: move;
            padding: 12px 15px;
        }
        .menu-item-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .menu-item-drag {
            color: #8b95a7;
            cursor: grab;
        }
        .menu-item-drag:active {
            cursor: grabbing;
        }
        .menu-item-info {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .menu-item-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        .menu-item-title {
            font-weight: 500;
        }
        .menu-item-actions {
            display: flex;
            gap: 4px;
        }
        .menu-item-children {
            margin-top: 8px;
        }
        .menu-preview-container {
            max-height: 600px;
            overflow-y: auto;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .menu-preview-nav {
            background: #fff;
            border-radius: 4px;
            padding: 10px;
        }
        .menu-preview-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .menu-preview-item {
            margin-bottom: 4px;
        }
        .menu-preview-link,
        .menu-preview-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            color: #526484;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .menu-preview-link:hover {
            background: #f1f2f3;
            color: #364a63;
        }
        .menu-preview-sublist {
            list-style: none;
            padding-left: 20px;
            margin-top: 4px;
        }
        .menu-preview-item.has-children > .menu-preview-link,
        .menu-preview-item.has-children > .menu-preview-label {
            font-weight: 500;
        }
        .menu-preview-item.has-children > .menu-preview-sublist {
            border-left: 2px solid #e5e9f2;
            margin-left: 8px;
            padding-left: 12px;
        }
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
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuCode = '{{ $menu->code }}';
            const menuItemsTree = document.getElementById('menu-items-tree');

            if (menuItemsTree) {
                const sortable = Sortable.create(menuItemsTree, {
                    handle: '.menu-item-drag',
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    group: 'menu-items',
                    draggable: '.menu-item-row',
                    forceFallback: false,
                    onEnd: function(evt) {
                        updateMenuHierarchy();
                    }
                });

                // Инициализируем Sortable для вложенных контейнеров
                function initNestedSortable(container) {
                    const childrenContainers = container.querySelectorAll('.menu-item-children');
                    childrenContainers.forEach(function(childrenContainer) {
                        if (!childrenContainer.sortableInstance) {
                            childrenContainer.sortableInstance = Sortable.create(childrenContainer, {
                                handle: '.menu-item-drag',
                                animation: 150,
                                fallbackOnBody: true,
                                swapThreshold: 0.65,
                                group: 'menu-items',
                                draggable: '.menu-item-row',
                                forceFallback: false,
                                onEnd: function(evt) {
                                    updateMenuHierarchy();
                                }
                            });
                        }
                    });
                }

                // Инициализируем для существующих вложенных элементов
                initNestedSortable(menuItemsTree);

                // Наблюдаем за изменениями DOM для динамически добавляемых элементов
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && node.classList && node.classList.contains('menu-item-children')) {
                                initNestedSortable(node);
                            } else if (node.nodeType === 1 && node.querySelector) {
                                const childrenContainers = node.querySelectorAll('.menu-item-children');
                                if (childrenContainers.length > 0) {
                                    initNestedSortable(node);
                                }
                            }
                        });
                    });
                });

                observer.observe(menuItemsTree, {
                    childList: true,
                    subtree: true
                });
            }

            function updateMenuHierarchy() {
                const items = [];
                
                function processRows(container, parentId, startOrder) {
                    const rows = Array.from(container.querySelectorAll(':scope > .menu-item-row'));
                    let order = startOrder;
                    
                    rows.forEach((row) => {
                        const itemId = parseInt(row.dataset.itemId);
                        const currentParentId = getParentId(row) || parentId;
                        
                        items.push({
                            id: itemId,
                            parent_id: currentParentId,
                            order: order++
                        });
                        
                        // Обрабатываем вложенные элементы
                        const childrenContainer = row.querySelector('.menu-item-children');
                        if (childrenContainer) {
                            processRows(childrenContainer, itemId, 0);
                        }
                    });
                }
                
                processRows(menuItemsTree, null, 0);

                console.log('Отправка данных сортировки:', items);

                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.error('CSRF токен не найден!');
                    alert('Ошибка: CSRF токен не найден. Обновите страницу.');
                    return;
                }

                const url = `{{ route('admin.header-menus.hierarchy.update', $menu->code) }}`;
                console.log('URL запроса:', url);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ structure: items })
                })
                .then(response => {
                    console.log('Статус ответа:', response.status);
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || `HTTP error! status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Ответ сервера:', data);
                    if (data.success) {
                        updatePreview();
                        console.log('Иерархия успешно обновлена');
                    } else {
                        alert('Ошибка при обновлении иерархии: ' + (data.message || 'Неизвестная ошибка'));
                    }
                })
                .catch(error => {
                    console.error('Ошибка при обновлении иерархии:', error);
                    alert('Ошибка при обновлении иерархии: ' + error.message);
                });
            }

            function getParentId(row) {
                // Ищем родительский элемент в структуре дерева
                let parent = row.parentElement;
                while (parent && parent !== menuItemsTree) {
                    // Проверяем, является ли родитель контейнером для дочерних элементов
                    if (parent.classList && parent.classList.contains('menu-item-children')) {
                        // Ищем родительский menu-item-row
                        let rowParent = parent.parentElement;
                        while (rowParent && rowParent !== menuItemsTree) {
                            if (rowParent.classList && rowParent.classList.contains('menu-item-row')) {
                                return parseInt(rowParent.dataset.itemId);
                            }
                            rowParent = rowParent.parentElement;
                        }
                    } else if (parent.classList && parent.classList.contains('menu-item-row')) {
                        return parseInt(parent.dataset.itemId);
                    }
                    parent = parent.parentElement;
                }
                return null;
            }

            function updatePreview() {
                fetch(`{{ route('admin.header-menus.preview', $menu->id) }}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('menu-preview').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error updating preview:', error);
                });
            }

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

            document.querySelectorAll('.delete-item-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    if (confirm('Вы уверены, что хотите удалить этот элемент?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('admin.header-menus.items.destroy', [$menu->id, 'ITEM_ID']) }}`.replace('ITEM_ID', itemId);
                        form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection



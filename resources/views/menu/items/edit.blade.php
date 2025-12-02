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
                                <h4 class="title nk-block-title">Редактирование элемента меню</h4>
                                <div class="nk-block-des">
                                    <p>Меню: <strong>{{$menu->name}}</strong> | Элемент: <strong>{{$menuItem->title}}</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('admin.menus.items.update', [$menu->id, $menuItem->id])}}" method="POST" class="form-validate is-alter">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="type">Тип элемента<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" required name="type" id="type">
                                                        <option value="">Выберите тип</option>
                                                        <option value="category" {{$menuItem->type == 'category' ? 'selected' : ''}}>Категория</option>
                                                        <option value="custom_link" {{$menuItem->type == 'custom_link' ? 'selected' : ''}}>Пользовательская ссылка</option>
                                                        <option value="promo_block" {{$menuItem->type == 'promo_block' ? 'selected' : ''}}>Промо-блок</option>
                                                    </select>
                                                    @error('type')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title">Название<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('title') error @enderror" id="title" name="title" value="{{$menuItem->title}}" placeholder="Название элемента">
                                                    @error('title')
                                                    <span class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="parent_id">Родительский элемент</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="parent_id" id="parent_id">
                                                        <option value="">Нет (корневой элемент)</option>
                                                        @foreach($parentOptions as $option)
                                                            <option value="{{$option['value']}}" {{$menuItem->parent_id == $option['value'] ? 'selected' : ''}}>{{$option['label']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="link">Ссылка</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="link" name="link" value="{{$menuItem->link}}" placeholder="/category/office">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="target">Target</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="target" id="target">
                                                        <option value="_self" {{$menuItem->target == '_self' ? 'selected' : ''}}>_self (текущее окно)</option>
                                                        <option value="_blank" {{$menuItem->target == '_blank' ? 'selected' : ''}}>_blank (новое окно)</option>
                                                        <option value="_parent" {{$menuItem->target == '_parent' ? 'selected' : ''}}>_parent</option>
                                                        <option value="_top" {{$menuItem->target == '_top' ? 'selected' : ''}}>_top</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="icon_class">CSS класс иконки</label>
                                                <div class="form-control-wrap">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="icon_class" name="icon_class" value="{{$menuItem->icon_class}}" placeholder="fas fa-home">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#iconPickerModal">
                                                            <em class="icon ni ni-grid"></em> Выбрать
                                                        </button>
                                                    </div>
                                                    <div id="icon-preview" class="mt-2" style="min-height: 24px;">
                                                        @if($menuItem->icon_class)
                                                            <i class="{{ $menuItem->icon_class }}"></i> <span>{{ $menuItem->icon_class }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="order">Порядок</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" id="order" name="order" value="{{$menuItem->order}}" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Статус</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="is_active" id="is_active">
                                                        <option value="1" {{$menuItem->is_active ? 'selected' : ''}}>Активный</option>
                                                        <option value="0" {{!$menuItem->is_active ? 'selected' : ''}}>Неактивный</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Дополнительные данные (JSON)</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control no-resize" name="content_data[description]" placeholder='Описание для промо-блока'>{{$menuItem->content_data['description'] ?? ''}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-secondary">Назад</a>
                                                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
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
    @include('menu.partials.icon-picker-modal')
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        #icon-preview i {
            font-size: 18px;
            margin-right: 8px;
            color: #526484;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const iconClassInput = document.getElementById('icon_class');
            const iconPreview = document.getElementById('icon-preview');
            
            if (iconClassInput) {
                iconClassInput.addEventListener('input', function() {
                    updateIconPreview(this.value);
                });
            }

            function updateIconPreview(iconClass) {
                if (iconClass && iconClass.trim()) {
                    iconPreview.innerHTML = `<i class="${iconClass}"></i> <span>${iconClass}</span>`;
                } else {
                    iconPreview.innerHTML = '';
                }
            }

            document.querySelectorAll('.icon-picker-item').forEach(item => {
                item.addEventListener('click', function() {
                    const iconClass = this.dataset.iconClass;
                    iconClassInput.value = iconClass;
                    updateIconPreview(iconClass);
                    const modal = bootstrap.Modal.getInstance(document.getElementById('iconPickerModal'));
                    if (modal) {
                        modal.hide();
                    }
                });
            });

            const iconSearch = document.getElementById('icon-search');
            if (iconSearch) {
                iconSearch.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    document.querySelectorAll('.icon-picker-item').forEach(item => {
                        const iconName = item.dataset.iconName || '';
                        const iconClass = item.dataset.iconClass || '';
                        if (iconName.includes(searchTerm) || iconClass.includes(searchTerm)) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
@endsection



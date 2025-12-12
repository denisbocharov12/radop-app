<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">Код</span></div>
            <div class="nk-tb-col"><span class="sub-text">Название</span></div>
            <div class="nk-tb-col tb-col-md"><span class="sub-text">Ссылка</span></div>
            <div class="nk-tb-col tb-col-md"><span class="sub-text">Элементов</span></div>
            <div class="nk-tb-col tb-col-md"><span class="sub-text">Статус</span></div>
            <div class="nk-tb-col tb-col-md"><span class="sub-text">Дата создания</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end"></div>
        </div><!-- .nk-tb-item -->
        @foreach($menus as $menu)
            <div class="nk-tb-item">
                <div class="nk-tb-col">
                    <div class="user-card">
                        <div class="user-name">
                            <span class="tb-lead"><code>{{ $menu->code }}</code></span>
                        </div>
                    </div>
                </div>
                <div class="nk-tb-col">
                    @php
                        $nameRaw = $menu->getRawOriginal('name');
                        $menuName = is_array(json_decode($nameRaw, true)) 
                            ? $menu->getTranslation('name', app()->getLocale()) 
                            : ($nameRaw ?? '');
                    @endphp
                    <span>{{ $menuName }}</span>
                </div>
                <div class="nk-tb-col tb-col-md">
                    @php
                        $linkRaw = $menu->getRawOriginal('link');
                        $menuLink = is_array(json_decode($linkRaw, true)) 
                            ? $menu->getTranslation('link', app()->getLocale()) 
                            : ($linkRaw ?? '—');
                    @endphp
                    <span class="tb-sub text-primary">{{ $menuLink }}</span>
                </div>
                <div class="nk-tb-col tb-col-md">
                    <span class="badge badge-dim bg-outline-info">{{ $menu->items->count() }}</span>
                </div>
                <div class="nk-tb-col tb-col-md">
                    @if($menu->is_active)
                        <span class="badge bg-success">Активное</span>
                    @else
                        <span class="badge bg-secondary">Неактивное</span>
                    @endif
                </div>
                <div class="nk-tb-col tb-col-md">
                    <span class="tb-sub">{{ $menu->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-1">
                        <li class="nk-tb-action-hidden">
                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Редактировать">
                                <em class="icon ni ni-edit-fill"></em>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{ route('admin.menus.edit', $menu->id) }}"><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="{{ route('admin.menus.items.create', $menu->id) }}"><em class="icon ni ni-plus"></em><span>Добавить элемент</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" onclick="event.preventDefault(); if(confirm('Вы уверены?')) document.getElementById('delete-menu-{{ $menu->id }}').submit();"><em class="icon ni ni-trash"></em><span>Удалить</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <form id="delete-menu-{{ $menu->id }}" action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div><!-- .nk-tb-item -->
        @endforeach
    </div><!-- .nk-tb-list -->
</div><!-- .card-inner -->


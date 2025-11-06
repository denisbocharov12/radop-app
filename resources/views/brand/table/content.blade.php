<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Название</span></div>
            <div class="nk-tb-col text-center"><span class="sub-text">Каталог (Цены 1C)</span></div>
            <div class="nk-tb-col"><span class="sub-text">Статус</span></div>
            <div class="nk-tb-col"><span class="sub-text">Описание</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($brands as $brand)
            <div class="nk-tb-item" id="brand-id-{{$brand->id}}">
                <div class="nk-tb-col">
                    <span>#{{$brand->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$brand->title}}</span>
                </div>
                <div class="nk-tb-col text-center">
                    <a href="#" class="brand-export-btn" 
                       data-brand-id="{{$brand->id}}" 
                       data-bs-toggle="modal" 
                       data-bs-target="#exportBrandModal"
                       title="Экспорт с персональными ценами">
                        @include('frontend.v1.pages.shop.parts.excel-svg')
                    </a>
                </div>
                <div class="nk-tb-col">
                    @if($brand->status)
                        <span class="tb-status text-success">Активная</span>
                    @else
                        <span class="tb-status text-danger">Неактивная</span>
                    @endif
                </div>
                <div class="nk-tb-col">
                    <span>{{$brand->description}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('brand.edit', $brand)}}" data-id="{{$brand->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="model-delete" id="model-delete-{{$brand->id}}" data-id="{{$brand->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- .nk-tb-item -->
        @endforeach
    </div><!-- .nk-tb-list -->
</div><!-- .card-inner -->

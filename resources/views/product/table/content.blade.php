<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col" style="width:30px"><input type="checkbox" id="select-all-products-head"></div>
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Название товара</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Бренд</span></div>
            <div class="nk-tb-col"><span class="sub-text">Категория</span></div>
            <div class="nk-tb-col"><span class="sub-text">Цена</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Цена на скидке</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Остатки</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Cостояние товара</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Статус выгрузки</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Статус сайта</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($products as $product)
            <div class="nk-tb-item" id="product-id-{{$product->id}}">
                <div class="nk-tb-col" style="width:30px"><input type="checkbox" class="product-checkbox" value="{{$product->id}}"></div>
                <div class="nk-tb-col">
                    <span>#{{$product->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$product->title}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$product->brand?->title}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{ $product->categories->pluck('name')->implode(', ') }}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$product->price}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$product->sale_price}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$product->stock}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$product?->data?->condition}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    @if($product->status)
                        <span class="tb-status text-success">Активный</span>
                    @else
                        <span class="tb-status text-danger">Неактивный</span>
                    @endif
                </div>
                <div class="nk-tb-col tb-col-lg">
                    @if($product->site_status)
                        <span class="tb-status text-success">Активный</span>
                    @else
                        <span class="tb-status text-danger">Неактивный</span>
                    @endif
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle"
                                   data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('product.edit', $product)}}" data-id="{{$product->id}}"><em
                                                    class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="product-delete" id="product-delete-{{$product->id}}"
                                               data-id="{{$product->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a>
                                        </li>
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

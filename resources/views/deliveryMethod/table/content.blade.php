<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Название</span></div>
            <div class="nk-tb-col"><span class="sub-text">Стоимость доставки</span></div>
            <div class="nk-tb-col"><span class="sub-text">Мин. сумма для бесплатной доставки</span></div>
            <div class="nk-tb-col"><span class="sub-text">Статус</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($deliveryMethods as $deliveryMethod)
            <div class="nk-tb-item" id="deliveryMethod-id-{{$deliveryMethod->id}}">
                <div class="nk-tb-col">
                    <span>#{{$deliveryMethod->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$deliveryMethod->name}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$deliveryMethod->delivery_price}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$deliveryMethod->min_cart_sum}}</span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    @if($deliveryMethod->status)
                        <span class="tb-status text-success">Активный</span>
                    @else
                        <span class="tb-status text-danger">Неактивный</span>
                    @endif
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('deliveryMethod.edit', $deliveryMethod)}}" data-id="{{$deliveryMethod->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="deliveryMethod-delete" id="deliveryMethod-delete-{{$deliveryMethod->id}}" data-id="{{$deliveryMethod->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
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

<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Название</span></div>
            <div class="nk-tb-col"><span class="sub-text">Цена доставки (MDL)</span></div>
            <div class="nk-tb-col"><span class="sub-text">Мин. сумма заказа (MDL)</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($cities as $city)
            <div class="nk-tb-item" id="city-id-{{$city->id}}">
                <div class="nk-tb-col">
                    <span>#{{$city->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$city->name}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$city->delivery_sum}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$city->required_sum}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('city.edit', $city)}}" data-id="{{$city->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="city-delete" id="city-delete-{{$city->id}}" data-id="{{$city->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
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

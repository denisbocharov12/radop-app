<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col" style="width: 40px;">
                <input type="checkbox" id="select-all-orders-head">
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'id') ? '-id' : 'id' }}" class="text-dark">
                    <span class="sub-text">ID</span>
                    @if(request('sort') == 'id') ▲@elseif(request('sort') == '-id') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'fio') ? '-fio' : 'fio' }}" class="text-dark">
                    <span class="sub-text">Фамилия Имя</span>
                    @if(request('sort') == 'fio') ▲@elseif(request('sort') == '-fio') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'phone') ? '-phone' : 'phone' }}" class="text-dark">
                    <span class="sub-text">Номер телефона</span>
                    @if(request('sort') == 'phone') ▲@elseif(request('sort') == '-phone') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'email') ? '-email' : 'email' }}" class="text-dark">
                    <span class="sub-text">Email</span>
                    @if(request('sort') == 'email') ▲@elseif(request('sort') == '-email') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'order_number') ? '-order_number' : 'order_number' }}" class="text-dark">
                    <span class="sub-text">Номер заказа</span>
                    @if(request('sort') == 'order_number') ▲@elseif(request('sort') == '-order_number') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'status') ? '-status' : 'status' }}" class="text-dark">
                    <span class="sub-text">Статус заказа</span>
                    @if(request('sort') == 'status') ▲@elseif(request('sort') == '-status') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'address') ? '-address' : 'address' }}" class="text-dark">
                    <span class="sub-text">Адресс</span>
                    @if(request('sort') == 'address') ▲@elseif(request('sort') == '-address') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'city') ? '-city' : 'city' }}" class="text-dark">
                    <span class="sub-text">Город</span>
                    @if(request('sort') == 'city') ▲@elseif(request('sort') == '-city') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'filial_id') ? '-filial_id' : 'filial_id' }}" class="text-dark">
                    <span class="sub-text">Филиал</span>
                    @if(request('sort') == 'filial_id') ▲@elseif(request('sort') == '-filial_id') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'delivery_charge') ? '-delivery_charge' : 'delivery_charge' }}" class="text-dark">
                    <span class="sub-text">Доставка</span>
                    @if(request('sort') == 'delivery_charge') ▲@elseif(request('sort') == '-delivery_charge') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'total') ? '-total' : 'total' }}" class="text-dark">
                    <span class="sub-text">Итого</span>
                    @if(request('sort') == 'total') ▲@elseif(request('sort') == '-total') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col nk-tb-col-tools text-end"></div>
        </div><!-- .nk-tb-item -->
        @foreach($orders as $order)
            <div class="nk-tb-item" id="order-id-{{$order->id}}" data-manager-id="{{ $order->manager_id }}">
                <div class="nk-tb-col" style="width: 40px;">
                    <input type="checkbox" class="order-checkbox" value="{{$order->id}}">
                </div>
                <div class="nk-tb-col order-details">
                    <span>#{{$order->id}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>
                        @if($order->user?->type?->key_name === 'fiz')
                            {{$order->fio}}
                        @else
                            {{$order->user?->profile?->organization_name}}
                        @endif
                    </span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$order->phone}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$order->email}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->order_number}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{ __('theme.' . $order->status) }}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->address}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->cityModel?->name}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->filial?->address}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->delivery_charge}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->total}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools order-details">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('order.edit', $order)}}" data-id="{{$order->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="model-delete" id="model-delete-{{$order->id}}" data-id="{{$order->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
                                        <li><a data-id="{{$order->id}}" href="{{route('order.view.pdf', $order)}}"><em class="icon ni ni-file-pdf"></em><span>Просмотреть PDF</span></a></li>
                                        <li><a data-id="{{$order->id}}" href="{{route('order.download.pdf', $order)}}"><em class="icon ni ni-printer"></em><span>Скачать PDF</span></a></li>
                                        <li><a data-id="{{$order->id}}" href="{{route('order.view.invoice', $order)}}"><em class="icon ni ni-eye"></em><span>Просмотреть инвойс</span></a></li>
                                        <li><a data-id="{{$order->id}}" href="{{route('order.download.invoice', $order)}}"><em class="icon ni ni-download"></em><span>Скачать инвойс</span></a></li>
                                        <li><a data-id="{{$order->id}}" href="{{route('order.download.excel', $order)}}"><em class="icon ni ni-download"></em><span>Скачать Excel</a></li>
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

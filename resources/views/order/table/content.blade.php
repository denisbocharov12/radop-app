<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Фамилия Имя</span></div>
            <div class="nk-tb-col"><span class="sub-text">Номер телефона</span></div>
            <div class="nk-tb-col"><span class="sub-text">Email</span></div>
            <div class="nk-tb-col"><span class="sub-text">Номер заказа</span></div>
            <div class="nk-tb-col"><span class="sub-text">Статус заказа</span></div>
            <div class="nk-tb-col"><span class="sub-text">Адресс</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end"></div>
        </div><!-- .nk-tb-item -->
        @foreach($orders as $order)
            <div class="nk-tb-item" id="order-id-{{$order->id}}" data-manager-id="{{ $order->manager_id }}">
                <div class="nk-tb-col order-details">
                    <span>#{{$order->id}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->first_name}} {{$order->last_name}}</span>
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

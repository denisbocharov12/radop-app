@php
    $orderStatusEnum = new \App\Enums\OrderStatus();
@endphp
<style>
    .text-dark {
        display: flex;
        justify-content: center;
    }
    .new-order {
        background-color: #d4f4e1;
    }
    .processing-order {
        background-color: #fdf3cd;
    }
    .nk-tb-col{
        border-left: 1px solid;
        border-right: 1px solid;
    }
    .nk-tb-col{
        border-left: 0;
        border-right: 1px solid #dbdfea;
    }
</style>
<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head fw-bold">
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
                    <span class="sub-text">Клиент</span>
                    @if(request('sort') == 'fio') ▲@elseif(request('sort') == '-fio') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'cod_fiscal') ? '-cod_fiscal' : 'cod_fiscal' }}" class="text-dark">
                    <span class="sub-text">Ф.К.</span>
                    @if(request('sort') == 'cod_fiscal') ▲@elseif(request('sort') == '-cod_fiscal') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'manager_first_name') ? '-manager_first_name' : 'manager_first_name' }}" class="text-dark">
                    <span class="sub-text">Менеджер</span>
                    @if(request('sort') == 'manager_first_name') ▲@elseif(request('sort') == '-manager_first_name') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'created_at') ? '-created_at' : 'created_at' }}" class="text-dark">
                    <span class="sub-text">Дата</span>
                    @if(request('sort') == 'created_at') ▲@elseif(request('sort') == '-created_at') ▼@endif
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
                <a href="?sort={{ (request('sort') == 'city') ? '-city' : 'city' }}" class="text-dark">
                    <span class="sub-text">Город</span>
                    @if(request('sort') == 'city') ▲@elseif(request('sort') == '-city') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'address') ? '-address' : 'address' }}" class="text-dark">
                    <span class="sub-text">Адрес</span>
                    @if(request('sort') == 'address') ▲@elseif(request('sort') == '-address') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'filial_id') ? '-filial_id' : 'filial_id' }}" class="text-dark">
                    <span class="sub-text">Филиал</span>
                    @if(request('sort') == 'filial_id') ▲@elseif(request('sort') == '-filial_id') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col">
                <a href="?sort={{ (request('sort') == 'total') ? '-total' : 'total' }}" class="text-dark">
                    <span class="sub-text">Сумма</span>
                    @if(request('sort') == 'total') ▲@elseif(request('sort') == '-total') ▼@endif
                </a>
            </div>
            <div class="nk-tb-col nk-tb-col-tools text-end"></div>
        </div>
        @foreach($orders as $order)
            @php
                $lastHistory = $order->orderHistory->first();
                $historyData = null;
                if ($lastHistory) {
                    $data = json_decode($lastHistory->data, true);
                    $historyData = [
                        'created_at' => $lastHistory->created_at,
                        'type_localized' => __('theme.history_' . $lastHistory->type),
                        'status_localized' => $orderStatusEnum->getAll()[$lastHistory->order_status] ?? $lastHistory->order_status,
                        'total' => $data['order']['total'] ?? '',
                        'products_count' => isset($data['products']) ? count($data['products']) : 0,
                    ];
                }
            @endphp
            <div class="nk-tb-item @if($order->status === $orderStatusEnum->getPendingStatus()) processing-order @elseif($order->status === $orderStatusEnum->getNewStatus()) new-order @endif"
                 id="order-id-{{$order->id}}" data-manager-id="{{ $order->manager_id }}"
                 data-history='@json($historyData)'>
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
                    <span>{{$order->user?->profile?->cod_fiscal}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$order->manager?->profile?->last_name}} {{$order->manager?->profile?->first_name}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$order->created_at->format('d.m.Y')}}</span><br>
                    <span>{{$order->created_at->format('H:i:s')}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->order_number}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{ __('theme.' . $order->status) }}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->cityModel?->name}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->address}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{$order->filial?->address}}</span>
                </div>
                <div class="nk-tb-col order-details">
                    <span>{{ number_format($order->total, 2, ',', ' ')}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools order-details">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a data-id="{{$order->id}}" href="{{route('order.download.excel', $order)}}"><em class="icon ni ni-download"></em><span>Скачать Excel</a></li>
                                        <li><a data-id="{{$order->id}}" href="{{route('order.view.invoice', $order)}}"><em class="icon ni ni-file-pdf"></em><span>Просмотреть заказ</span></a></li>
                                        <li><a href="#" class="modal-add-manager" id="modal-add-manager-{{$order->id}}" data-id="{{$order->id}}"><em class="icon ni ni-user-add"></em><span>Назначить менеджера</span></a></li>
                                        <li><a href="{{route('order.edit', $order)}}" data-id="{{$order->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
{{--                                        <li><a href="#" class="model-delete" id="model-delete-{{$order->id}}" data-id="{{$order->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>--}}
{{--                                        <li><a data-id="{{$order->id}}" href="{{route('order.download.pdf', $order)}}"><em class="icon ni ni-printer"></em><span>Скачать PDF</span></a></li>--}}
{{--                                        <li><a data-id="{{$order->id}}" href="{{route('order.view.invoice', $order)}}"><em class="icon ni ni-eye"></em><span>Просмотреть инвойс</span></a></li>--}}
{{--                                        <li><a data-id="{{$order->id}}" href="{{route('order.download.invoice', $order)}}"><em class="icon ni ni-download"></em><span>Скачать инвойс</span></a></li>--}}
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

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
                                <h4 class="title nk-block-title">Редактирование заказа #{{$order->id}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('order.update', $order)}}" method="POST" class="form-validate is-alter">
                                    @csrf
                                    <div class="row g-gs">
                                        @if($order->user !== null)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="user_id">Пользователь</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-select js-select2 form-control @error('user_id') error @enderror" data-search="on" name="user_id" id="user_id" data-placeholder="Пользователь">
                                                            <option value="">Пользователь</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                                                                    @if($user?->type?->key_name === 'fiz')
                                                                        {{$user?->profile?->first_name}} {{$user?->profile?->last_name}}
                                                                    @else
                                                                        {{$user?->profile?->organization_name}}
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="manager_id">Менеджер</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" name="manager_id" id="manager_id" data-placeholder="Менеджер">
                                                        <option value="">Менеджер</option>
                                                        @foreach ($managers as $manager)
                                                            <option value="{{ $manager->id }}" {{ $order->manager_id == $manager->id ? 'selected' : '' }}>
                                                                {{ $manager->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="user_type">Тип пользователя</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" name="user_type" id="user_type" data-placeholder="Тип пользователя">
                                                        <option value="">Тип пользователя</option>
                                                        @foreach ($userTypes as $type)
                                                            <option value="{{ $type->key_name }}" {{ $order->user_type == $type->key_name ? 'selected' : '' }}>
                                                                {{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="company_name">Название компании</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('company_name') error @enderror" id="company_name" name="company_name" value="{{$order->profile?->company_name}}" placeholder="Название компании">
                                                    @error('company_name')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="bank">Банк</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('bank') error @enderror" id="bank" name="bank" value="{{$order->profile?->bank}}" placeholder="Банк">
                                                    @error('bank')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="idno">Банковский код IDNO</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('idno') error @enderror" id="idno" name="idno" value="{{$order->profile?->idno}}" placeholder="Банковский код IDNO">
                                                    @error('idno')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="tva">TVA</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('tva') error @enderror" id="tva" name="tva" value="{{$order->profile?->tva}}" placeholder="TVA">
                                                    @error('tva')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="iur_address">Юридический адрес</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('iur_address') error @enderror" id="iur_address" name="iur_address" value="{{$order->profile?->iur_address}}" placeholder="Юридический адрес">
                                                    @error('iur_address')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="shipping_address">Адрес доставки</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('shipping_address') error @enderror" id="shipping_address" name="shipping_address" value="{{$order->profile?->shipping_address}}" placeholder="Адрес доставки">
                                                    @error('shipping_address')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="reserve_phone">Резервный телефон</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('reserve_phone') error @enderror" id="reserve_phone" name="reserve_phone" value="{{$order->profile?->reserve_phone}}" placeholder="Номер телефона">
                                                    @error('reserve_phone')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('email') error @enderror" id="email" name="email" value="{{$order->email}}" placeholder="Email">
                                                    @error('email')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">Номер телефона</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('phone') error @enderror" id="phone" name="phone" value="{{$order->phone}}" placeholder="phone">
                                                    @error('phone')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="fio">Имя / Фамилия</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('fio') error @enderror" id="fio" name="fio" value="{{$order->fio}}" placeholder="Имя фамилия">
                                                    @error('fio')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="address">Адрес</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('address') error @enderror" id="address" name="address" value="{{$order->address}}" placeholder="Адрес">
                                                    @error('address')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="payment_method">Метод оплаты</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" name="payment_method" id="payment_method" data-placeholder="Метод оплаты">
                                                        <option value="">Метод оплаты</option>
                                                        @foreach ($paymentMethods as $paymentMethodKey => $paymentMethodName)
                                                            <option value="{{ $paymentMethodKey }}" {{ $order->payment_method == $paymentMethodKey ? 'selected' : '' }}>
                                                                {{ $paymentMethodName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="order_number">Метод доставки</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('delivery_method') error @enderror" id="delivery_method" name="delivery_method" value="{{$order->delivery_method}}" placeholder="Метод доставки">
                                                    @error('delivery_method')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="payment_status">Статус оплаты</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" name="payment_status" id="payment_status" data-placeholder="Статус оплаты">
                                                        <option value="">Статус оплаты</option>
                                                        @foreach ($paymentStatus as $paymentStatusKey => $paymentStatusName)
                                                            <option value="{{ $paymentStatusKey }}" {{ $order->payment_status == $paymentStatusKey ? 'selected' : '' }}>
                                                                {{ $paymentStatusName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="status">Статус заказа</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" name="status" id="status" data-placeholder="Статус заказа">
                                                        <option value="">Статус заказа</option>
                                                        @foreach ($orderStatus as $orderStatusKey => $orderStatusName)
                                                            <option value="{{ $orderStatusKey }}" {{ $order->status == $orderStatusKey ? 'selected' : '' }}>
                                                                {{ $orderStatusName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="subtotal">Промежуточный итог</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('subtotal') error @enderror" id="subtotal" name="subtotal" value="{{$order->subtotal}}" placeholder="Промежуточный итог">
                                                    @error('subtotal')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="city">Город</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" name="city" id="city" data-placeholder="Город">
                                                        <option value="">Город</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}" {{ $city->id == $order->city ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @if($order->filial_id !== null)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="filial_id">Филиал</label>
                                                    <div class="form-control-wrap">
                                                        <select class="form-select js-select2" data-search="on" name="filial_id" id="filial_id" data-placeholder="Филиал">
                                                            <option value="">Филиал</option>
                                                            @foreach ($order->user->filials as $filial)
                                                                <option value="{{ $filial->id }}" {{ $filial->id == $order->filial_id ? 'selected' : '' }}>
                                                                    {{ $filial->address }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="discount">Скидка</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('discount') error @enderror" id="discount" name="discount" value="{{$order->discount}}" placeholder="Скидка">
                                                    @error('discount')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="total">Итого</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('total') error @enderror" id="total" name="total" value="{{$order->total}}" placeholder="Итого">
                                                    @error('total')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="delivery_charge">Доставка</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('delivery_charge') error @enderror" id="delivery_charge" name="delivery_charge" value="{{$order->delivery_charge}}" placeholder="Доставка">
                                                    @error('delivery_charge')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @if($order->recommended_time !== null)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="recommended_time">Рекомендуемое время</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('recommended_time') error @enderror" id="recommended_time" name="recommended_time" value="{{$order->recommended_time}}" placeholder="Время">
                                                    @error('recommended_time')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="note">Примечание</label>
                                                <div class="form-control-wrap">
                                                    <textarea type="text" name="note" class="form-control no-resize @error('note') error @enderror" id="note">{{$order->note}}</textarea>
                                                    @error('note')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить заказ</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Товары в заказе</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Название товара</th>
                                        <th>Количество</th>
                                        <th>Цена</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order->products as $item)
                                        <tr>
                                            <td>{{ $product->where('id',$item->product_id)->first()->title }}</td>
                                            <td>{{ $item->quantity }} шт.</td>
                                            <td>{{ $item->price }} {{__('theme.MDL')}}</td>
                                        </tr>
                                    @endforeach
                                    <td>Итого</td>
                                    <td>{{ $order->products->sum('quantity') }} шт.</td>
                                    <td>{{ $order->total }} {{__('theme.MDL')}}</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
@endsection

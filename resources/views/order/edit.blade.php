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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="user_id">Пользователь</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" data-search="on" name="user_id" id="user_id" data-placeholder="Пользователь">
                                                        <option value="">Пользователь</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
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
                                                <label class="form-label" for="order_number">Номер заказа</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('order_number') error @enderror" id="order_number" name="order_number" value="{{$order->order_number}}" placeholder="Номер заказа">
                                                    @error('order_number')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="first_name">Имя</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('first_name') error @enderror" id="first_name" name="first_name" value="{{$order->first_name}}" placeholder="Имя">
                                                    @error('first_name')
                                                    <span id="fv-full-name-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="last_name">Фамилия</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('last_name') error @enderror" id="last_name" name="last_name" value="{{$order->last_name}}" placeholder="Фамилия">
                                                    @error('last_name')
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
                                                <label class="form-label" for="address">Номер телефона</label>
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
                                                <label class="form-label" for="subtotal">Номер телефона</label>
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
                                        <th>Итого</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order->products as $item)
                                        <tr>
                                            <td>{{ $item->product->title}}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }} MDL</td>
                                            <td>{{ $order->total }} MDL</td>
                                        </tr>
                                    @endforeach
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

@extends('v2.layouts.app')

@section('title', 'Заказ #' . $order->id)
@section('breadcrumb')
    <a href="{{ route('order.index') }}" class="hover:text-brand-600 transition-colors">Заказы</a>
    <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
    <span class="text-gray-700">#{{ $order->id }}</span>
@endsection

@section('content')
    @php
        $statusBadge = ['new'=>'info','pending'=>'warning','processing'=>'primary','sent'=>'primary','delivered'=>'success','canceled'=>'danger'];
        $bt = $statusBadge[$order->status] ?? 'gray';
        $statusLabel = $orderStatus[$order->status] ?? $order->status;
        $money = function ($v) { try { return number_format((float) $v, 2, ',', ' '); } catch (\Throwable $e) { return (string) $v; } };
        $mdl = __('theme.MDL');
    @endphp

    <x-page-header title="Заказ #{{ $order->id }}"
                   description="№ {{ $order->order_number }} · {{ optional($order->created_at)->format('d.m.Y H:i') }}">
        <x-slot:actions>
            <a href="{{ route('order.index') }}" class="btn-secondary btn-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> К списку</a>
            @if(Route::has('order.view.invoice'))
                <a href="{{ route('order.view.invoice', $order) }}" class="btn-secondary btn-sm"><i data-lucide="file-text" class="w-4 h-4"></i> Заказ</a>
            @endif
            @if(Route::has('order.download.excel'))
                <a href="{{ route('order.download.excel', $order) }}" class="btn-secondary btn-sm"><i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Excel</a>
            @endif
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    {{-- Supplement (дозаказ) links --}}
    @if($order->parentOrder !== null)
        <div class="mb-4 flex items-start gap-3 rounded-lg border border-amber-300 bg-amber-50 px-4 py-3">
            <i data-lucide="info" class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5"></i>
            <div class="text-sm text-amber-800">
                Этот заказ является <strong>дополнением</strong> к заказу
                <a href="{{ route('order.edit', $order->parentOrder) }}" class="font-semibold underline hover:text-amber-900">
                    №{{ $order->parentOrder->order_number }} (#{{ $order->parentOrder->id }})
                </a>.
            </div>
        </div>
    @endif

    @if($order->supplements->isNotEmpty())
        <div class="mb-4 rounded-lg border border-brand-200 bg-brand-50 px-4 py-3">
            <div class="flex items-center gap-2 mb-2 text-sm font-semibold text-brand-800">
                <i data-lucide="info" class="w-5 h-5 text-brand-600"></i>
                К этому заказу присоединены дополнения ({{ $order->supplements->count() }})
            </div>
            <ul class="space-y-1 text-sm">
                @foreach($order->supplements as $supplement)
                    <li class="flex items-center justify-between gap-3">
                        <a href="{{ route('order.edit', $supplement) }}" class="font-medium text-brand-700 hover:underline">
                            №{{ $supplement->order_number }} (#{{ $supplement->id }})
                        </a>
                        <span class="text-gray-500 whitespace-nowrap">
                            {{ optional($supplement->created_at)->format('d.m.Y H:i') }} · {{ $money($supplement->total) }} {{ $mdl }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main column --}}
        <div class="lg:col-span-2 space-y-6">
            <x-card title="Данные заказа">
                <form action="{{ route('order.update', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if($order->user !== null)
                            <div>
                                <label class="form-label" for="user_id">Клиент</label>
                                <select name="user_id" id="user_id" class="form-select js-select2">
                                    <option value="">Клиент</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" {{ $order->user_id == $u->id ? 'selected' : '' }}>
                                            @if($u?->type?->key_name === 'fiz'){{ $u?->profile?->first_name }} {{ $u?->profile?->last_name }}@else{{ $u?->profile?->organization_name }}@endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div>
                            <label class="form-label" for="manager_id">Менеджер</label>
                            <select name="manager_id" id="manager_id" class="form-select js-select2">
                                <option value="">Менеджер</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ $order->manager_id == $manager->id ? 'selected' : '' }}>{{ $manager?->profile?->last_name }} {{ $manager?->profile?->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="user_type">Тип клиента</label>
                            <select name="user_type" id="user_type" class="form-select js-select2">
                                <option value="">Тип клиента</option>
                                @foreach($userTypes as $type)
                                    <option value="{{ $type->key_name }}" {{ $order->user_type == $type->key_name ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="fio">@if($order->user_type === 'iur')Название компании @else Имя / Фамилия @endif</label>
                            <input type="text" name="fio" id="fio" value="{{ $order->fio }}" class="form-input @error('fio') border-red-400 @enderror">
                        </div>
                        <div>
                            <label class="form-label" for="email">Email</label>
                            <input type="text" required name="email" id="email" value="{{ $order->email }}" class="form-input @error('email') border-red-400 @enderror">
                            @error('email')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="phone">Телефон</label>
                            <input type="text" required name="phone" id="phone" value="{{ $order->phone }}" class="form-input @error('phone') border-red-400 @enderror">
                            @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="city">Город</label>
                            <select name="city" id="city" class="form-select js-select2">
                                <option value="">Город</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $city->id == $order->city ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="address">Адрес</label>
                            <input type="text" required name="address" id="address" value="{{ $order->address }}" class="form-input @error('address') border-red-400 @enderror">
                        </div>
                        @if($order->filial_id !== null && $order->user)
                            <div>
                                <label class="form-label" for="filial_id">Филиал</label>
                                <select name="filial_id" id="filial_id" class="form-select js-select2">
                                    <option value="">Филиал</option>
                                    @foreach($order->user->filials as $filial)
                                        <option value="{{ $filial->id }}" {{ $filial->id == $order->filial_id ? 'selected' : '' }}>{{ $filial->address }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div>
                            <label class="form-label" for="delivery_method">Метод доставки</label>
                            <input type="text" required name="delivery_method" id="delivery_method" value="{{ $order->delivery_method }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label" for="payment_method">Метод оплаты</label>
                            <select name="payment_method" id="payment_method" class="form-select js-select2">
                                <option value="">Метод оплаты</option>
                                @foreach($paymentMethods as $k => $name)
                                    <option value="{{ $k }}" {{ $order->payment_method == $k ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="payment_status">Статус оплаты</label>
                            <select name="payment_status" id="payment_status" class="form-select js-select2">
                                <option value="">Статус оплаты</option>
                                @foreach($paymentStatus as $k => $name)
                                    <option value="{{ $k }}" {{ $order->payment_status == $k ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="status">Статус заказа</label>
                            <select name="status" id="status" class="form-select js-select2">
                                <option value="">Статус заказа</option>
                                @foreach($orderStatus as $k => $name)
                                    <option value="{{ $k }}" {{ $order->status == $k ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($order->recommended_time !== null)
                            <div>
                                <label class="form-label" for="recommended_time">Рекомендуемое время</label>
                                <input type="text" name="recommended_time" id="recommended_time" value="{{ $order->recommended_time }}" class="form-input">
                            </div>
                        @endif
                        <div>
                            <label class="form-label" for="subtotal">Промежуточный итог</label>
                            <input type="text" name="subtotal" id="subtotal" value="{{ $order->subtotal }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label" for="discount">Скидка</label>
                            <input type="text" name="discount" id="discount" value="{{ $order->discount }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label" for="delivery_charge">Доставка</label>
                            <input type="text" name="delivery_charge" id="delivery_charge" value="{{ $order->delivery_charge }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label" for="total">Итого</label>
                            <input type="text" name="total" id="total" value="{{ $order->total }}" class="form-input font-semibold">
                        </div>
                    </div>
                    <div>
                        <label class="form-label" for="note">Примечание</label>
                        <textarea name="note" id="note" rows="3" class="form-input resize-none">{{ $order->note }}</textarea>
                    </div>
                    <div class="flex justify-end pt-2 border-t border-gray-100">
                        <button type="submit" class="btn-primary"><i data-lucide="check" class="w-4 h-4"></i> Обновить заказ</button>
                    </div>
                </form>
            </x-card>

            {{-- Items --}}
            <x-card title="Товары в заказе" :padding="false">
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th class="text-center">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->products as $item)
                                <tr>
                                    <td class="font-medium text-gray-900">{{ optional($product->where('id', $item->product_id)->first())->title ?? ('#' . $item->product_id) }}</td>
                                    <td class="text-center">{{ $item->quantity }} шт.</td>
                                    <td class="text-right">{{ $money($item->price) }} {{ $mdl }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-semibold text-gray-900">
                                <td>Итого</td>
                                <td class="text-center">{{ $order->products->sum('quantity') }} шт.</td>
                                <td class="text-right">{{ $money($order->total) }} {{ $mdl }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <x-card title="Сводка">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-500">Статус</span>
                    <x-badge :type="$bt">{{ $statusLabel }}</x-badge>
                </div>
                <dl class="space-y-2 text-sm border-t border-gray-100 pt-4">
                    <div class="flex justify-between"><dt class="text-gray-500">Промежуточный итог</dt><dd class="text-gray-900">{{ $money($order->subtotal) }} {{ $mdl }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Скидка</dt><dd class="text-gray-900">{{ $money($order->discount) }} {{ $mdl }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Доставка</dt><dd class="text-gray-900">{{ $money($order->delivery_charge) }} {{ $mdl }}</dd></div>
                    <div class="flex justify-between pt-2 border-t border-gray-100 text-base font-semibold"><dt class="text-gray-900">Итого</dt><dd class="text-brand-700">{{ $money($order->total) }} {{ $mdl }}</dd></div>
                </dl>
            </x-card>

            <x-card title="История изменений" :padding="false">
                <div class="px-5 py-4">
                    @forelse($history as $item)
                        @php
                            $typeBadge = ['edited'=>'primary','updated_status'=>'warning','downloaded_excel'=>'success'][$item->type] ?? 'gray';
                            $typeIcon  = ['edited'=>'pencil','updated_status'=>'repeat','downloaded_excel'=>'file-spreadsheet'][$item->type] ?? 'info';
                            $hData = json_decode($item->data, true);
                        @endphp
                        <div class="flex gap-3 {{ !$loop->last ? 'pb-4 mb-4 border-b border-gray-100' : '' }}">
                            <div class="w-8 h-8 rounded-full bg-brand-50 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="{{ $typeIcon }}" class="w-4 h-4 text-brand-600"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <x-badge :type="$typeBadge">{{ __('theme.history_' . $item->type) }}</x-badge>
                                    @if(isset($orderStatus[$item->order_status]))
                                        <x-badge type="info">{{ $orderStatus[$item->order_status] }}</x-badge>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 mt-1">{{ $item->created_at }}</p>
                                @if(isset($hData['order']) || isset($hData['products']))
                                    <p class="text-xs text-gray-500 mt-1">
                                        @if(isset($hData['order']['total']))Сумма: {{ $hData['order']['total'] }}@endif
                                        @if(isset($hData['products'])) · Товаров: {{ count($hData['products']) }}@endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-2">Истории изменений нет</p>
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>
@endsection

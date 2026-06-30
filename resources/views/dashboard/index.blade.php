@extends('v2.layouts.app')

@section('title', 'Панель управления')

@section('content')
    @php
        // Safe data fetcher — any failing query degrades to null instead of 500-ing the page.
        $safe = function (callable $fn) { try { return $fn(); } catch (\Throwable $e) { return null; } };
        $fmt  = fn ($n) => $n === null ? '—' : number_format((int) $n, 0, '.', ' ');

        $enum             = $safe(fn () => new \App\Enums\OrderStatus());
        $newStatus        = $enum ? $safe(fn () => $enum->getNewStatus()) : null;
        $pendingStatus    = $enum ? $safe(fn () => $enum->getPendingStatus()) : null;
        $processingStatus = $enum ? $safe(fn () => $enum->getProcessingStatus()) : null;
        $sentStatus       = $enum ? $safe(fn () => $enum->getSentStatus()) : null;
        $deliveredStatus  = $enum ? $safe(fn () => $enum->getDeliveredStatus()) : null;
        $canceledStatus   = $enum ? $safe(fn () => $enum->getCanceledStatus()) : null;

        $ordersTotal   = $safe(fn () => \App\Models\Order::count());
        $ordersNew     = $newStatus !== null ? $safe(fn () => \App\Models\Order::where('status', $newStatus)->count()) : null;
        $ordersToday   = $safe(fn () => \App\Models\Order::whereDate('created_at', now()->toDateString())->count());
        $productsTotal = $safe(fn () => \App\Models\Product::count());
        $clientsTotal  = $safe(fn () => \App\Models\User::count());

        $recentOrders = $safe(fn () => \App\Models\Order::latest()->take(8)->get()) ?? collect();

        // order status => [badge type, label]
        $statusMeta = array_filter([
            $newStatus        => ['info',    'Новый'],
            $pendingStatus    => ['warning', 'В ожидании'],
            $processingStatus => ['primary', 'В обработке'],
            $sentStatus       => ['primary', 'Отправлен'],
            $deliveredStatus  => ['success', 'Доставлен'],
            $canceledStatus   => ['danger',  'Отменён'],
        ], fn ($k) => $k !== null && $k !== '', ARRAY_FILTER_USE_KEY);

        $quickLinks = [
            ['order.index',    'shopping-cart', 'Заказы'],
            ['client.index',   'users',         'Клиенты'],
            ['product.index',  'package',       'Товары'],
            ['coupon.index',   'badge-percent', 'Купоны'],
            ['banner.index',   'image',         'Баннеры'],
            ['reports.orders.index', 'file-bar-chart-2', 'Отчёты'],
        ];
    @endphp

    <x-page-header title="Панель управления"
                   description="Добро пожаловать, {{ Auth::user()->name }} — краткая сводка по магазину Radop.">
        <x-slot:actions>
            @if(Route::has('reports.orders.index'))
                <a href="{{ route('reports.orders.index') }}" class="btn-secondary btn-sm">
                    <i data-lucide="file-bar-chart-2" class="w-4 h-4"></i> Отчёты
                </a>
            @endif
            @if(Route::has('order.index'))
                <a href="{{ route('order.index') }}" class="btn-primary btn-sm">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i> Все заказы
                </a>
            @endif
        </x-slot:actions>
    </x-page-header>

    {{-- KPI cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stats-card title="Всего заказов"  :value="$fmt($ordersTotal)"   icon="shopping-cart" color="brand"
                      :change="$ordersToday !== null ? '+'.$ordersToday.' сегодня' : null" changeType="up" />
        <x-stats-card title="Новые заказы"   :value="$fmt($ordersNew)"     icon="bell"          color="amber" />
        <x-stats-card title="Товары"         :value="$fmt($productsTotal)" icon="package"       color="violet" />
        <x-stats-card title="Клиенты"        :value="$fmt($clientsTotal)"  icon="users"         color="emerald" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent orders --}}
        <div class="lg:col-span-2">
            <x-card :padding="false">
                <x-slot:header>
                    <h3 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-brand-500"></i> Последние заказы
                    </h3>
                    @if(Route::has('order.index'))
                        <a href="{{ route('order.index') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700">Все →</a>
                    @endif
                </x-slot:header>

                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>№ заказа</th>
                                <th>Дата</th>
                                <th>Статус</th>
                                <th class="text-right">Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                @php
                                    $st = $order->status ?? null;
                                    [$bt, $bl] = $statusMeta[$st] ?? ['gray', $st ?: '—'];
                                    $total = $safe(fn () => (string) $order->total);
                                @endphp
                                <tr>
                                    <td class="font-semibold text-gray-900">#{{ $order->order_number ?? $order->id }}</td>
                                    <td class="text-gray-500">{{ optional($order->created_at)->format('d.m.Y H:i') ?? '—' }}</td>
                                    <td><x-badge :type="$bt">{{ $bl }}</x-badge></td>
                                    <td class="text-right font-medium text-gray-900">{{ $total ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <x-empty-state icon="inbox" title="Заказов пока нет"
                                                       text="Здесь появятся последние оформленные заказы." />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        {{-- Quick access --}}
        <div>
            <x-card title="Быстрый доступ">
                <div class="grid grid-cols-2 gap-3">
                    @foreach($quickLinks as [$route, $icon, $label])
                        @if(Route::has($route))
                            <a href="{{ route($route) }}"
                               class="flex flex-col items-center justify-center gap-2 py-4 rounded-lg border border-gray-200 text-gray-600 hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700 transition-all">
                                <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
                                <span class="text-xs font-medium">{{ $label }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>
@endsection

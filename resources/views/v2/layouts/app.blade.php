<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('v2.partials.head')
<body class="font-sans bg-gray-50 text-gray-700 antialiased min-h-screen" x-data>

    @php
        // ── Central navigation definition (single source of truth: sidebar + command palette) ──
        // Flat group:  ['label'=>..,'roles'=>[],'items'=>[[label,route,icon,pattern,badgeId?]]]
        // Tree group:  ['type'=>'tree','title'=>..,'icon'=>..,'match'=>..,'roles'=>[],'items'=>[...]]
        $nav = [
            ['label' => null, 'items' => [
                ['Панель управления', 'dashboard.index', 'layout-dashboard', 'dashboard.*'],
            ]],
            ['label' => null, 'roles' => ['admin'], 'items' => [
                ['Импорт 1С', 'import-export-data.index', 'database', 'import-export-data.*'],
            ]],
            ['label' => 'Продажи', 'roles' => ['admin', 'manager'], 'items' => [
                ['Заказы',  'order.index',  'shopping-cart', 'order.*', 'new_orders'],
                ['Клиенты', 'client.index', 'users',         'client.*'],
                ['Купоны',  'coupon.index', 'badge-percent', 'coupon.*'],
                ['Отзывы',  'review.index', 'star', 'review.*'],
            ]],
            ['label' => 'Система', 'roles' => ['admin'], 'items' => [
                ['Без менеджера', 'manager.index',      'user-cog', 'manager.index'],
                ['Менеджеры',     'manager.list.index', 'users',    'manager.list.*'],
            ]],
            ['label' => 'Каталог', 'roles' => ['admin', 'manager'], 'items' => [
                ['Товары',    'product.index',   'package',            'product.index'],
                ['Категории', 'category.index',  'folder-tree',        'category.index'],
                ['Бренды',    'brand.index',     'award',              'brand.index'],
                ['Атрибуты',  'attribute.index', 'sliders-horizontal', 'attribute.index'],
            ]],
            ['label' => 'Логистика', 'roles' => ['admin'], 'items' => [
                ['Города',   'city.index',           'map-pin', 'city.index'],
                ['Филиалы',  'filial.index',         'store',   'filial.*'],
                ['Доставка', 'deliveryMethod.index', 'truck',   'deliveryMethod.*'],
            ]],
            ['label' => 'Контент', 'roles' => ['admin'], 'items' => [
                ['Баннеры',         'banner.index',              'image',     'banner.index'],
                ['Меню',            'menu.index',                'list-tree', 'menu.*'],
                ['Шапка-меню',      'header-menu.index',         'panel-top', 'header-menu.*'],
                ['SEO',             'seo_meta.index',            'search',    'seo_meta.*'],
                ['Языки',           'languages.index',           'languages', 'languages.*'],
                ['Экспорт страниц', 'active-pages-export.index', 'file-down', 'active-pages-export.*'],
            ]],
            ['type' => 'tree', 'title' => 'Сортировка', 'icon' => 'arrow-down-up', 'match' => '*.sort.*', 'roles' => ['admin'], 'items' => [
                ['Категории',              'category.sort.index',           'folder-tree',        'category.sort.index'],
                ['Категории (каталог)',    'category.sort.index.catalog',   'folder-tree',        'category.sort.index.catalog'],
                ['Товары по категориям',   'category.select.category',      'folder-tree',        'category.select.*'],
                ['Бренды',                 'brand.sort.index',              'award',              'brand.sort.index'],
                ['Бренды (каталог)',       'brand.sort.catalog',            'award',              'brand.sort.catalog'],
                ['Атрибуты',               'attribute.sort.index',          'sliders-horizontal', 'attribute.sort.index'],
                ['Атрибуты по категориям', 'attribute.sort.category.index', 'sliders-horizontal', 'attribute.sort.category.*'],
                ['Товары: Featured',       'product.sort.index.featured',   'package',            'product.sort.index.featured'],
                ['Товары: Popular',        'product.sort.index.popular',    'package',            'product.sort.index.popular'],
                ['Товары: Sale',           'product.sort.index.sale',       'package',            'product.sort.index.sale'],
                ['Товары: Hot',            'product.sort.index.hot',        'package',            'product.sort.index.hot'],
                ['Товары: New',            'product.sort.index.new',        'package',            'product.sort.index.new'],
                ['Города',                 'city.sort.index',               'map-pin',            'city.sort.*'],
                ['Баннеры',                'banner.sort.index',             'image',              'banner.sort.*'],
                ['Период скидок',          'discount-period.sort.index',    'calendar-clock',     'discount-period.sort.*'],
            ]],
            ['label' => 'Экспорт', 'roles' => ['admin'], 'items' => [
                ['Экспорты менеджеров', 'manager-export.index', 'file-spreadsheet', 'manager-export.*'],
            ]],
            ['type' => 'tree', 'title' => 'Отчёты', 'icon' => 'bar-chart-3', 'match' => 'reports.*', 'roles' => ['admin'], 'items' => [
                ['По заказам',          'reports.orders.index',              'file-bar-chart-2', 'reports.orders.index'],
                ['По клиентам',         'reports.users.index',               'user-search',      'reports.users.*'],
                ['По городам',          'reports.orders-city.index',         'map',              'reports.orders-city.*'],
                ['По статусам',         'reports.orders-status.index',       'list-checks',      'reports.orders-status.*'],
                ['По типам клиентов',   'reports.orders-user-type.index',    'contact',          'reports.orders-user-type.*'],
                ['По товарам',          'reports.products.index',            'boxes',            'reports.products.*'],
                ['Просмотры товаров',   'reports.view-count.product.index',  'eye',              'reports.view-count.product.*'],
                ['Просмотры брендов',   'reports.view-count.brand.index',    'eye',              'reports.view-count.brand.*'],
                ['Просмотры категорий', 'reports.view-count.category.index', 'eye',              'reports.view-count.category.*'],
            ]],
            ['label' => null, 'roles' => ['admin', 'manager'], 'items' => [
                ['Период скидок', 'discount-period.index', 'calendar-clock', 'discount-period.index'],
            ]],
        ];

        // Role + route filtering, and a flat list for the command palette.
        $can = fn ($roles) => empty($roles) || (auth()->check() && auth()->user()->hasAnyRole($roles));
        $navFlat = [];
        foreach ($nav as $g) {
            if (!$can($g['roles'] ?? null)) continue;
            $groupLabel = $g['title'] ?? $g['label'] ?? 'Обзор';
            foreach ($g['items'] as $it) {
                if (\Illuminate\Support\Facades\Route::has($it[1])) {
                    $navFlat[] = ['label' => $it[0], 'url' => route($it[1]), 'icon' => $it[2], 'group' => $groupLabel];
                }
            }
        }
    @endphp

    @include('v2.partials.sidebar', ['nav' => $nav, 'can' => $can])

    {{-- Mobile backdrop --}}
    <div x-show="$store.sidebar.mobileOpen" x-transition.opacity
         @click="$store.sidebar.closeMobile()"
         class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden" style="display:none;"></div>

    <div class="flex flex-col min-h-screen transition-all duration-300"
         :class="$store.sidebar.open ? 'lg:pl-64' : 'lg:pl-[72px]'">

        @include('v2.partials.header', ['navFlat' => $navFlat])

        <main class="flex-1 px-4 sm:px-6 py-6">
            @if(session('success') || session('status'))
                <div class="mb-4 flex items-center gap-2 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700" x-data="{ show: true }" x-show="show">
                    <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <span>{{ session('success') ?? session('status') }}</span>
                    <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 flex items-center gap-2 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700" x-data="{ show: true }" x-show="show">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            @yield('content')
        </main>

        @include('v2.partials.footer')
    </div>

    @yield('modals')

    {{-- Toasts --}}
    <div class="fixed bottom-4 right-4 z-[100] space-y-2 w-80 max-w-[calc(100vw-2rem)]">
        <template x-for="t in $store.toast.items" :key="t.id">
            <div x-transition class="flex items-center gap-3 px-4 py-3 bg-white rounded-lg shadow-lg border"
                 :class="{ 'border-emerald-200': t.type==='success', 'border-red-200': t.type==='error', 'border-gray-200': t.type!=='success'&&t.type!=='error' }">
                <i :data-lucide="t.type==='error' ? 'alert-circle' : 'check-circle'" class="w-4 h-4 flex-shrink-0"
                   :class="t.type==='error' ? 'text-red-500' : 'text-emerald-500'"
                   x-init="$nextTick(() => window.renderIcons && window.renderIcons())"></i>
                <span class="text-sm text-gray-700 flex-1" x-text="t.message"></span>
                <button @click="$store.toast.remove(t.id)" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        </template>
    </div>

    {{-- Global delete confirmation --}}
    <div x-data="confirmDelete" @open-delete.window="open($event.detail.url, $event.detail.name)"
         x-show="show" style="display:none;" class="fixed inset-0 z-[90] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/50" @click="close()" x-show="show" x-transition.opacity></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md p-6" x-show="show"
             x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0"><i data-lucide="trash-2" class="w-5 h-5 text-red-600"></i></div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Удалить запись?</h3>
                    <p class="text-sm text-gray-500 mt-1">Вы действительно хотите удалить <span class="font-medium text-gray-700" x-text="name"></span>? Это действие нельзя отменить.</p>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" @click="close()" class="btn-secondary">Отмена</button>
                <button type="button" @click="confirm()" :disabled="loading" class="btn-danger">
                    <span x-show="!loading">Удалить</span><span x-show="loading" style="display:none;">Удаление…</span>
                </button>
            </div>
        </div>
    </div>

    @include('v2.partials.scripts')
</body>
</html>

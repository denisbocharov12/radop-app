<aside class="fixed inset-y-0 left-0 z-50 flex flex-col bg-sidebar-bg transition-all duration-300 -translate-x-full lg:translate-x-0"
       :class="[
           $store.sidebar.open ? 'w-64' : 'w-[72px]',
           $store.sidebar.mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
       ]">

    {{-- Brand --}}
    <div class="flex items-center h-16 px-4 border-b border-sidebar-border flex-shrink-0">
        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 overflow-hidden">
            <img src="{{ asset('/v1/frontend/assets/images/logo.svg') }}" alt="RĂDOP-OPT"
                 class="h-8 w-auto flex-shrink-0 transition-all" style="filter: brightness(0) invert(1);"
                 :class="$store.sidebar.open ? '' : 'mx-auto'">
            <span class="flex flex-col leading-tight overflow-hidden" x-show="$store.sidebar.open">
                <span class="text-[13px] font-semibold text-white tracking-wide whitespace-nowrap">RĂDOP-OPT</span>
            </span>
        </a>
        <button type="button" @click="$store.sidebar.closeMobile()" class="ml-auto lg:hidden text-sidebar-muted hover:text-white">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 space-y-0.5"
         :class="$store.sidebar.open ? 'px-3 scrollbar-thin' : 'px-2 scrollbar-hide'">
        @foreach($nav as $group)
            @continue(!$can($group['roles'] ?? null))
            @php $visible = collect($group['items'])->filter(fn ($i) => \Illuminate\Support\Facades\Route::has($i[1])); @endphp
            @continue($visible->isEmpty())

            @if(($group['type'] ?? null) === 'tree')
                {{-- Collapsible group --}}
                <div x-data="{ open: {{ request()->routeIs($group['match']) ? 'true' : 'false' }} }" class="pt-2">
                    <button type="button"
                            @click="$store.sidebar.open ? (open = !open) : ($store.sidebar.toggle(), open = true)"
                            class="sidebar-link w-full {{ request()->routeIs($group['match']) ? 'text-white' : '' }}"
                            :class="$store.sidebar.open ? '' : 'justify-center px-0'"
                            x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                        <i data-lucide="{{ $group['icon'] }}" class="w-5 h-5 flex-shrink-0"></i>
                        <span class="flex-1 text-left whitespace-nowrap overflow-hidden" x-show="$store.sidebar.open" x-transition.opacity>{{ $group['title'] }}</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 flex-shrink-0 transition-transform duration-200" :class="open && 'rotate-180'" x-show="$store.sidebar.open"></i>
                        <div x-show="hover && !$store.sidebar.open" x-transition.opacity class="sidebar-tooltip" style="display:none;">{{ $group['title'] }}</div>
                    </button>
                    <div x-show="open && $store.sidebar.open" x-collapse style="display:none;" class="mt-1 ml-4 pl-3 border-l border-sidebar-border space-y-0.5">
                        @foreach($visible as $item)
                            @php [$label, $route, $icon, $pattern] = $item; @endphp
                            <a href="{{ route($route) }}" title="{{ $label }}" class="sidebar-sublink {{ request()->routeIs($pattern) ? 'active' : '' }}">
                                <i data-lucide="{{ $icon }}" class="w-4 h-4 flex-shrink-0"></i>
                                <span class="truncate">{{ $label }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Flat group --}}
                <div class="pt-2 first:pt-0">
                    @if(!empty($group['label']))
                        <p class="sidebar-group-title" x-show="$store.sidebar.open" x-transition.opacity>{{ $group['label'] }}</p>
                        <div x-show="!$store.sidebar.open" class="border-t border-sidebar-border my-2 mx-1" style="display:none;"></div>
                    @endif
                    @foreach($visible as $item)
                        @php [$label, $route, $icon, $pattern] = $item; $badgeId = $item[4] ?? null; @endphp
                        <a href="{{ route($route) }}" title="{{ $label }}" class="sidebar-link {{ request()->routeIs($pattern) ? 'active' : '' }}"
                           :class="$store.sidebar.open ? '' : 'justify-center px-0'"
                           x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                            <i data-lucide="{{ $icon }}" class="w-5 h-5 flex-shrink-0"></i>
                            <span class="flex-1 whitespace-nowrap overflow-hidden" x-show="$store.sidebar.open" x-transition.opacity>{{ $label }}</span>
                            @if($badgeId)
                                <span id="{{ $badgeId }}" class="hidden absolute top-1.5 right-2 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold rounded-full bg-red-500 text-white"></span>
                            @endif
                            <div x-show="hover && !$store.sidebar.open" x-transition.opacity class="sidebar-tooltip" style="display:none;">{{ $label }}</div>
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </nav>

    {{-- Collapse toggle --}}
    <div class="border-t border-sidebar-border p-2 flex-shrink-0 hidden lg:block">
        <button type="button" @click="$store.sidebar.toggle()" class="sidebar-link w-full" :class="$store.sidebar.open ? '' : 'justify-center px-0'">
            <i data-lucide="chevrons-left" class="w-5 h-5 flex-shrink-0" x-show="$store.sidebar.open"></i>
            <i data-lucide="chevrons-right" class="w-5 h-5 flex-shrink-0" x-show="!$store.sidebar.open" style="display:none;"></i>
            <span class="flex-1 text-left whitespace-nowrap overflow-hidden" x-show="$store.sidebar.open" x-transition.opacity>Свернуть</span>
            <kbd class="text-[10px] text-sidebar-muted border border-sidebar-border rounded px-1 py-0.5" x-show="$store.sidebar.open" x-transition.opacity>Ctrl B</kbd>
        </button>
    </div>
</aside>

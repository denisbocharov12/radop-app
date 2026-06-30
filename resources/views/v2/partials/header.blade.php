<script>window.__navItems = @json($navFlat ?? []);</script>

<header class="sticky top-0 z-30 flex items-center h-16 gap-2 px-4 sm:px-6 bg-white border-b border-gray-200">
    <button type="button" @click="$store.sidebar.toggleMobile()" class="btn-icon lg:hidden" aria-label="Меню">
        <i data-lucide="menu" class="w-5 h-5"></i>
    </button>
    <button type="button" @click="$store.sidebar.toggle()" class="btn-icon hidden lg:inline-flex" aria-label="Свернуть меню">
        <i data-lucide="panel-left" class="w-5 h-5"></i>
    </button>

    <nav class="hidden sm:flex items-center text-sm text-gray-500" aria-label="Breadcrumb">
        <a href="{{ route('dashboard.index') }}" class="hover:text-brand-600 transition-colors"><i data-lucide="home" class="w-4 h-4"></i></a>
        @hasSection('breadcrumb')
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 mx-2 text-gray-300"></i>
            @yield('breadcrumb')
        @endif
    </nav>

    <div class="ml-auto flex items-center gap-2">
        {{-- Command palette --}}
        <div x-data="commandPalette()" @command-palette-toggle.window="toggle()" @keydown.escape.window="close()">
            <button type="button" @click="toggle()"
                    class="flex items-center gap-2 h-9 px-3 rounded-lg border border-gray-200 text-gray-400 hover:border-gray-300 hover:text-gray-600 transition-colors text-sm">
                <i data-lucide="search" class="w-4 h-4"></i>
                <span class="hidden md:inline">Поиск…</span>
                <kbd class="hidden md:inline text-[10px] text-gray-400 border border-gray-200 rounded px-1 py-0.5 ml-1">Ctrl K</kbd>
            </button>

            <div x-show="open" style="display:none;" class="fixed inset-0 z-[95] flex items-start justify-center pt-20 sm:pt-24 px-4">
                <div class="absolute inset-0 bg-gray-900/40" @click="close()" x-show="open" x-transition.opacity></div>
                <div class="relative w-full max-w-lg bg-white rounded-xl shadow-2xl overflow-hidden" x-show="open"
                     x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="flex items-center gap-3 px-4 border-b border-gray-100">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        <input x-ref="input" x-model="q" type="text" placeholder="Поиск разделов…"
                               class="flex-1 h-12 outline-none text-sm text-gray-900 placeholder-gray-400 bg-transparent"
                               @keydown.arrow-down.prevent="move(1)" @keydown.arrow-up.prevent="move(-1)" @keydown.enter.prevent="go()"
                               @input="active = 0; $nextTick(() => window.renderIcons && window.renderIcons())">
                        <kbd class="text-[10px] text-gray-400 border border-gray-200 rounded px-1 py-0.5">Esc</kbd>
                    </div>
                    <ul class="max-h-80 overflow-y-auto py-2">
                        <template x-for="(r, i) in results" :key="r.url">
                            <li>
                                <a :href="r.url" @mouseenter="active = i"
                                   class="flex items-center gap-3 px-4 py-2 text-sm"
                                   :class="i === active ? 'bg-brand-50 text-brand-700' : 'text-gray-700 hover:bg-gray-50'">
                                    <i :data-lucide="r.icon" class="w-4 h-4 flex-shrink-0" :class="i === active ? 'text-brand-600' : 'text-gray-400'"></i>
                                    <span class="flex-1" x-text="r.label"></span>
                                    <span class="text-xs text-gray-400" x-text="r.group"></span>
                                </a>
                            </li>
                        </template>
                        <li x-show="results.length === 0" class="px-4 py-6 text-center text-sm text-gray-400">Ничего не найдено</li>
                    </ul>
                    <div class="flex items-center gap-4 px-4 py-2 border-t border-gray-100 text-[11px] text-gray-400">
                        <span><kbd class="border border-gray-200 rounded px-1">↑</kbd><kbd class="border border-gray-200 rounded px-1 ml-0.5">↓</kbd> навигация</span>
                        <span><kbd class="border border-gray-200 rounded px-1">↵</kbd> открыть</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- User dropdown --}}
        <div x-data="dropdown" class="relative">
            <button type="button" @click="toggle()" class="flex items-center gap-2 hover:bg-gray-50 rounded-lg px-2 py-1.5 transition-colors">
                <div class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center text-white text-sm font-medium">
                    {{ mb_substr(optional(Auth::user()->profile)->first_name ?? Auth::user()->name, 0, 1) }}
                </div>
                <div class="hidden md:block text-left leading-tight">
                    <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-400 capitalize">{{ Auth::user()->getRoleNames()->first() }}</div>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 hidden md:block"></i>
            </button>
            <div x-show="open" @click.outside="close()"
                 x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="dropdown-menu w-60" style="display:none;">
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="text-sm font-medium text-gray-900 truncate">{{ optional(Auth::user()->profile)->first_name }} {{ optional(Auth::user()->profile)->last_name }}</div>
                    <div class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</div>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item-danger">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Выйти
                </a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>
</header>

@props(['editUrl' => null, 'showUrl' => null, 'deleteUrl' => null, 'deleteName' => ''])

<div x-data="dropdown({ floating: true })" class="relative inline-block text-left">
    <button type="button" x-ref="trigger" @click.stop="toggle()" class="btn-icon">
        <i data-lucide="more-horizontal" class="w-5 h-5"></i>
    </button>
    <div x-ref="menu" x-show="open" @click.outside="close()"
         @keydown.escape.window="close()" @scroll.window="open && close()"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="dropdown-menu z-[70]" style="display:none;">
        @if($showUrl)
            <a href="{{ $showUrl }}" class="dropdown-item"><i data-lucide="eye" class="w-4 h-4"></i> Просмотр</a>
        @endif
        @if($editUrl)
            <a href="{{ $editUrl }}" class="dropdown-item"><i data-lucide="pencil" class="w-4 h-4"></i> Редактировать</a>
        @endif
        {{ $slot }}
        @if($deleteUrl)
            <button type="button" class="dropdown-item-danger w-full text-left"
                    @click="close(); $dispatch('open-delete', { url: '{{ $deleteUrl }}', name: '{{ $deleteName }}' })">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Удалить
            </button>
        @endif
    </div>
</div>

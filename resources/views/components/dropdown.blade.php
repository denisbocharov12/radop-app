@props(['align' => 'right', 'width' => 'w-48'])

<div x-data="dropdown" class="relative inline-block text-left">
    <div @click="toggle()">
        {{ $trigger }}
    </div>
    <div x-show="open" @click.outside="close()"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="dropdown-menu {{ $width }} {{ $align === 'left' ? 'left-0' : 'right-0' }}" style="display:none;">
        {{ $slot }}
    </div>
</div>

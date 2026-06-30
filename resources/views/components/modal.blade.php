@props(['name', 'title' => null, 'maxWidth' => 'max-w-lg'])

{{-- Open with $dispatch('open-modal', '<name>'), close with $dispatch('close-modal', '<name>') --}}
<div x-data="{ open: false }"
     x-on:open-modal.window="if ($event.detail === '{{ $name }}') { open = true; $nextTick(() => window.renderIcons && window.renderIcons()); }"
     x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false"
     x-on:keydown.escape.window="open = false"
     x-show="open" style="display:none;"
     class="fixed inset-0 z-[80] flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-gray-900/50" @click="open = false" x-show="open" x-transition.opacity></div>

    <div class="relative bg-white rounded-xl shadow-2xl w-full {{ $maxWidth }} max-h-[90vh] overflow-y-auto" x-show="open"
         x-transition:enter="ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        @if($title)
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 sticky top-0 bg-white">
                <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
                <button type="button" @click="open = false" class="btn-icon"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
        @endif
        <div class="p-5">{{ $slot }}</div>
        @isset($footer)
            <div class="flex justify-end gap-2 px-5 py-4 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">{{ $footer }}</div>
        @endisset
    </div>
</div>
